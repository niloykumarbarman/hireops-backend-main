<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CompanyCost;
use Illuminate\Http\Request;

class CompanyCostController extends Controller
{

    // LIST
    public function index()
    {
        return CompanyCost::with('company')->latest()->get();
    }

    // CREATE
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable',
            'cost_date' => 'required|date'
        ]);

        $cost = CompanyCost::create($data);

        return response()->json([
            'message' => 'Company cost created',
            'data' => $cost
        ]);
    }

    // SHOW
    public function show($id)
    {
        return CompanyCost::with('company')->findOrFail($id);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $cost = CompanyCost::findOrFail($id);

        $data = $request->validate([
            'company_id' => 'required|exists:companies,id',
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'description' => 'nullable',
            'cost_date' => 'required|date'
        ]);

        $cost->update($data);

        return response()->json([
            'message' => 'Company cost updated',
            'data' => $cost
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        CompanyCost::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Company cost deleted'
        ]);
    }

   public function companyCosts($company_id)
{
    $costs = CompanyCost::where('company_id', $company_id)->get();

    return response()->json([
        'message' => 'Company wise costs list',
        'data' => $costs
    ]);
}

}
