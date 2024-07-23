<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     */
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $employees = Employee::withTrashed()->paginate(10);
        } else {
            $employees = Employee::whereNull('deleted_at')->paginate(10);
        }

        return view('employees.index', compact('employees'));
    }


    /**
     * Show the form for creating a new employee.
     */
    public function create()
    {
        // Get all companies to populate the company select dropdown
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }

    /**
     * Store a newly created employee in storage.
     */
    public function store(EmployeeRequest $request)
    {
        // Handle file upload
        $data = $request->validated();
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filePath = $file->store('profile_pics', 'public');
            $data['profile_pic'] = $filePath;
        }

        Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }


    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        // Ensure the profile_pic path is available
        $profilePicUrl = $employee->profile_pic ? asset('storage/' . $employee->profile_pic) : null;

        return view('employees.show', compact('employee', 'profilePicUrl'));
    }

    /**
     * Show the form for editing the specified employee.
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all();

        if (request()->ajax()) {
            return view('employees._edit_form', compact('employee', 'companies'));
        }

        return view('employees.edit', compact('employee', 'companies'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        if ($request->hasFile('profile_pic')) {
            // Delete the old profile picture if it exists
            if ($employee->profile_pic) {
                Storage::disk('public')->delete($employee->profile_pic);
            }

            // Store the new profile picture
            $file = $request->file('profile_pic');
            $data['profile_pic'] = $file->store('profile_pics', 'public');
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }


    /**
     * Remove the specified employee from storage.
     */
    public function destroy(Employee $employee)
    {
        // Soft delete the employee record
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    /**
     * Search for employees based on the query parameter.
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'nullable|string|max:255',
        ]);

        $query = $request->input('query', '');

        // Perform a search on the employees table based on the full name
        $employees = Employee::where(function ($q) use ($query) {
            $q->where('first_name', 'LIKE', "%{$query}%")
                ->orWhere('last_name', 'LIKE', "%{$query}%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$query}%"]);
        })->paginate(10);

        if ($request->ajax()) {
            return view('partials._employee_table', compact('employees'))->render();
        }

        return view('employees.index', compact('employees'));
    }
}
