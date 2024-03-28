<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PDF_crud extends Model
{
    use HasFactory;

    protected $table = "p_d_f_cruds";
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'c_password',
        'gender',
        'img',
        'status',
    ];
    

}
