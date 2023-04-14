<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelCounterColumnsToClubLevels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('club_levels', function (Blueprint $table) {
            $table->unsignedBigInteger('counter1')->default(0);
            $table->unsignedBigInteger('counter2')->default(0);
            $table->unsignedBigInteger('counter3')->default(0);
            $table->unsignedBigInteger('counter4')->default(0);
            $table->unsignedBigInteger('counter5')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('club_levels', function (Blueprint $table) {
            //
        });
    }
}
