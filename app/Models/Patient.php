<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use CrudTrait;
    use HasFactory;

    // Make rows fillable so that the could be changed
    protected $fillable = [
        'name',
        'surname',
        'phone',
        'area',
        'price',
        'doctor_name',
        'room_number',
        'bill_type',
        'feedback',
        'date',
    ];
}
