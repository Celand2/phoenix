<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('preferred_payment_method_id')->nullable()->after('role')->constrained('payment_methods')->nullOnDelete();
            $table->string('preferred_currency', 10)->nullable()->after('preferred_payment_method_id');
            $table->decimal('preferred_rate', 15, 6)->nullable()->after('preferred_currency');
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->decimal('amount_usd', 15, 2)->nullable()->after('payment_method_id');
            $table->decimal('amount_local', 15, 2)->nullable()->after('amount_usd');
            $table->string('currency_local', 10)->nullable()->after('amount_local');
            $table->decimal('exchange_rate', 15, 6)->nullable()->after('currency_local');
        });

        Schema::table('withdrawals', function (Blueprint $table) {
            $table->decimal('amount_requested_local', 15, 2)->nullable()->after('amount_received');
            $table->decimal('fee_local', 15, 2)->nullable()->after('amount_requested_local');
            $table->decimal('amount_received_local', 15, 2)->nullable()->after('fee_local');
            $table->string('currency_local', 10)->nullable()->after('amount_received_local');
            $table->decimal('exchange_rate', 15, 6)->nullable()->after('currency_local');
        });
    }

    public function down(): void
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn([
                'amount_requested_local',
                'fee_local',
                'amount_received_local',
                'currency_local',
                'exchange_rate',
            ]);
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn([
                'amount_usd',
                'amount_local',
                'currency_local',
                'exchange_rate',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('preferred_payment_method_id');
            $table->dropColumn(['preferred_currency', 'preferred_rate']);
        });
    }
};
