<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            // Foreign Key to Services
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            
            $table->string('title');
            $table->text('description')->nullable();
            
            $table->enum('discount_type', ['percentage', 'fixed_amount', 'new_price']);
            $table->decimal('discount_value', 8, 2);
            
            $table->dateTime('starts_at');
            $table->dateTime('ends_at');
            $table->boolean('is_scheduled_day')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
