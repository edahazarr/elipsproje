<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderByDesc('id')->get();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        Company::create([
            'name' => $data['name'],
            'is_active' => true,
        ]);

        return redirect()->route('companies.index')->with('success', 'Şirket oluşturuldu.');
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
{
    $data = $request->validate([
        'name' => ['required', 'string', 'max:255'],
    ]);

    $company->update($data);

    return redirect()->route('companies.index')->with('success', 'Şirket güncellendi.');
}


    public function toggle(Company $company)
    {
        $company->update(['is_active' => ! $company->is_active]);

        return redirect()->route('companies.index')->with('success', 'Şirket durumu güncellendi.');
    }
}
