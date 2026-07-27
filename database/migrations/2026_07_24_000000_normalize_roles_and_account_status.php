<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', 'admin')->update(['role' => 'super_admin']);
        DB::table('users')->where('role', 'partner')->update(['role' => 'tenant']);
        DB::table('users')->where('role', 'buyer')->update(['role' => 'user']);
        DB::table('users')->whereNull('status')->orWhere('status', 'active')->update(['status' => 'Active']);
        DB::table('users')->where('status', 'suspended')->update(['status' => 'Suspended']);

        DB::table('partners')->whereNull('status')->orWhere('status', 'active')->update(['status' => 'Active']);
        DB::table('partners')->where('status', 'suspended')->update(['status' => 'Suspended']);

        DB::table('partners')
            ->join('users', 'users.email', '=', 'partners.email')
            ->where('users.role', 'tenant')
            ->whereNull('partners.user_id')
            ->update(['partners.user_id' => DB::raw('users.id')]);

        Schema::table('users', function (Blueprint $table) {
            $table->string('status')->default('Active')->change();
        });

        Schema::table('partners', function (Blueprint $table) {
            $table->string('status')->default('Active')->change();
        });
    }

    public function down(): void
    {
        DB::table('users')->where('role', 'super_admin')->update(['role' => 'admin']);
        DB::table('users')->where('role', 'tenant')->update(['role' => 'partner']);
        DB::table('users')->where('role', 'user')->update(['role' => 'buyer']);
        DB::table('users')->where('status', 'Active')->update(['status' => 'active']);
        DB::table('users')->where('status', 'Suspended')->update(['status' => 'suspended']);
        DB::table('partners')->where('status', 'Active')->update(['status' => 'active']);
        DB::table('partners')->where('status', 'Suspended')->update(['status' => 'suspended']);
    }
};