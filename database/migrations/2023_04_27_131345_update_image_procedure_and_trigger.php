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
        DB::unprepared('CREATE PROCEDURE `update_image`(
            IN image_id INT,
            IN text_value TEXT,
            IN image_name VARCHAR(255)
          )
          BEGIN
            UPDATE images
            SET text = text_value, image = image_name
            WHERE id = image_id;
          END;');
      
        DB::unprepared('CREATE TRIGGER `update_image_trigger`
          BEFORE UPDATE ON `images`
          FOR EACH ROW
          BEGIN
            SET NEW.updated_at = NOW();
          END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS `update_image`');
        DB::unprepared('DROP TRIGGER IF EXISTS `update_image_trigger`');
    }
};
