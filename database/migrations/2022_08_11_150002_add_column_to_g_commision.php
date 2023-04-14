<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToGCommision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('g_commisions', function (Blueprint $table) {
            $table->unsignedBigInteger('generation')->nullable()->after('gen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('g_commisions', function (Blueprint $table) {
            $table->dropColumn('generation');
        });
    }
}
