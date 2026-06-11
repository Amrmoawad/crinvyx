<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $columns = array_filter([
            Schema::hasColumn('users', 'email') ? 'email' : null,
            Schema::hasColumn('users', 'email_verified_at') ? 'email_verified_at' : null,
        ]);

        if ($columns !== []) {
            Schema::table('users', function (Blueprint $table) use ($columns): void {
                $table->dropColumn($columns);
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('email')->nullable()->unique()->after('full_name');
            $table->timestamp('email_verified_at')->nullable()->after('email');
        });
    }
};
