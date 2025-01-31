<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInventoryItemsTable extends Migration
{
    public function up()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            // Add new columns
            $table->string('storage_unit')->default('pieces')->after('stock_quantity');
            $table->string('usage_unit')->default('pieces')->after('storage_unit');
            $table->decimal('conversion_factor', 10, 4)->default(1)->after('usage_unit');
            
            // Modify existing column (example)
            $table->decimal('cost_per_unit', 12, 4)->change();
        });
    }

    public function down()
    {
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropColumn(['storage_unit', 'usage_unit', 'conversion_factor']);
            $table->decimal('cost_per_unit', 10, 2)->change();
        });
    }
}
