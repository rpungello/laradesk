<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'domain' => ['nullable', 'contains:.'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', Company::class);
    }
}
