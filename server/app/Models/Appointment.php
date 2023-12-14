<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{

    use HasFactory;
    protected $guarded = [];
    protected $with = ['user'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function status()
    {
        return $this->belongsTo(AppointmentStatus::class, 'appointment_status_id', 'id');
    }
}
