<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShowTablesWithColumns extends Command
{
    protected $signature = 'db:show-tables-columns';
    protected $description = 'Display all tables and their columns in the connected database';

    public function handle()
    {
        $database = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . $database;

        if (empty($tables)) {
            $this->info("No tables found in the database.");
            return;
        }

        foreach ($tables as $tableObj) {
            $tableName = $tableObj->$key;
            $this->info("📄 Table: {$tableName}");

            $columns = Schema::getColumnListing($tableName);

            foreach ($columns as $column) {
                $type = Schema::getColumnType($tableName, $column);
                $this->line("   - {$column} ({$type})");
            }

            $this->line(str_repeat('-', 40));
        }
    }
}
