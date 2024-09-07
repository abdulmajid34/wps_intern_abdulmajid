<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'description',
        'status',
        'file',
    ];

    /**
     * Get the employee that owns the daily log.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
