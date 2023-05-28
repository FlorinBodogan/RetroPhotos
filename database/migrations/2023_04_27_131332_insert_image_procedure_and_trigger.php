<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('CREATE PROCEDURE `insert_image`(
            IN text_value TEXT,
            IN image_name VARCHAR(255),
            IN user_id INT
          )
          BEGIN
            INSERT INTO images (text, image, user_id)
            VALUES (text_value, image_name, user_id);
          END;');

        DB::unprepared('CREATE TRIGGER `insert_image_trigger`
        BEFORE INSERT ON `images`
        FOR EACH ROW
        BEGIN
          SET NEW.created_at = NOW();
        END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS `insert_image`');
        DB::unprepared('DROP TRIGGER IF EXISTS `insert_image_trigger`');
    }
};
