<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        $departments = Department::paginate(10);
        return view('dashboard.departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('dashboard.departments.create');
    }

    public function store(StoreDepartmentRequest $request)
    {
        Department::create($request->only('name'));

        return redirect()->route('dashboard.departments.index')->with('status', 'department-created');
    }

    public function edit(int $id): View
    {
        $department = Department::findOrFail($id);
        return view('dashboard.departments.edit', compact('department'));
    }

    public function update(UpdateDepartmentRequest $request, int $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->only('name'));

        return redirect()->route('dashboard.departments.index')->with('status', 'department-updated');
    }

    public function destroy(Request $request, int $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->route('dashboard.departments.index')->with('status', 'department-deleted');
    }
}
