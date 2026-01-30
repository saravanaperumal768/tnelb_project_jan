<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MstStaff;

class MstRoles extends Model
{
    use HasFactory;

    protected $table = 'mst__roles';  // Explicitly defining table name
    protected $fillable = ['name'];

    public function staffMembers() {
        return $this->hasMany(Mst_Staffs_Tbl::class, 'role_id'); // Ensure foreign key is correctly mapped
    }
}