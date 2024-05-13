<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('like.tables.like'), function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->morphs('likeable');

            $table->boolean('type')->default(true);
            /**
             * values:
             *
             * true:  like
             * false: dislike
             */
        });

        cache()->forget('likes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('like.tables.like'));

        cache()->forget('likes');
    }
};
