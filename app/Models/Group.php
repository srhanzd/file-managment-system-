<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table="groups";
    protected $fillable = [
        'name',
        'creator_id',
        'description',
        'updated_at',
        'created_at'
    ];
    use HasFactory;
 public function users(){
     return $this->belongsToMany(User::class,'groupusers');
 }public function files(){
     return $this->belongsToMany(File::class,'groupfiles');
 }
    public function user(){
        return $this->belongsTo(User::class,'creator_id','id');
    }
}
