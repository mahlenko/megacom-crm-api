<?php

namespace App\Services;

use App\Models\User;
use DomainException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UserService implements ServiceInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string $password
     * @param int $external_id
     * @return User
     */
    public static function registration(string $name, string $email, string $password, int $external_id): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'external_user_id' => $external_id,
        ]);
    }

    /**
     * @param string $email
     * @param string $password
     * @param string|null $token_name
     * @return string
     */
    public static function createToken(string $email, string $password, string $token_name = null): string
    {
        /* @var User $user */
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new InvalidArgumentException('Пользователь с такой комбинацией email и пароля не найден.', 404);
        }

        if (!$token_name) $token_name = Uuid::uuid4();
        $token = $user->createToken($token_name);

        return $token->plainTextToken;
    }

    /**
     * @param int $user_id
     * @return MorphMany
     */
    public static function tokens(int $user_id): MorphMany
    {
        /* @var User $user */
        $user = User::findOrFail($user_id);

        return $user->tokens();
    }

    /**
     * @param int $user_id
     * @return bool|null
     */
    public static function delete(int $user_id): ?bool
    {
        if (Auth::id() !== $user_id) {
            throw new DomainException('', Response::HTTP_FORBIDDEN);
        }

        /* @var User $user */
        $user = User::findOrFail($user_id);
        $user->tokens()->delete();

        return $user->delete();
    }
}
