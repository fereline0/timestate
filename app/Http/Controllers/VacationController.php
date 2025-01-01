<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use App\Http\Requests\StoreVacationRequest;
use App\Http\Requests\UpdateVacationRequest;
use App\Models\User;
use App\Models\WorkingTime;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VacationController extends Controller
{
    public function index(Request $request): View
    {
        $vacations = Vacation::with('user')->paginate(10);
        return view('dashboard.vacations.index', compact('vacations'));
    }

    public function create(): View
    {
        $users = User::all();
        return view('dashboard.vacations.create', compact('users'));
    }

    public function store(StoreVacationRequest $request)
    {
        $userId = $request->user_id;

        $workedHours = WorkingTime::calculateWorkedHoursAfterLastVacation($userId);

        $hoursPerVacationDay = 160;

        $accumulatedVacationDays = floor($workedHours / $hoursPerVacationDay);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $requestedDays = $endDate->diffInDays($startDate) * -1;

        if ($requestedDays > $accumulatedVacationDays) {
            return redirect()->back()->with('status', 'selected-date-is-beyond-the-allowed-limit');
        }

        $overlappingWorkingTimes = WorkingTime::where('user_id', $userId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            })
            ->exists();

        if ($overlappingWorkingTimes) {
            return redirect()->back()->with('status', 'vacation-cannot-overlap-working-hours');
        }

        Vacation::create($request->validated());

        return redirect()->route('dashboard.vacations.index')->with('status', 'vacation-created');
    }

    public function edit($id): View
    {
        $vacation = Vacation::findOrFail($id);
        $users = User::all();

        return view('dashboard.vacations.edit', compact('vacation', 'users'));
    }

    public function update(UpdateVacationRequest $request, $id)
    {
        $vacation = Vacation::findOrFail($id);
        $userId = $request->user_id;

        $workedHours = WorkingTime::calculateWorkedHoursAfterLastVacation($userId, $id);
        $hoursPerVacationDay = 160;
        $accumulatedVacationDays = floor($workedHours / $hoursPerVacationDay);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $requestedDays = $endDate->diffInDays($startDate) * -1;

        if ($requestedDays > $accumulatedVacationDays) {
            return redirect()->back()->with('status', 'selected-date-is-beyond-the-allowed-limit');
        }

        $overlappingWorkingTimes = WorkingTime::where('user_id', $userId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            })
            ->exists();

        if ($overlappingWorkingTimes) {
            return redirect()->back()->with('status', 'vacation-cannot-overlap-working-hours');
        }

        $vacation->update($request->validated());

        return redirect()->route('dashboard.vacations.index')->with('status', 'vacation-updated');
    }

    public function destroy($id)
    {
        $vacation = Vacation::findOrFail($id);
        $vacation->delete();

        return redirect()->route('dashboard.vacations.index')->with('status', 'vacations-deleted');
    }
}
