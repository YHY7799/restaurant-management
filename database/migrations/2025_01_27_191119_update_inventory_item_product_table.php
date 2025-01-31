<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventory_item_product', function (Blueprint $table) {
            // Rename quantity to quantity_used
            $table->renameColumn('quantity', 'quantity_used');

            // Change column type to decimal
            $table->decimal('quantity_used', 12, 4)->change();
        });
    }

    public function down()
    {
        Schema::table('inventory_item_product', function (Blueprint $table) {
            $table->renameColumn('quantity_used', 'quantity');
            $table->integer('quantity')->change();
        });
    }
};
