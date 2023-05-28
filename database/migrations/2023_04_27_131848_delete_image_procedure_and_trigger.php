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
        DB::unprepared('CREATE PROCEDURE `delete_image`(
            IN image_id INT
          )
          BEGIN
            DELETE FROM images WHERE id = image_id;
          END;');
    
        DB::unprepared('CREATE TRIGGER `delete_image_trigger`
            AFTER DELETE ON `images`
            FOR EACH ROW
            BEGIN
              INSERT INTO deleted_images (text, image, deleted_at)
              VALUES (OLD.text, OLD.image, NOW());
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS `delete_image_trigger`');
        DB::unprepared('DROP PROCEDURE IF EXISTS `delete_image`');
    }
};
