<?php

namespace App\Http\Requests;

use App\Models\Attachment;
use Illuminate\Foundation\Http\FormRequest;

class AttachmentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'comment_id' => ['required', 'exists:comments'],
            'disk' => ['required'],
            'path' => ['required'],
            'file' => ['required', 'file', 'max:51200'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', Attachment::class);
    }
}
