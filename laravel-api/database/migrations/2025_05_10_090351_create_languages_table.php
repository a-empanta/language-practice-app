<?php

use App\Enums\SpeechGeneratorEngine;
use App\Enums\SpeechGeneratorGender;
use App\Enums\TranscriberAIModels;
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
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('speech_generator_engine', SpeechGeneratorEngine::all())->nullable();
            $table->enum('transcriber_ai_model', TranscriberAIModels::all())->nullable();
            $table->string('speech_generator_language_code')->nullable();
            $table->string('speech_generator_voice_id')->nullable();
            $table->enum('speech_generator_gender', SpeechGeneratorGender::all())->nullable();
            $table->json('phrases')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
