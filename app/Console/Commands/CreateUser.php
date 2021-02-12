<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
require_once 'vendor/autoload.php';
class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-users {--N|name= : Name of the user} {--E|email= : Email of the user} {--P|password= : Password of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or update a user in the database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
  
    }
}
