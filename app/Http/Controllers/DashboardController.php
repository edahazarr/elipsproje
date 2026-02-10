<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCompanies  = Company::count();
        $activeCompanies = Company::where('is_active', 1)->count();

        $totalUsers  = User::count();
        $activeUsers = User::where('is_active', 1)->count();

        return view('dashboard', compact(
            'totalCompanies',
            'activeCompanies',
            'totalUsers',
            'activeUsers'
        ));
    }
}
