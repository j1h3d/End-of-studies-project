<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('cascade');

            $table->string('cp_registration');
            $table->string('social_reason');
            $table->string('adress')->nullable();
            $table->string('city')->nullable();
            $table->string('pays')->nullable();
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
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropForeign(['entreprises_user_id_foreign']);
            $table->dropForeign(['entreprises_admin_id_foreign']);
        });
        Schema::dropIfExists('entreprises');
    }
}
