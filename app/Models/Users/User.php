<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $connection = 'app_mysql';

    /**
     * @var bool
     */
    public $timestamps = false;
}
