<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report_event extends Model
{
    use HasFactory;
    protected $table="report_events";
    protected $fillable = [
        'owner_id',
        'file_id',
        'file_name',
        'user_name',
        'event_datetime',
        'event',
        'upload_date'
//        'updated_at',
//        'created_at'
    ];
    public $timestamps=false;

    public function user(){
        return $this->belongsTo(User::class,'owner_id','id');
    } public function file(){
    return $this->belongsTo(File::class,'file_id','id');
}
}
