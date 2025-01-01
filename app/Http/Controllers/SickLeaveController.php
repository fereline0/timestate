<?php

namespace App\Http\Controllers;

use App\Models\SickLeave;
use App\Http\Requests\StoreSickLeaveRequest;
use App\Http\Requests\UpdateSickLeaveRequest;
use App\Models\User;
use App\Models\WorkingTime;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SickLeaveController extends Controller
{
    public function index(Request $request): View
    {
        $sickLeaves = SickLeave::with('user')->orderBy('start_date', 'desc')->paginate(10);
        return view('dashboard.sick-leaves.index', compact('sickLeaves'));
    }

    public function edit($id): View
    {
        $sickLeave = SickLeave::findOrFail($id);
        $users = User::all();
        return view('dashboard.sick-leaves.edit', compact('sickLeave', 'users'));
    }

    public function update(UpdateSickLeaveRequest $request, $id)
    {
        $sickLeave = SickLeave::findOrFail($id);

        $overlappingSickLeave = SickLeave::where('user_id', $sickLeave->user_id)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->exists();

        if ($overlappingSickLeave) {
            return redirect()->route('dashboard.sick-leaves.index')->with('status', 'time-overlaps-with-existing-sick-leave');
        }

        $overlappingWorkingTime = WorkingTime::where('user_id', $sickLeave->user_id)
            ->where(function ($query) use ($request) {
                $query->where('date', '>=', $request->start_date)
                    ->where('date', '<=', $request->end_date);
            })
            ->exists();

        if ($overlappingWorkingTime) {
            return redirect()->route('dashboard.sick-leaves.edit')->with('status', 'time-overlaps-with-existing-working-time');
        }

        $sickLeave->update($request->validated());

        return redirect()->route('dashboard.sick-leaves.edit')->with('status', 'sick-leave-updated');
    }

    public function create(): View
    {
        $users = User::all();
        return view('dashboard.sick-leaves.create', compact('users'));
    }

    public function store(StoreSickLeaveRequest $request)
    {
        $overlappingSickLeave = SickLeave::where('user_id', $request->user_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->start_date)
                            ->where('end_date', '>=', $request->end_date);
                    });
            })
            ->exists();

        if ($overlappingSickLeave) {
            return redirect()->route('dashboard.sick-leaves.create')->with('status', 'time-overlaps-with-existing-sick-leave');
        }

        $overlappingWorkingTime = WorkingTime::where('user_id', $request->user_id)
            ->where(function ($query) use ($request) {
                $query->where('date', '>=', $request->start_date)
                    ->where('date', '<=', $request->end_date);
            })
            ->exists();

        if ($overlappingWorkingTime) {
            return redirect()->route('dashboard.sick-leaves.create')->with('status', 'time-overlaps-with-existing-working-time');
        }

        SickLeave::create($request->validated());

        return redirect()->route('dashboard.sick-leaves.index')->with('status', 'sick-leave-created');
    }

    public function destroy($id)
    {
        $sickLeave = SickLeave::findOrFail($id);

        $sickLeave->delete();

        return redirect()->route('dashboard.sick-leaves.index')->with('status', 'sick-leave-deleted');
    }
}
