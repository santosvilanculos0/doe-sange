<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function bloodType()
    {
        return $this->belongsTo(BloodType::class);
    }
}
