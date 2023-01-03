<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReimbursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reimburses', function (Blueprint $table) {
            $table->id();
            $table->integer('approver_id')->nullable();
            $table->integer('submitted_id');
            $table->string("category");
            $table->string("description_purchase");
            $table->date('date_purchase');
            $table->integer("amount");
            $table->string("path_file");
            $table->enum("status", ["pending", "approved", "rejected"]);
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
        Schema::dropIfExists('reimburses');
    }
}
