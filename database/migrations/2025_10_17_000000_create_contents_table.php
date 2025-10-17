<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index();
            $table->text('idea');
            $table->string('title')->nullable();
            $table->string('caption')->nullable();
            $table->text('video_prompt')->nullable();
            $table->string('image_ref');
            $table->string('aspect_ratio')->default('portrait');
            $table->string('style')->default('professional');
            $table->string('status')->default('draft');
            $table->string('video_output')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
