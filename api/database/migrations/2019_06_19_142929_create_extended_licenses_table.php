<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtendedLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_licenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('tenants')->default(1);
            $table->bigInteger('internal_users_per_tenant')->nullable();
            $table->bigInteger('internal_users')->nullable();
            $table->bigInteger('external_users_per_tenant')->nullable();
            $table->bigInteger('external_users')->nullable();
            $table->timestamp('valid_since')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->string('signature');
            $table->text('file');
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
        Schema::dropIfExists('user_licenses');
    }
}
