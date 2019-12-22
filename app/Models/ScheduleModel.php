<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleModel extends Model
{
    //
    protected $connection = 'metalandmoss';
    protected $table = 'schedule';
    protected $fillable = ['title', 'start', 'end', 'is_all_day'];
}
