<?php

namespace Modules\Auth\App\Models;

use App\Models\SupportRequestChat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class Administrations extends Authenticatable
{
    use HasFactory,HasRoles;

    // public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['id','rec_date','fullname','mobile','email','password','staff_code','role','is_active','is_delete'];

    protected static function newFactory()
    {
        //return AdministrationsFactory::new();
    }

    public function supportRequestRemarks(){
        return $this->hasMany(SupportRequestChat::class,'staffid','id');
    }
}
