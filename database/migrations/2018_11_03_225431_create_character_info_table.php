<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharacterInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_info', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('name');
            $table->enum('race', array(
              'dwarf', 'elf', 'halfling', 'human',
              'dragonborn', 'gnome', 'half-elf', 'half-orc', 'tiefling'
            ));
            $table->enum('class', array(
              'barbarian', 'bard', 'cleric', 'druid',
              'fighter', 'monk', 'paladin', 'ranger',
              'rogue', 'sorcerer', 'warlock', 'wizard'
            ));
            $table->boolean('sex');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('character_info');
    }
}
