<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
        //create and initialize a faker generator
        $faker = \Faker\Factory::create();
        //if the email option has not been provided generate a test email
        $email = $this->option('email') === null || empty($this->option('email')) ? $faker->unique()->email : $this->option('email');
        //if no account with email exists
        if(User::where('email', $email)->count() == 0){
            //insert the new user in the database
            $user = new User();
            $user->name = $this->option('name') === null || empty($this->option('name')) ? $faker->name : $this->option('name');
            $user->email = $email;
            $user->password = $this->option('password') === null || empty($this->option('password')) ? $faker->password : $this->option('password');
            $user->remember_token = Str::random(10);
            $user->save();
            //display a success message and the new user's data
            $this->info('A new user has been added, here is his information:');
            $this->info("name: $user->name | email: $user->email | password: $user->password");
        }
        //if a user already exists with the email provided
        else{
            //retrieve the existing user in the database
            $user = User::where('email', $email)->first();
            //ask for confirmation to overwrite existing data
            if ($this->confirm('A user already exists with this email, do you want to overwrite his information ?no')) {
                //keep in memory the un-hashed password
                $passwordBeforeHashed = $this->option('password') === null || empty($this->option('password')) ? 'the password has not changed' : $this->option('password');
                //update the name and password if the option is provided
                $this->option('name') === null || empty($this->option('name')) ? : $user->name = $this->option('name');
                $this->option('password') === null || empty($this->option('password')) ? : $user->password =  Hash::make($this->option('password'), ['rounds' => 16]);
                //display a success message and the new user's data
                $this->info("User$user->id information has been updated, here is his new information:");
                $this->info("name: $user->name | email: $user->email | password: $passwordBeforeHashed");
            }
        }
    }
}
