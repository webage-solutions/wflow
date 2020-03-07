<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('ip_addresses')->nullable();
            $table->boolean('allow_multi_tenancy')->default(false);
            $table->timestamp('valid_since')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->string('signature');
            $table->text('file');
            $table->boolean('active')->default(true);
            $table->timestamp('added_at')->nullable(); // created_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('licenses');
    }
}
