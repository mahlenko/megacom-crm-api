<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $connection = 'app_mysql';

    /**
     * @var string
     */
    protected $table = 'users_groups';

    /**
     * @var array
     */
    protected $fillable = [
        'group_id',
        'user_id'
    ];

    /**
     * @var bool
     */
    public $timestamps = false;
}
