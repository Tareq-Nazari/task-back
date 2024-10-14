<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'assigned_to',
        'owner_id',
        'parent_id',
        'priority',
        'title',
        'desc',
        'status',
        'estimated_time'
    ];
    
    public function owner(){
        return $this->belongsTo(User::class,'owner_id','id');
    }
}
