<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'patient_information', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('contact_phone')->nullable();
                $table->string('weight')->nullable();
                $table->string('height')->nullable();
                $table->string('other_info')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_information');
    }
};
