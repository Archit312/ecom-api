<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admin';
    protected $fillable = [
        'admin_email',
        'admin_password',
        'additional_email',
        'terms_and_conditions',
        'about_us'
    ];
}
