<?php

namespace Vne\Member\App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model implements AuthenticatableContract, CanResetPasswordContract{
    use Authenticatable, CanResetPassword, Notifiable, SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $guard = "member";

    protected $table = 'members';

    protected $primaryKey = 'member_id';

    protected $guarded = ['member_id'];

    protected $fillable = ['name'];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['deleted_at'];
}