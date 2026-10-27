<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiteSetting;
use App\Models\TestResult;
use App\Models\ProductComponent;
use App\Models\TeamMember;
use App\Models\TestVideo;

class SyncDatabaseSeeder extends Command
{
    protected $signature = 'seeder:sync';
    protected $description = 'Ekspor perubahan dari database/admin ke file DatabaseSeeder.php';

    public function handle(): int
    {
        $this->info('Mengambil data terbaru dari database...');

        // 1. Site Settings (Landing images & admin credentials)
        $settings = SiteSetting::all(['key', 'label', 'group', 'type', 'value'])
            ->map(function ($s) {
                return [
                    'key' => $s->key,
                    'label' => $s->label,
                    'group' => $s->group,
                    'type' => $s->type,
                    'value' => $s->value ?? '',
                ];
            })->toArray();

        // 2. Test Results
        $tests = TestResult::all(['test_code', 'parameter', 'category', 'result_value', 'target_value', 'unit', 'status', 'notes'])
            ->map(function ($t) {
                return [
                    'test_code' => $t->test_code,
                    'parameter' => $t->parameter,
                    'category' => $t->category,
                    'result_value' => (float)$t->result_value,
                    'target_value' => (float)$t->target_value,
                    'unit' => $t->unit,
                    'status' => $t->status,
                    'notes' => $t->notes ?? '',
                ];
            })->toArray();

        // 3. Product Components
        $components = ProductComponent::orderBy('sort_order')->get(['name', 'code', 'category', 'description', 'specification', 'image_path', 'sort_order'])
            ->map(function ($c) {
                return [
                    'name' => $c->name,
                    'code' => $c->code ?? '',
                    'category' => $c->category,
                    'description' => $c->description,
                    'specification' => $c->specification ?? '',
                    'image_path' => $c->image_path,
                    'sort_order' => (int)$c->sort_order,
                ];
            })->toArray();

        // 4. Team Members
        $teams = TeamMember::orderBy('sort_order')->get(['name', 'role', 'specialization', 'identity_number', 'bio', 'photo_path', 'linkedin_url', 'sort_order'])
            ->map(function ($tm) {
                return [
                    'name' => $tm->name,
                    'role' => $tm->role,
                    'specialization' => $tm->specialization ?? '',
                    'identity_number' => $tm->identity_number ?? '',
                    'bio' => $tm->bio ?? '',
                    'photo_path' => $tm->photo_path ?? '',
                    'linkedin_url' => $tm->linkedin_url,
                    'sort_order' => (int)$tm->sort_order,
                ];
            })->toArray();

        // 5. Test Videos
        $videos = TestVideo::orderBy('sort_order')->get(['video_key', 'title', 'badge', 'category', 'description', 'video_file', 'video_url', 'poster_image', 'sort_order'])
            ->map(function ($v) {
                return [
                    'video_key' => $v->video_key,
                    'title' => $v->title,
                    'badge' => $v->badge ?? '',
                    'category' => $v->category,
                    'description' => $v->description,
                    'video_file' => $v->video_file,
                    'video_url' => $v->video_url,
                    'poster_image' => $v->poster_image,
                    'sort_order' => (int)$v->sort_order,
                ];
            })->toArray();

        $seederContent = $this->buildSeederCode($settings, $tests, $components, $teams, $videos);

        $path = database_path('seeders/DatabaseSeeder.php');
        file_put_contents($path, $seederContent);

        $this->info("DatabaseSeeder.php berhasil disinkronkan dengan data database terkini!");
        $this->line("- Site Settings: " . count($settings) . " entri");
        $this->line("- Data Pengujian: " . count($tests) . " entri");
        $this->line("- Komponen Produk: " . count($components) . " entri");
        $this->line("- Tim Pengembang: " . count($teams) . " entri");
        $this->line("- Video Pengujian: " . count($videos) . " entri");

        return Command::SUCCESS;
    }

    private function exportArray(array $data, int $indent = 12): string
    {
        $spaces = str_repeat(' ', $indent);
        $itemSpaces = str_repeat(' ', $indent + 4);
        
        $lines = [];
        foreach ($data as $item) {
            $parts = [];
            foreach ($item as $k => $v) {
                $exportedVal = is_null($v) ? 'null' : var_export($v, true);
                $parts[] = var_export($k, true) . ' => ' . $exportedVal;
            }
            if (count($parts) <= 5 && !str_contains(implode('', $parts), "\n")) {
                $lines[] = $spaces . '[' . implode(', ', $parts) . '],';
            } else {
                $itemLines = [];
                foreach ($parts as $p) {
                    $itemLines[] = $itemSpaces . $p . ',';
                }
                $lines[] = $spaces . "[\n" . implode("\n", $itemLines) . "\n" . $spaces . "],";
            }
        }
        return implode("\n", $lines);
    }

    private function buildSeederCode(array $settings, array $tests, array $components, array $teams, array $videos): string
    {
        $settingsCode = $this->exportArray($settings, 12);
        $testsCode = $this->exportArray($tests, 12);
        $componentsCode = $this->exportArray($components, 12);
        $teamsCode = $this->exportArray($teams, 12);
        $videosCode = $this->exportArray($videos, 12);

        return <<<PHP
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteSetting;
use App\Models\TestResult;
use App\Models\ProductComponent;
use App\Models\TeamMember;
use App\Models\TestVideo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Site Settings (Landing images & general settings)
        \$settings = [
{$settingsCode}
        ];

        foreach (\$settings as \$s) {
            SiteSetting::updateOrCreate(['key' => \$s['key']], \$s);
        }

        // 2. Data Pengujian (Grafik & Tabel Hasil Uji)
        \$tests = [
{$testsCode}
        ];

        foreach (\$tests as \$t) {
            TestResult::updateOrCreate(['test_code' => \$t['test_code']], \$t);
        }

        // 3. Komponen Produk HI 102
        \$components = [
{$componentsCode}
        ];

        foreach (\$components as \$c) {
            ProductComponent::updateOrCreate(['name' => \$c['name']], \$c);
        }

        // 4. Tim Pengembang
        \$teams = [
{$teamsCode}
        ];

        foreach (\$teams as \$tm) {
            TeamMember::updateOrCreate(['identity_number' => \$tm['identity_number']], \$tm);
        }

        // 5. Video Pengujian
        \$videos = [
{$videosCode}
        ];

        foreach (\$videos as \$v) {
            TestVideo::updateOrCreate(['video_key' => \$v['video_key']], \$v);
        }
    }
}

PHP;
    }
}
