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
            'submissions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->string('title');
                $table->string('patient_id');
                $table->string('doctor_id')->nullable();
                $table->enum('status', ['PENDING', 'IN_PROGRESS', 'DONE'])->defaultValue('PENDING');
                $table->string('symptoms');
                $table->string('prescriptions')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign('doctor_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->foreign('patient_id')
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
        Schema::dropIfExists('submissions');
    }
};
