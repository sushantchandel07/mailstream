<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->text('mail_subject')->nullable();
            $table->text('mail_body')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->boolean('is_draft')->default(true);
            $table->boolean('draft_is_starred')->default(false);
            $table->boolean('draft_is_important')->default(false);
            $table->unsignedMediumInteger('user_id')->nullable();
            $table->timestamp('sent_at')->nullable();

            $table->index('is_sent');
            $table->index('is_draft');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
