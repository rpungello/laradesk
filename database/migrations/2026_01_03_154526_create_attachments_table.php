<?php

use App\Models\Comment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Comment::class)->constrained('comments')->cascadeOnDelete();
            $table->string('disk');
            $table->string('path');
            $table->string('auth_key');
            $table->unsignedInteger('size');
            $table->string('content_type');
            $table->string('client_filename')->index();

            $table->timestamps();
            $table->index([
                'created_at',
                'comment_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
