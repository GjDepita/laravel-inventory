<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('title');
            $table->string('image')->nullable();   // Store image filename or URL
            $table->string('pcn')->nullable();
            $table->string('code_input')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('price', 10, 2);
            $table->string('tracing_number')->nullable();
            $table->string('serial_number')->nullable();
            $table->enum('module_location', [
                'Order',
                'Received',
                'Unreceived',
                'Labeling',
                'Stockroom'
            ])->default('Order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
