<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change ENUM to include 'Order'
        DB::statement("ALTER TABLE products MODIFY module_location ENUM('Order', 'Received', 'Unreceived', 'Labeling', 'Stockroom') DEFAULT 'Order'");
    }

    public function down(): void
    {
        // Optional: Rollback to previous ENUM (without 'Order')
        DB::statement("ALTER TABLE products MODIFY module_location ENUM('Received', 'Unreceived', 'Labeling', 'Stockroom') DEFAULT 'Received'");
    }
};

