<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'doctor_id',
        'room_id',
        'bill_id',
        'feedback',
        'date',
    ];

    public function doctor(): BelongsTo{
        return $this->belongsTo(Doctor::class);
    }

    public function room(): BelongsTo{
        return $this->belongsTo(Room::class);
    }

    public function bill(): BelongsTo{
        return $this->belongsTo(Bill::class);
    }

    public function packet(): BelongsTo{
        return $this->belongsTo(Packet::class);
    }

    // public static function getDataWithDoctorName(){
    //     // join tables
    //     $patients = Patient::join('doctors', 'patients.doctor_id', '=', 'doctors.id')
    //         ->select('patients.*', 'doctors.name as doctor_name')
    //         ->get();
    // }
}
