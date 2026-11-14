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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'return_reason')) {
                $table->string('return_reason')->nullable()->after('dispatched_at');
            }
            if (!Schema::hasColumn('orders', 'return_courier_charge')) {
                $table->decimal('return_courier_charge', 10, 2)->default(0)->after('return_reason');
            }
            if (!Schema::hasColumn('orders', 'returned_at')) {
                $table->timestamp('returned_at')->nullable()->after('return_courier_charge');
            }
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('returned_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('orders', 'return_reason')) $cols[] = 'return_reason';
            if (Schema::hasColumn('orders', 'return_courier_charge')) $cols[] = 'return_courier_charge';
            if (Schema::hasColumn('orders', 'returned_at')) $cols[] = 'returned_at';
            if (Schema::hasColumn('orders', 'delivered_at')) $cols[] = 'delivered_at';
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};

