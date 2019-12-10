<?php

namespace App;

use App\Traits\HasPermissionsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasPermissionsTrait, SoftDeletes;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'fullname'
    ];

    public function orgs()
    {
        return $this->belongsToMany(Organization::class, 'org_users', 'user_id', 'org_id')->withTimestamps();
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'created_by');
    }

    public function companyBranches()
    {
        return $this->hasMany(CompanyBranch::class, 'created_by');
    }

    public function companyContacts()
    {
        return $this->hasMany(CompanyContact::class, 'created_by');
    }

    public function workSchedules()
    {
        return $this->hasMany(WorkSchedule::class, 'created_by');
    }

    public function workDays()
    {
        return $this->hasMany(Workday::class, 'created_by');
    }

    public function workforce()
    {
        return $this->hasOne(Workforce::class, 'user_id');
    }

    public function settings()
    {
        return $this->hasOne(UserSettings::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
