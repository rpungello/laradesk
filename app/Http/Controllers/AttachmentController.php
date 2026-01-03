<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentRequest;
use App\Models\Attachment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AttachmentController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Attachment::class);

        return Attachment::all();
    }

    public function store(AttachmentRequest $request)
    {
        $this->authorize('create', Attachment::class);

        return Attachment::create($request->validated());
    }

    public function show(Attachment $attachment)
    {
        $this->authorize('view', $attachment);

        return $attachment;
    }

    public function update(AttachmentRequest $request, Attachment $attachment)
    {
        $this->authorize('update', $attachment);

        $attachment->update($request->validated());

        return $attachment;
    }

    public function destroy(Attachment $attachment)
    {
        $this->authorize('delete', $attachment);

        $attachment->delete();

        return response()->json();
    }
}
