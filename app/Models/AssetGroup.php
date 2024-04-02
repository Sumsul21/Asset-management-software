<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetGroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'group_name',
        'group_code',
        'description',
        'status',
        'is_delete',
        'user_id'
    ];
}