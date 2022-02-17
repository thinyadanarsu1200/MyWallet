<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherColumnToUsersTable extends Migration
{
  /**p
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->string('phone')->unique();
      $table->string('image')->nullable();
      $table->string('ip')->nullable();
      $table->text('user_agent')->nullable();
      $table->timestamp('login_at')->nullable();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn(['phone', 'image', 'ip', 'user_agent', 'login_at']);
    });
  }
}
