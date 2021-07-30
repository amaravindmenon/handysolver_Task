<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoName extends Model
{
    use HasFactory;

    protected $table = 'todo_names';
    protected $fillable = ['name','category_id'];
}
