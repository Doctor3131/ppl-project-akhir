<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TestDbConnection extends Command
{
    /**
     * Nama command untuk dipanggil di terminal.
     */
    protected $signature = 'db:check';

    /**
     * Deskripsi command.
     */
    protected $description = 'Mengecek koneksi database (Script Porting)';

    /**
     * Eksekusi command.
     */
    public function handle()
    {
        try {
            // Coba melakukan koneksi (mirip pool.connect())
            // Jika gagal, dia akan langsung melempar Exception ke catch block
            DB::connection()->getPdo();

            // Ambil variable dari env/config
            $dbName = Config::get('database.connections.pgsql.database');
            $dbUser = Config::get('database.connections.pgsql.username');
            $dbHost = Config::get('database.connections.pgsql.host'); // Location
            $dbPort = Config::get('database.connections.pgsql.port');
            $appEnv = Config::get('app.env'); // Node Env equivalent

            // Output formatting (Meniru logger.info contoh kamu)
            $this->newLine();
            $this->info('----------------testConnection result--------------------');
            $this->info('Database connection successful.');
            $this->info(" -> Location:      $dbHost");
            $this->info(" -> Database:      $dbName");
            $this->info(" -> DB PORT :      $dbPort");
            $this->info(" -> User    :      $dbUser");
            $this->info(" -> App Env :      $appEnv");
            $this->info('----------------testConnection result--------------------');
            $this->newLine();

            return 0; // Exit code 0 (Success)

        } catch (\Exception $e) {
            // Error handling (Meniru logger.error)
            $this->error('Database connection failed: '.$e->getMessage());

            return 1; // Exit code 1 (Error)
        }
    }
}
