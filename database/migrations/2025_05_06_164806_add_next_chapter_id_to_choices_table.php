<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('choices', function (Blueprint $table) {
            $table->integer('next_chapter_id')->nullable(); // Ajoute la colonne next_chapter_id
        });
    }

    public function down()
    {
        Schema::table('choices', function (Blueprint $table) {
            $table->dropColumn('next_chapter_id'); // Supprime la colonne si la migration est annulée
        });
    }

};
