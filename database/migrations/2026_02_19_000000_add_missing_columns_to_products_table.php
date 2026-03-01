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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'supplier_id')) {
                $table->foreignId('supplier_id')->nullable()->after('category_id')->constrained('suppliers')->onDelete('set null');
            }
            if (!Schema::hasColumn('products', 'min_stock')) {
                $table->integer('min_stock')->default(0)->after('stock');
            }
            if (!Schema::hasColumn('products', 'unit')) {
                $table->string('unit', 20)->nullable()->after('min_stock');
            }
            if (!Schema::hasColumn('products', 'sales_frequency')) {
                $table->integer('sales_frequency')->default(0)->after('unit');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['supplier_id']);
            $table->dropColumn(['supplier_id', 'min_stock', 'unit', 'sales_frequency']);
        });
    }
};
