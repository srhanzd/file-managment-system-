<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model
{
    protected $table="groupusers";
    public $timestamps=false;
    protected $fillable = [

//        'updated_at',
//        'created_at'
    ];
    use HasFactory;
}
