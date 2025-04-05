<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSchemaHelper
{
    public static function getSchemaAsString(): string
    {
        $database = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLES');
        $key = 'Tables_in_' . $database;
        $schemaString = "Database Schema:\n";

        foreach ($tables as $tableObj) {
            $tableName = $tableObj->$key;
            $schemaString .= "\nTable: {$tableName}\n";
            $columns = Schema::getColumnListing($tableName);

            foreach ($columns as $column) {
                $type = Schema::getColumnType($tableName, $column);
                $schemaString .= "- {$column} ({$type})\n";
            }
        }

        return $schemaString;
    }
} 