<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class artikels extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table  = 'artikels'; 
    protected $hidden = [
        'updated_at',
        'created_at',
        'id',
    ];   
}
