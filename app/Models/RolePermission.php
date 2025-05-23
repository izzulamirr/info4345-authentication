<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
        protected $primaryKey = 'PermissionID';


    protected $fillable = [
        'RoleID',      // <-- Add this line
        'Description',
    ];

}
