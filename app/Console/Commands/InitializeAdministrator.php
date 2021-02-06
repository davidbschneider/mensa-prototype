<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InitializeAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:init {email} {name=admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize first  administrator';

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
        if(Admin::all()->count())
        {
            $this->error("Administrator is already intialized");
        }
        else
        {
            $v = Validator::make([
                'email' => $this->argument('email'),
                'name' => $this->argument('name'),
            ],[
                'email' => 'required|string|email',
                'name' => 'required|string',
            ]);
            $password = Str::random();
            $admin = new Admin($v->validate());
            $admin->name = 'admin';
            $admin->password = bcrypt($password);
            $admin->save();
            $this->info('Admin configured, password is: ' . $password);
        }
        return 0;
    }
}
