<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('role', 'tenant')
            ->orderBy('id')
            ->get(['id', 'name', 'email', 'status'])
            ->each(function (object $user): void {
                $exists = DB::table('partners')->where('user_id', $user->id)->exists();
                if ($exists) {
                    return;
                }

                DB::table('partners')->insert([
                    'user_id' => $user->id,
                    'name' => $user->name . ' Organization',
                    'logo_url' => 'https://placehold.co/200x200',
                    'email' => $user->email,
                    'status' => $user->status ?: 'Active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            });
    }

    public function down(): void
    {
        DB::table('partners')
            ->whereIn('user_id', DB::table('users')->where('role', 'tenant')->pluck('id'))
            ->delete();
    }
};
