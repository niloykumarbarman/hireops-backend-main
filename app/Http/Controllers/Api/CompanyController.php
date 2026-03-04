<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the companies (only own tenant).
     */
    public function index()
    {
        $companies = Company::where('tenant_id', Auth::user()->tenant_id)->get();
        return response()->json($companies);
    }

    /**
     * Store a newly created company.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:companies,email',
            'phone' => 'nullable|string|max:20',
        ]);

        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'tenant_id' => Auth::user()->tenant_id,
        ]);

        return response()->json([
            'message' => 'Company created successfully',
            'data' => $company
        ], 201);
    }

    /**
     * Display the specified company.
     */
    public function show(Company $company)
    {
        $this->authorizeCompany($company);
        return response()->json($company);
    }

    /**
     * Update the specified company.
     */
    public function update(Request $request, Company $company)
    {
        $this->authorizeCompany($company);

        $request->validate([
            'name'  => 'sometimes|required|string|max:255',
            'email' => 'sometimes|nullable|email|unique:companies,email,' . $company->id,
            'phone' => 'sometimes|nullable|string|max:20',
        ]);

        $company->update($request->only(['name', 'email', 'phone']));

        return response()->json([
            'message' => 'Company updated successfully',
            'data' => $company
        ]);
    }

    /**
     * Remove the specified company.
     */
    public function destroy(Company $company)
    {
        $this->authorizeCompany($company);

        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }

    /**
     * Check if company belongs to the authenticated user's tenant
     */
    private function authorizeCompany(Company $company)
    {
        if ($company->tenant_id !== Auth::user()->tenant_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
