<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $primaryKey = 'RoleID';
     protected $fillable = [
        'UserID',
        'RoleID',
        'RoleName',];

    public function permissions()
    {
        return $this->hasMany(RolePermission::class, 'RoleID');
    }
}
