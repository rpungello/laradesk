<?php

namespace App\Http\Requests;

use App\Enums\Visibility;
use App\Models\Comment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ticket_id' => ['required', 'exists:tickets'],
            'user_id' => ['required', 'exists:users'],
            'content' => ['required'],
            'visibility' => [
                'required',
                Rule::enum(Visibility::class)
            ],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', Comment::class);
    }
}
