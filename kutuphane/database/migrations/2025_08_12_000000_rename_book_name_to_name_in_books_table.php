<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'name')) {
                $table->string('name')->after('id');
            }
        });

        if (Schema::hasColumn('books', 'book_name')) {
            DB::table('books')->whereNotNull('book_name')->update([
                'name' => DB::raw('book_name')
            ]);

            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('book_name');
            });
        }
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'book_name')) {
                $table->string('book_name')->after('id');
            }
        });

        if (Schema::hasColumn('books', 'name')) {
            DB::table('books')->whereNotNull('name')->update([
                'book_name' => DB::raw('name')
            ]);

            Schema::table('books', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }
};


