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
    Schema::table('inventory_items', function (Blueprint $table) {
        $table->decimal('min_stock', 12, 4)->nullable()->after('stock_quantity');
        $table->boolean('low_stock_alert_sent')->default(false)->after('min_stock');
    });
}

public function down()
{
    Schema::table('inventory_items', function (Blueprint $table) {
        $table->dropColumn(['min_stock', 'low_stock_alert_sent']);
    });
}
};
