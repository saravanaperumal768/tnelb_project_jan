<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Admin\MstRoles;

class Mst_Staffs_Tbl extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'mst__staffs__tbls'; // Follow table naming convention

    protected $fillable = ['user_id','name', 'email', 'password', 'role_id', 'staff_name', 'name', 'email', 'handle_forms', 'status', 'updated_by'];

    protected $hidden = ['password'];

    public function role() {
        return $this->belongsTo(MstRoles::class, 'role_id');
    }
}
