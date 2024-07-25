<?php

namespace JobMetric\Like\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property mixed user_id
 * @property mixed likeable_id
 * @property mixed likeable_type
 * @property mixed type
 * @property mixed user
 * @property mixed likeable
 * @property mixed disLikeable
 */
class Like extends Pivot
{
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => 'bool'
    ];

    public function getTable()
    {
        return config('like.tables.like', parent::getTable());
    }

    /**
     * user relationship
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * likeable relationship
     *
     * @return MorphTo
     */
    public function likeable(): MorphTo
    {
        return $this->morphTo()->where('type', true);
    }

    /**
     * disLikeable relationship
     *
     * @return MorphTo
     */
    public function disLikeable(): MorphTo
    {
        return $this->morphTo()->where('type', false);
    }
}
