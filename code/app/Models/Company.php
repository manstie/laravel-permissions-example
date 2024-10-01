<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Company
 */
class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    const ADMIN_ID = 1;

    protected $casts = [
        'id' => 'int',
        'company_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'trading_name',
        'abn',
        'acn',
        'invoice_email',
        'phone',
        'fax',
        'company_id'
    ];

    public function parent_company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'company_users')
            ->using(CompanyUser::class);
    }
}
