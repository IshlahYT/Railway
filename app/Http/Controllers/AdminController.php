<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\TestResult;
use App\Models\ProductComponent;
use App\Models\TeamMember;
use App\Models\TestVideo;
use Illuminate\Support\Facades\Artisan;

class AdminController extends Controller
{
    // Cek autentikasi session sederhana
    private function checkAuth()
    {
        if (!session('hi102_admin_logged_in')) {
            return false;
        }
        return true;
    }

    public function loginForm()
    {
        $settings = SiteSetting::getMap();
        return view('admin.login', compact('settings'));
    }

    public function loginSubmit(Request $request)
    {
        $adminPass = SiteSetting::where('key', 'admin_password')->value('value') ?? 'admin123';
        if ($request->input('password') === $adminPass) {
            session(['hi102_admin_logged_in' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di Panel Admin CMS HI 102!');
        }
        return back()->with('error', 'Password Admin tidak valid!');
    }

    public function logout()
    {
        session()->forget('hi102_admin_logged_in');
        return redirect()->route('home');
    }

    public function dashboard()
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $settingsGrouped = SiteSetting::all()->groupBy('group');
        $settings = SiteSetting::getMap();
        $testResults = TestResult::orderBy('id', 'asc')->get();
        $components = ProductComponent::orderBy('sort_order', 'asc')->get();
        $teams = TeamMember::orderBy('sort_order', 'asc')->get();
        $videos = TestVideo::orderBy('sort_order', 'asc')->get();

        // Pindai berkas video di folder public/videos
        $availableVideos = [];
        $videosDir = public_path('videos');
        if (is_dir($videosDir)) {
            $files = scandir($videosDir);
            foreach ($files as $file) {
                if (!in_array($file, ['.', '..']) && preg_match('/\.(mp4|webm|mov|mkv)$/i', $file)) {
                    $availableVideos[] = 'videos/' . $file;
                }
            }
        }

        // Pindai berkas gambar di folder public/images/trolley
        $availableImages = [];
        $imagesDir = public_path('images/trolley');
        if (is_dir($imagesDir)) {
            $files = scandir($imagesDir);
            foreach ($files as $file) {
                if (!in_array($file, ['.', '..']) && preg_match('/\.(jpe?g|png|webp|svg|gif)$/i', $file)) {
                    $availableImages[] = 'images/trolley/' . $file;
                }
            }
        }

        return view('admin.dashboard', compact(
            'settings',
            'settingsGrouped',
            'testResults',
            'components',
            'teams',
            'videos',
            'availableVideos',
            'availableImages'
        ));
    }

    // Update Semua Elemen Teks, Angka, & Berkas Gambar Website
    public function updateSettings(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        // Simpan input teks / textarea biasa (abaikan token, method, active_tab, dan input berkas)
        foreach ($request->except(['_token', '_method', 'active_tab']) as $key => $value) {
            if (!$request->hasFile($key) && !preg_match('/_file$/', $key)) {
                $setting = SiteSetting::firstOrNew(['key' => $key]);
                $setting->value = $value !== null ? trim((string)$value) : '';
                if (!$setting->exists) {
                    $setting->label = ucwords(str_replace('_', ' ', $key));
                    $setting->group = 'images';
                    $setting->type  = 'text';
                }
                $setting->save();
            }
        }

        // Simpan input file gambar
        foreach ($request->allFiles() as $key => $file) {
            if ($file && $file->isValid()) {
                $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
                $cleanName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $cleanName) ?: 'card';
                $filename = time() . '_' . $cleanName . '.' . $extension;
                $destination = public_path('images/trolley');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
                $file->move($destination, $filename);
                $settingKey = preg_replace('/_file$/', '', $key);
                $setting = SiteSetting::firstOrNew(['key' => $settingKey]);
                $setting->value = 'images/trolley/' . $filename;
                if (!$setting->exists) {
                    $setting->label = ucwords(str_replace('_', ' ', $settingKey));
                    $setting->group = 'images';
                    $setting->type  = 'image';
                }
                $setting->save();
            } elseif ($file && !$file->isValid()) {
                $activeTab = $request->input('active_tab', 'landing_images');
                return redirect()->to(route('admin.dashboard') . '?tab=' . $activeTab)
                    ->with('error', 'Gagal mengunggah berkas: ' . $file->getErrorMessage())
                    ->with('active_tab', $activeTab);
            }
        }

        $activeTab = $request->input('active_tab', 'landing_images');
        return redirect()->to(route('admin.dashboard') . '?tab=' . $activeTab)
            ->with('success', 'Perubahan gambar, judul, badge, dan deskripsi card berhasil disimpan!')
            ->with('active_tab', $activeTab);
    }

    // =========================================================================
    // CRUD VIDEO PENGUJIAN TROLLEY & PENGECATAN
    // =========================================================================
    public function storeVideo(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $data = $request->only(['video_key', 'title', 'badge', 'category', 'description', 'video_url', 'sort_order']);

        // Upload Video File Lokal
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = 'vid_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destination = public_path('videos');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['video_file'] = 'videos/' . $filename;
        } elseif ($request->filled('existing_video_file')) {
            $data['video_file'] = $request->input('existing_video_file');
        }

        // Upload Poster Image
        if ($request->hasFile('poster_image')) {
            $file = $request->file('poster_image');
            $filename = 'poster_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destination = public_path('images/trolley');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['poster_image'] = 'images/trolley/' . $filename;
        } elseif ($request->filled('existing_poster_image')) {
            $data['poster_image'] = $request->input('existing_poster_image');
        }

        TestVideo::create($data);
        return back()->with('success', 'Video pengujian baru berhasil ditambahkan!');
    }

    public function updateVideo(Request $request, $id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $video = TestVideo::findOrFail($id);
        $data = $request->only(['video_key', 'title', 'badge', 'category', 'description', 'video_url', 'sort_order']);

        // Upload / Ganti Video File
        if ($request->hasFile('video_file')) {
            $file = $request->file('video_file');
            $filename = 'vid_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destination = public_path('videos');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['video_file'] = 'videos/' . $filename;
        } elseif ($request->filled('existing_video_file')) {
            $data['video_file'] = $request->input('existing_video_file') === '__REMOVE__' ? null : $request->input('existing_video_file');
        }

        // Upload / Ganti Poster Image
        if ($request->hasFile('poster_image')) {
            $file = $request->file('poster_image');
            $filename = 'poster_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destination = public_path('images/trolley');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['poster_image'] = 'images/trolley/' . $filename;
        } elseif ($request->filled('existing_poster_image')) {
            $data['poster_image'] = $request->input('existing_poster_image') === '__REMOVE__' ? null : $request->input('existing_poster_image');
        }

        $video->update($data);
        return back()->with('success', 'Video pengujian "' . $video->title . '" berhasil diperbarui!');
    }

    public function deleteVideo($id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');
        TestVideo::findOrFail($id)->delete();
        return back()->with('success', 'Video pengujian berhasil dihapus!');
    }

    // =========================================================================
    // CRUD DATA PENGUJIAN (TABEL & GRAFIK)
    // =========================================================================
    public function storeTest(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        TestResult::create($request->only([
            'test_code', 'parameter', 'category', 'result_value',
            'target_value', 'unit', 'status', 'notes'
        ]));

        return back()->with('success', 'Data hasil pengujian baru berhasil ditambahkan!');
    }

    public function updateTest(Request $request, $id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $test = TestResult::findOrFail($id);
        $test->update($request->only([
            'test_code', 'parameter', 'category', 'result_value',
            'target_value', 'unit', 'status', 'notes'
        ]));

        return back()->with('success', 'Data pengujian ' . $test->test_code . ' berhasil diperbarui!');
    }

    public function deleteTest($id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');
        TestResult::findOrFail($id)->delete();
        return back()->with('success', 'Data pengujian berhasil dihapus!');
    }

    // =========================================================================
    // CRUD KOMPONEN & GALERI IMPLEMENTASI
    // =========================================================================
    public function storeComponent(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $data = $request->only(['name', 'code', 'category', 'description', 'specification', 'sort_order']);
        
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $cleanName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $cleanName) ?: 'comp';
            $filename = time() . '_' . $cleanName . '.' . $extension;
            $destination = public_path('images/trolley');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['image_path'] = 'images/trolley/' . $filename;
        } elseif ($request->filled('existing_image')) {
            $data['image_path'] = $request->input('existing_image');
        } else {
            $data['image_path'] = $request->input('image_path', 'images/trolley/img8_full_front.jpeg');
        }

        ProductComponent::create($data);
        return redirect()->to(route('admin.dashboard') . '?tab=komponen')
            ->with('success', 'Komponen / Dokumentasi baru berhasil ditambahkan!')
            ->with('active_tab', 'komponen');
    }

    public function updateComponent(Request $request, $id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $comp = ProductComponent::findOrFail($id);
        $data = $request->only(['name', 'code', 'category', 'description', 'specification', 'sort_order']);
        // Jika category tidak dikirim, pertahankan category yang lama
        if (!$request->has('category') || empty($data['category'])) {
            unset($data['category']);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            if ($file->isValid()) {
                $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
                $cleanName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $cleanName = preg_replace('/[^a-zA-Z0-9_-]/', '', $cleanName) ?: 'comp';
                $filename = time() . '_' . $cleanName . '.' . $extension;
                $destination = public_path('images/trolley');
                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }
                $file->move($destination, $filename);
                $data['image_path'] = 'images/trolley/' . $filename;
            } else {
                return redirect()->to(route('admin.dashboard') . '?tab=komponen')
                    ->with('error', 'Gagal mengunggah gambar: ' . $file->getErrorMessage())
                    ->with('active_tab', 'komponen');
            }
        } elseif ($request->filled('existing_image')) {
            $data['image_path'] = $request->input('existing_image');
        } elseif ($request->filled('image_path')) {
            $data['image_path'] = $request->input('image_path');
        }

        $comp->update($data);
        return redirect()->to(route('admin.dashboard') . '?tab=komponen')
            ->with('success', 'Komponen "' . $comp->name . '" berhasil diperbarui!')
            ->with('active_tab', 'komponen');
    }

    public function deleteComponent($id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');
        ProductComponent::findOrFail($id)->delete();
        return redirect()->to(route('admin.dashboard') . '?tab=komponen')
            ->with('success', 'Komponen berhasil dihapus!')
            ->with('active_tab', 'komponen');
    }

    // =========================================================================
    // CRUD TIM PENGEMBANG
    // =========================================================================
    public function storeTeam(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $data = $request->only(['name', 'role', 'specialization', 'identity_number', 'bio', 'linkedin_url', 'sort_order']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'team_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destination = public_path('images/team');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['photo_path'] = 'images/team/' . $filename;
        } else {
            $data['photo_path'] = 'https://ui-avatars.com/api/?name=' . urlencode($data['name']) . '&background=f97316&color=fff&size=256';
        }

        TeamMember::create($data);
        return back()->with('success', 'Anggota tim baru berhasil ditambahkan!');
    }

    public function updateTeam(Request $request, $id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $member = TeamMember::findOrFail($id);
        $data = $request->only(['name', 'role', 'specialization', 'identity_number', 'bio', 'linkedin_url', 'sort_order']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'team_' . time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $destination = public_path('images/team');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }
            $file->move($destination, $filename);
            $data['photo_path'] = 'images/team/' . $filename;
        }

        $member->update($data);
        return back()->with('success', 'Data anggota tim "' . $member->name . '" berhasil diperbarui!');
    }

    public function deleteTeam($id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');
        TeamMember::findOrFail($id)->delete();
        return back()->with('success', 'Anggota tim berhasil dihapus!');
    }

    public function syncSeeder()
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');
        Artisan::call('seeder:sync');
        return back()->with('success', 'DatabaseSeeder.php berhasil diperbarui dengan seluruh perubahan dari admin!');
    }
}
