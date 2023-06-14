<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetToken extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    public $timestamps = false;

    protected $fillable = ['email','token'];
}
