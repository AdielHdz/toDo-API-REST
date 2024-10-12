<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /* Field fillable allowed */
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'status',
        'expiration_date',
        'created_at'
    ];

    /* Doesn't show data when data is required */
    protected $hidden = [
        'user_id'
    ];

    /* Protect overwrite */
    /* protected $guarded = ['*']; */

    /* Timestamp only create column updated_at without created_at */
    public $timestamps = false;
    const UPDATED_AT = 'updated_at';


    public function user(): BelongsTo
    {
        $this->belongsTo(User::class);
    }
}
