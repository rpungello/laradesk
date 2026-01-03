<?php

use App\Enums\TicketStatus;
use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('title')->index();
            $table->string('status')->default(TicketStatus::New)->index();
            $table->string('type')->index();

            $table->foreignIdFor(User::class)->constrained('users')->restrictOnDelete();
            $table->foreignIdFor(User::class, 'assigned_user_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->foreignIdFor(Product::class)->nullable()->constrained()->restrictOnDelete();
            $table->foreignIdFor(Company::class)->nullable()->constrained()->restrictOnDelete();

            $table->unsignedTinyInteger('priority');
            $table->boolean('billable');
            $table->date('due_date')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
