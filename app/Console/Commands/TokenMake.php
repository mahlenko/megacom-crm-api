<?php

namespace App\Console\Commands;

use App\Console\ValidationData;
use App\Http\Requests\AuthorizationRequest;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Validation\ValidationException;

class TokenMake extends Command
{
    use ValidationData;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:users:token:make {email} {password} {--name= : Название токена, например "iPhone 13 Pro"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Выдать пользователю новый токен';

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
     * @throws ValidationException
     */
    public function handle(): int
    {
        $data = $this->validated([
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
            'token_name' => $this->option('name')
        ], new AuthorizationRequest());

        $token = UserService::createToken($data['email'], $data['password'], $data['token_name']);
        $this->comment('User token');
        $this->info($token);

        return self::SUCCESS;
    }
}
