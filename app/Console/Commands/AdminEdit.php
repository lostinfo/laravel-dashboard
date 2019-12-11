<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminEdit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:edit {username} {password?} {--supper-admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'admin:edit
                              {username: username}
                              {password?: password, default random 10}
                              {--supper-admin: is supper admin ? default false}';

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
     * @return mixed
     */
    public function handle()
    {
        $username        = $this->argument('username');
        $password        = $this->argument('password') ? $this->argument('password') : Str::random(10);
        $is_supper_admin = $this->option('supper-admin');

        $admin = Admin::whereUsername($username)->first();
        if (empty($admin)) {
            $admin = new Admin();
        }
        $admin->username        = $username;
        $admin->password        = Hash::make($password);
        $admin->is_supper_admin = $is_supper_admin;
        $admin->save();

        $this->table(['Username', 'Password', 'isSupperAdmin'], [
            [
                'username'        => $username,
                'password'        => $password,
                'is_supper_admin' => $is_supper_admin ? 'yes' : 'no',
            ]
        ]);
    }
}
