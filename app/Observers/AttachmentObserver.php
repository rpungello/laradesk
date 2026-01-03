<?php

namespace App\Observers;

use App\Models\Attachment;
use Illuminate\Support\Str;

class AttachmentObserver
{
    public function creating(Attachment $attachment): void
    {
        $attachment->auth_key = Str::random();
    }
}
