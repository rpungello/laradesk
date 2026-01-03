<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ViewAttachmentController extends Controller
{
    public function __invoke(Attachment $attachment, Request $request): Response
    {
        if ($attachment->auth_key !== $request->input('key')) {
            abort(401);
        }

        return Storage::disk($attachment->disk)->response(
            $attachment->path,
            $attachment->client_filename
        );
    }
}
