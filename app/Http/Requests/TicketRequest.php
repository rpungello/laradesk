<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'user_id' => ['required', 'exists:users'],
            'assigned_user_id' => ['nullable', 'exists:users'],
            'product_id' => ['nullable', 'exists:products'],
            'company_id' => ['nullable', 'exists:companies'],
            'billable' => ['boolean'],
            'priority' => ['required', 'integer'],
            'due_date' => ['nullable', 'date'],
            'type' => ['required'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', Ticket::class);
    }
}
