<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('active')->after('role');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            $table->string('email')->nullable()->after('name');
            $table->string('phone')->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('status')->default('active')->after('address');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('partner_id')->nullable()->after('id')->constrained('partners')->nullOnDelete();
            $table->string('status')->default('active')->after('poster_path');
        });

        \DB::table('partners')
            ->join('users', 'users.email', '=', 'partners.email')
            ->where('users.role', 'partner')
            ->update(['partners.user_id' => \DB::raw('users.id')]);
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('partner_id');
            $table->dropColumn('status');
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
            $table->dropColumn(['email', 'phone', 'address', 'status']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};