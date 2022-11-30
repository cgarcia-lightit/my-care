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
        Schema::table(
            'users', function (Blueprint $table) {
                $table->string('type_id')->after('email');

                $table->foreign('type_id')
                    ->references('id')
                    ->on('user_types')
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
        Schema::table(
            'users', function (Blueprint $table) {
                $table->dropForeign('users_type_id_foreign');
                $table->dropColumn('type_id');
            }
        );
    }
};
