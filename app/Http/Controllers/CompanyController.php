<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CompanyController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Company::class);

        return Company::all();
    }

    public function store(CompanyRequest $request)
    {
        $this->authorize('create', Company::class);

        return Company::create($request->validated());
    }

    public function show(Company $company)
    {
        $this->authorize('view', $company);

        return $company;
    }

    public function update(CompanyRequest $request, Company $company)
    {
        $this->authorize('update', $company);

        $company->update($request->validated());

        return $company;
    }

    public function destroy(Company $company)
    {
        $this->authorize('delete', $company);

        $company->delete();

        return response()->json();
    }
}
