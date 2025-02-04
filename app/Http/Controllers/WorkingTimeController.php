<?php

namespace App\Http\Controllers;

use App\Models\WorkingTime;
use App\Http\Requests\StoreWorkingTimeRequest;
use App\Http\Requests\UpdateWorkingTimeRequest;
use App\Models\SickLeave;
use App\Models\User;
use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WorkingTimeController extends Controller
{
    public function index(Request $request): View
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $workingTimes = WorkingTime::with('user')
            ->whereDate('date', $date)
            ->paginate(10);

        return view('dashboard.working-times.index', compact('workingTimes', 'date'));
    }

    public function home(Request $request): View
    {
        $today = now()->format('Y-m-d');

        $workingTimes = WorkingTime::where('user_id', $request->user()->id)
            ->where('date', $today)
            ->paginate(10);

        $unfinishedWorkingTime = WorkingTime::where('user_id', $request->user()->id)
            ->where('date', $today)
            ->whereNull('end')
            ->exists();

        return view('home', compact('workingTimes', 'unfinishedWorkingTime'));
    }

    public function create(): View
    {
        $users = User::all();
        return view('dashboard.working-times.create', compact('users'));
    }

    public function edit($id): View
    {
        $workingTime = WorkingTime::findOrFail($id);
        $users = User::all();

        return view('dashboard.working-times.edit', compact('workingTime', 'users'));
    }

    public function store(StoreWorkingTimeRequest $request)
    {
        $userId = $request->user_id;
        $date = $request->date;
        $begin = Carbon::parse($request->begin);
        $end = Carbon::parse($request->end);

        $overlappingSickLeave = SickLeave::where('user_id', $userId)
            ->where(function ($query) use ($date) {
                $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
            })
            ->exists();

        if ($overlappingSickLeave) {
            return redirect()->route('dashboard.working-times.create')->with('status', 'working-time-cannot-be-created-during-sick-leave');
        }

        $overlappingVacation = Vacation::where('user_id', $userId)
            ->where(function ($query) use ($date) {
                $query->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date);
            })
            ->exists();

        if ($overlappingVacation) {
            return redirect()->route('dashboard.working-times.create')->with('status', 'working-time-cannot-be-created-during-vacation');
        }

        $overlappingHours = WorkingTime::where('user_id', $userId)
            ->where('date', $date)
            ->where(function ($query) use ($begin, $end) {
                $query->whereBetween('begin', [$begin, $end])
                    ->orWhereBetween('end', [$begin, $end])
                    ->orWhere(function ($query) use ($begin, $end) {
                        $query->where('begin', '<=', $begin)
                            ->where('end', '>=', $end);
                    });
            })
            ->exists();

        if ($overlappingHours) {
            return redirect()->route('dashboard.working-times.create')->with('status', 'time-overlaps-with-existing-working-hours');
        }

        WorkingTime::create([
            'user_id' => $userId,
            'date' => $date,
            'begin' => $begin,
            'end' => $end
        ]);

        return redirect()->route('dashboard.working-times.index')->with('status', 'working-hours-successfully-created');
    }

    public function update(UpdateWorkingTimeRequest $request, $id)
    {
        $workingTime = WorkingTime::findOrFail($id);

        $begin = Carbon::parse($request->begin);
        $end = Carbon::parse($request->end);

        $overlappingSickLeave = SickLeave::where('user_id', $request->user_id)
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<=', $request->date)
                    ->where('end_date', '>=', $request->date);
            })
            ->exists();

        if ($overlappingSickLeave) {
            return redirect()->route('dashboard.working-times.edit', $id)->with('status', 'working-time-cannot-be-updated-during-sick-leave');
        }

        $overlappingVacation = Vacation::where('user_id', $request->user_id)
            ->where(function ($query) use ($request) {
                $query->where('start_date', '<=', $request->date)
                    ->where('end_date', '>=', $request->date);
            })
            ->exists();

        if ($overlappingVacation) {
            return redirect()->route('dashboard.working-times.edit', $id)->with('status', 'working-time-cannot-be-updated-during-vacation');
        }

        $overlappingHours = WorkingTime::where('user_id', $request->user_id)
            ->where('date', $request->date)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($begin, $end) {
                $query->whereBetween('begin', [$begin, $end])
                    ->orWhereBetween('end', [$begin, $end])
                    ->orWhere(function ($query) use ($begin, $end) {
                        $query->where('begin', '<=', $begin)
                            ->where('end', '>=', $end);
                    });
            })
            ->exists();

        if ($overlappingHours) {
            return redirect()->route('dashboard.working-times.edit', $id)->with('status', 'time-overlaps-with-existing-working-hours');
        }

        $workingTime->update([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'begin' => $begin,
            'end' => $end,
        ]);

        return redirect()->route('dashboard.working-times.index')->with('status', 'working-hours-successfully-updated');
    }

    public function workStarted(Request $request)
    {
        $overlappingSickLeave = SickLeave::where('user_id', $request->user()->id)
            ->where(function ($query) {
                $query->where('start_date', '<=', now()->format('Y-m-d'))
                    ->where('end_date', '>=', now()->format('Y-m-d'));
            })
            ->exists();

        if ($overlappingSickLeave) {
            return redirect()->route('home')->with('status', 'working-time-cannot-be-started-during-sick-leave');
        }

        $overlappingVacation = Vacation::where('user_id', $request->user()->id)
            ->where(function ($query) {
                $query->where('start_date', '<=', now()->format('Y-m-d'))
                    ->where('end_date', '>=', now()->format('Y-m-d'));
            })
            ->exists();

        if ($overlappingVacation) {
            return redirect()->route('home')->with('status', 'working-time-cannot-be-started-during-vacation');
        }

        WorkingTime::create([
            'user_id' => $request->user()->id,
            'date' => now()->format('Y-m-d'),
            'begin' => now()->format('H:i:s'),
            'end' => null,
        ]);

        return redirect()->route('home')->with('status', 'working-time-successfully-started');
    }

    public function workEnded(Request $request)
    {
        $today = now()->format('Y-m-d');
        $workingTime = WorkingTime::where('user_id', $request->user()->id)
            ->where('date', $today)
            ->whereNull('end')
            ->first();

        if (!$workingTime) {
            return redirect()->route('home')->with('status', 'working-time-not-started');
        }

        $workingTime->update([
            'end' => now()->format('H:i:s'),
        ]);

        return redirect()->route('home')->with('status', 'working-time-successfully-ended');
    }

    public function destroy($id)
    {
        $workingTime = WorkingTime::findOrFail($id);
        $workingTime->delete();

        return redirect()->route('dashboard.working-times.index')->with('status', 'working-hours-successfully-deleted');
    }
}
