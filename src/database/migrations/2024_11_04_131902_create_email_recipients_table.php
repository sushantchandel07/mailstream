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
        Schema::create('email_recipients', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('recipients_id');
            $table->unsignedMediumInteger('mail_id');
            $table->unsignedMediumInteger('sender_id');
            $table->boolean('is_spam')->default(false);
            $table->boolean('is_read')->default(false);
            $table->boolean('is_starred')->default(false);
            $table->boolean('is_trashed')->default(false);
            $table->boolean('is_archived')->default(false);
            $table->boolean('is_important')->default(false);

            $table->enum('recipient_type' , ['TO' , 'CC' , 'BCC'])->default('TO');
            $table->softDeletes();
            $table->timestamps();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_recipients');
    }
};

