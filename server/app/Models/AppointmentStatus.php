<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentStatus extends Model
{
    use HasFactory;

    protected $guarded = [];

    const SCHEDULED = 1;
    const COMPLETED = 2;
    const CANCELED = 3;
}
