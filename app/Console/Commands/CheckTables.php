<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tables:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Tables:');
//        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
//        foreach ($tables as $table)
//        {
//            $cols = DB::getSchemaBuilder()->getColumnListing($table);
//            echo print_r($table) . "\n";
//            echo print_r($cols) . "\n";
//        }
//        print_r($tables);
    }
}
