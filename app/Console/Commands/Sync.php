<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync';

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
        $this->question('Syncing...');
        $pos = 0;
        $fails = 0;
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        foreach ($tables as $table)
        {
            try {
                $records = DB::table($table)->where('LASTUPDATEDDATETIME', '>', '2023-06-01')->get();
            }
            catch (\Exception $e)
            {
                $records = DB::table($table)->get();

            }
            foreach ($records as $record)
            {
                $pos++;
                unset($record->TIMEMASK2G);
                unset($record->TIMEMASK5G);
                unset($record->TIMEMASKMWT);
                $transferArray = ['table' => $table, 'record' => $record];
                try {
                    $request = Http::asForm()->post('http://3.145.70.131:8000/sync', $transferArray)
                        ->body();
                    if ($request == 'OK')
                    {
                        $this->info('Record no. ' . $pos . ' = ' . 'OK');
                    }
                    else
                    {
                        $this->error('Record no. ' . $pos . ' = ' . 'ERROR');
                        $fails++;
                    }
                }
                catch (\Exception $e)
                {
                    $this->error('Record no. ' . $pos . ' = ' . 'ERROR');
                    $fails ++;
                }
            }
        }
        if ($fails > 0)
        {
            $this->error( $fails .' records failed');
        }
        else
        {
            $this->info('All records synced');
        }
    }
}
