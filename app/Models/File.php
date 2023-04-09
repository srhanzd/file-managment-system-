<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table="files";
    protected $fillable = [
        'file_name',
        'path',
        'datetime',
//        'updated_at',
//        'created_at'
    ];
    public $timestamps=false;
    public function groups(){
        return $this->belongsToMany(Group::class,'groupfiles');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function user_lock(){
        return $this->belongsTo(User::class,'owner_id','id');
    }
    public function report_events(){
        return $this->hasMany(Report_event::class,'file_id','id');
    }
}
