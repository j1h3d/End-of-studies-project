<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePipelineStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pipeline_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sales_pipeline_id')->constrained('sales_pipelines')->onDelete('cascade');
            $table->string('step_name');
            $table->integer('step_order');
            $table->integer('step_percentage');
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
        Schema::dropIfExists('pipeline_steps');
    }
}
