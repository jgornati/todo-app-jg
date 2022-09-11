<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * @var \Illuminate\Support\Carbon|mixed
     */
    protected $table = "tasks";
    protected $fillable = ["title", "completed", "deleted"];

}
