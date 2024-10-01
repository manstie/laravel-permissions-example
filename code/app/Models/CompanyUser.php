<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\CompanyUser
 */
class CompanyUser extends Pivot
{
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'id' => 'int',
        'company_id' => 'int',
        'user_id' => 'int'
    ];

    protected $fillable = [
        'company_id',
        'user_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
