<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name');
            $table->string('type');
            $table->string('intro_image')->nullable();
            $table->string('screen_image')->nullable();
            $table->string('role');
            $table->date('date_deployed');
            $table->longText('overview')->nullable();
            $table->longText('concept_description')->nullable();
            $table->longText('development_description')->nullable(); 
            $table->string('github_repository')->nullable();
            $table->string('live')->nullable();
            $table->string('industry');
            $table->string('slug');
            $table->string('reason_if_unavailable')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
