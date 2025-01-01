<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WorkingTime extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'date', 'begin', 'end'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function calculateWorkedHoursAfterLastVacation($userId, $currentVacationId = null)
    {
        $lastVacation = Vacation::where('user_id', $userId)
            ->when($currentVacationId, function ($query) use ($currentVacationId) {
                return $query->where('id', '!=', $currentVacationId);
            })
            ->orderBy('end_date', 'desc')
            ->first();

        $startDate = $lastVacation ? Carbon::parse($lastVacation->end_date)->addDay() : self::where('user_id', $userId)->min('date');

        if (!$startDate) {
            return 0;
        }

        $workingTimes = self::where('user_id', $userId)
            ->where('date', '>=', $startDate)
            ->whereNotNull('end')
            ->get();

        $totalWorkedHours = $workingTimes->sum(function ($workingTime) {
            $begin = Carbon::parse($workingTime->begin);
            $end = Carbon::parse($workingTime->end);

            return $end->greaterThan($begin) ? $end->diffInHours($begin) : 0;
        });

        return $totalWorkedHours * -1;
    }
}
