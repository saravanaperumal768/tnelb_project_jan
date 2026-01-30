<?php
namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Notifications\Notifiable;

class Register extends Model implements Authenticatable
{
    use HasFactory, AuthenticatableTrait; 
    use Notifiable;

    protected $table = 'tnelb_registers'; 
    // protected $primaryKey = 'id'; 

    protected $fillable = [
       'salutation', 'first_name', 'gender', 'mobile', 'email', 'address', 'state', 'district', 'pincode', 'login_id', 'lastname'
    ];
}

