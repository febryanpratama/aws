<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_activities', function (Blueprint $table) {
            // - week_id
            // - date_activities
            // - days worked = 1
            // - place
            // - plan_activites
            // - realization_activities
            // - time_start
            // - time_end
            // - status > enum('in_progres','done', 'canceled')
            // - evidance_link

            $table->id();
            $table->integer('week_id');
            $table->date('date_activities');
            $table->integer('days_worked')->default(1);
            $table->string('place')->nullable();
            $table->string('plan_activities')->nullable();
            $table->string('realization_activities')->nullable();
            $table->string('time_start')->default('08:00');
            $table->string('time_end')->default('17:00');
            $table->enum('status', ['in_progres', 'done', 'canceled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('week_activities');
    }
}
