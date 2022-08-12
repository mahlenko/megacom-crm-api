<?php

namespace App\Console\Commands;

use App\Console\ValidationData;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Registration extends Command
{
    use ValidationData;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:users:registration:self
        {email : Email пользователя}
        {password : Пароль пользователя. Минимум 8 символов}
        {--name= : Имя пользователя [required]}
        {--ext|external_user_id= : Внешний ID пользователя}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Регистрация пользователя в API';

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
            'name' => $this->option('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
            'external_user_id' => $this->option('external_user_id', null),
        ], new RegistrationRequest());

        UserService::registration(
            $data['name'],
            $data['email'],
            $data['password'],
            key_exists('external_user_id', $data) ? intval($data['external_user_id']) : null
        );

        return self::SUCCESS;
    }
}
