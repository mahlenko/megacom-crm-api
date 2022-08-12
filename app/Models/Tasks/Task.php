<?php

namespace App\Models\Tasks;

use App\Models\Users\Group;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Task extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $connection = 'app_mysql';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'users_groups',
        'date_start',
        'date_end',
        'date_check',
        'task_name',
        'note',
        'require_report',
        'system_status',
        'date_created',
    ];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasManyThrough
     */
    public function contractors(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            Group::class,
            'group_id',
            'id',
            'users_groups',
            'user_id',
        );
    }
}
