<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habiles extends Model
{
    use HasFactory;
    protected $table = "dias_no_habiles";
    protected $fillable = ['fecha'];
    public $timestamps = false;
}
