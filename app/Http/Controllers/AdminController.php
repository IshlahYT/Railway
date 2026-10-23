<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\TestResult;
use App\Models\ProductComponent;
use App\Models\TeamMember;

class AdminController extends Controller
{
    // Cek autentikasi session sederhana (Cocok untuk cPanel tanpa setup rumit)
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

        $settings = SiteSetting::all()->groupBy('group');
        $testResults = TestResult::orderBy('id', 'asc')->get();
        $components = ProductComponent::orderBy('sort_order', 'asc')->get();
        $teams = TeamMember::orderBy('sort_order', 'asc')->get();

        return view('admin.dashboard', compact('settings', 'testResults', 'components', 'teams'));
    }

    // Update Semua Elemen Teks & Statistik Website
    public function updateSettings(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        foreach ($request->except('_token') as $key => $value) {
            SiteSetting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Seluruh elemen teks dan angka website berhasil diperbarui!');
    }

    // CRUD Data Pengujian
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

    // CRUD Komponen & Upload Gambar Baru (Langsung ke folder public agar kompatibel cPanel murah)
    public function storeComponent(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $data = $request->only(['name', 'code', 'category', 'description', 'specification', 'sort_order']);
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/trolley'), $filename);
            $data['image_path'] = 'images/trolley/' . $filename;
        } else {
            $data['image_path'] = $request->input('image_path', 'images/trolley/img8_full_front.jpeg');
        }

        ProductComponent::create($data);
        return back()->with('success', 'Komponen / Dokumentasi berhasil ditambahkan!');
    }

    public function updateComponent(Request $request, $id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $comp = ProductComponent::findOrFail($id);
        $data = $request->only(['name', 'code', 'category', 'description', 'specification', 'sort_order']);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/trolley'), $filename);
            $data['image_path'] = 'images/trolley/' . $filename;
        }

        $comp->update($data);
        return back()->with('success', 'Komponen ' . $comp->name . ' berhasil diperbarui!');
    }

    public function deleteComponent($id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');
        ProductComponent::findOrFail($id)->delete();
        return back()->with('success', 'Komponen berhasil dihapus!');
    }

    // CRUD Tim Pengembang
    public function storeTeam(Request $request)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $data = $request->only(['name', 'role', 'specialization', 'identity_number', 'bio', 'linkedin_url', 'sort_order']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'team_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/team'), $filename);
            $data['photo_path'] = 'images/team/' . $filename;
        } else {
            $data['photo_path'] = 'https://ui-avatars.com/api/?name=' . urlencode($data['name']) . '&background=f97316&color=fff&size=256';
        }

        TeamMember::create($data);
        return back()->with('success', 'Anggota tim berhasil ditambahkan!');
    }

    public function updateTeam(Request $request, $id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');

        $member = TeamMember::findOrFail($id);
        $data = $request->only(['name', 'role', 'specialization', 'identity_number', 'bio', 'linkedin_url', 'sort_order']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'team_' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/team'), $filename);
            $data['photo_path'] = 'images/team/' . $filename;
        }

        $member->update($data);
        return back()->with('success', 'Data anggota tim berhasil diperbarui!');
    }

    public function deleteTeam($id)
    {
        if (!$this->checkAuth()) return redirect()->route('admin.login');
        TeamMember::findOrFail($id)->delete();
        return back()->with('success', 'Anggota tim berhasil dihapus!');
    }
}
