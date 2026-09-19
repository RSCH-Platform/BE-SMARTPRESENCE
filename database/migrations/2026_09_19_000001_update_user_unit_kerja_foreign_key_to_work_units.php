<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * In SMSP, the work unit model is App\Models\WorkUnit which uses table `work_units`.
     * The default nexaid-client package migration created `user_unit_kerja` with
     * `unit_kerja_id` foreign key referencing table `unit_kerja` (which is not used by SMSP).
     *
     * This migration:
     * 1. Creates user_unit_kerja pointing to work_units if the table doesn't exist yet.
     * 2. If it exists, drops the old FK pointing to `unit_kerja`.
     * 3. Cleans up any orphan rows where unit_kerja_id is not found in `work_units`.
     * 4. Adds a new FK on `unit_kerja_id` referencing `work_units(id)`.
     */
    public function up(): void
    {
        if (!Schema::hasTable('user_unit_kerja')) {
            Schema::create('user_unit_kerja', function (Blueprint $table) {
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('unit_kerja_id')->constrained('work_units')->cascadeOnDelete()->cascadeOnUpdate();
                $table->primary(['user_id', 'unit_kerja_id']);
                $table->timestamps();
            });
            return;
        }

        // Step 1: Drop old FK pointing to unit_kerja if it exists
        $this->dropForeignIfExists('user_unit_kerja', 'user_unit_kerja_unit_kerja_id_foreign');

        // Step 2: Delete orphan rows where unit_kerja_id does not exist in work_units
        if (Schema::hasTable('work_units')) {
            DB::statement('
                DELETE uk
                FROM user_unit_kerja uk
                LEFT JOIN work_units w ON uk.unit_kerja_id = w.id
                WHERE w.id IS NULL
            ');
        }

        // Step 3: Add new FK referencing work_units(id)
        Schema::table('user_unit_kerja', function (Blueprint $table) {
            $table->foreign('unit_kerja_id')
                  ->references('id')
                  ->on('work_units')
                  ->cascadeOnDelete()
                  ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('user_unit_kerja')) {
            return;
        }

        $this->dropForeignIfExists('user_unit_kerja', 'user_unit_kerja_unit_kerja_id_foreign');

        if (Schema::hasTable('unit_kerja')) {
            DB::statement('
                DELETE uk
                FROM user_unit_kerja uk
                LEFT JOIN unit_kerja u ON uk.unit_kerja_id = u.id
                WHERE u.id IS NULL
            ');

            Schema::table('user_unit_kerja', function (Blueprint $table) {
                $table->foreign('unit_kerja_id')
                      ->references('id')
                      ->on('unit_kerja')
                      ->cascadeOnDelete()
                      ->cascadeOnUpdate();
            });
        }
    }

    /**
     * Drop a foreign key only if it currently exists on the table.
     */
    private function dropForeignIfExists(string $table, string $constraintName): void
    {
        $exists = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
              AND TABLE_NAME   = ?
              AND CONSTRAINT_NAME = ?
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
        ", [$table, $constraintName]);

        if (!empty($exists)) {
            DB::statement("ALTER TABLE `{$table}` DROP FOREIGN KEY `{$constraintName}`");
        }
    }
};
