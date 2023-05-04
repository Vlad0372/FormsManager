<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('app_types')->insert(
            array(
                    array(
                        'type' => 'type_with_desc',
                        'has_description' => true
                    ),
                    array(
                        'type' => 'type_without_desc',
                        'has_description' => false
                    ),
                    array(
                        'type' => 'some_type',
                        'has_description' => false
                    ),
                    array(
                        'type' => 'some_type2',
                        'has_description' => true
                    ),
            ));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('roles')->delete();
    }
};
