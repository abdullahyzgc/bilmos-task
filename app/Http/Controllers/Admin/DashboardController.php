<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        try {
            $stats = $this->dashboardService->getDashboardStats();
            return view('admin.dashboard', compact('stats'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
} 