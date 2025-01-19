<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropAllTables extends Command
{
    protected $signature = 'db:drop-all';
    protected $description = 'Drop all tables from the database';

    public function handle()
    {
        if ($this->confirm('Are you sure you want to drop all tables? This action is irreversible!')) {
            Schema::disableForeignKeyConstraints();

            $tables = DB::select('SHOW TABLES');
            $tableKey = 'Tables_in_' . env('DB_DATABASE');

            foreach ($tables as $table) {
                $tableName = $table->$tableKey;
                Schema::drop($tableName);
                $this->info("Dropped table: $tableName");
            }

            Schema::enableForeignKeyConstraints();

            $this->info('All tables have been dropped successfully.');
        } else {
            $this->info('Action canceled.');
        }
    }
}
