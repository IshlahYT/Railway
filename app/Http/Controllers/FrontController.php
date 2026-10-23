<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\TestResult;
use App\Models\ProductComponent;
use App\Models\TeamMember;

class FrontController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getMap();
        $testResults = TestResult::orderBy('id', 'asc')->get();
        $components = ProductComponent::orderBy('sort_order', 'asc')->get();
        $teamCount = TeamMember::count();

        return view('home', compact('settings', 'testResults', 'components', 'teamCount'));
    }

    public function team()
    {
        $settings = SiteSetting::getMap();
        $teams = TeamMember::orderBy('sort_order', 'asc')->get();
        $testResults = TestResult::orderBy('id', 'asc')->get();

        return view('team', compact('settings', 'teams', 'testResults'));
    }
}
