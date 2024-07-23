<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

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
        Employee::create($request->validated());
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     */
    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
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
        $employee->update($request->validated());
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
    
        // Get the search query input or set it to an empty string if not provided
        $query = $request->input('query', '');
    
        // Perform a search on the employees table based on the query
        $employees = Employee::where('first_name', 'LIKE', "%{$query}%")
                            ->orWhere('last_name', 'LIKE', "%{$query}%")
                            ->orWhere('email', 'LIKE', "%{$query}%")
                            ->paginate(10);
    
        if ($request->ajax()) {
            return view('partials._employee_table', compact('employees'))->render();
        }
    
        return view('employees.index', compact('employees'));
    }
}