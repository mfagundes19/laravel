<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use LogsActivity;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    
    protected $table = ("user");
    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','remember_token','two_factor_recovery_codes','two_factor_secret'];
    protected $casts = ['email_verified_at' => 'datetime'];
    protected $appends = ['profile_photo_url'];

    public function role() {
        return $this->hasOne('App\Models\Role');
    }

    public function hasPermission($module, $permission)
    {
        $Role = new Role();
        $Role = $Role->find($this->role_id);
        if($Role->hasPermission($module, $permission)) {
            return true;
        }
        return false;
    }











}
