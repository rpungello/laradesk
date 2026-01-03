<?php

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Ticket::class)->constrained('tickets')->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained('users')->restrictOnDelete();
            $table->string('visibility');
            $table->text('content');

            $table->timestamps();

            $table->index([
                'ticket_id',
                'created_at',
                'visibility',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
