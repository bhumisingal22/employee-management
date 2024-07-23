@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employee Details</h1>
    <div class="card">
        <div class="card-header">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </div>
        <div class="card-body">
            <p><strong>Company:</strong> {{ $employee->company->name }}</p>
            <p><strong>Email:</strong> {{ $employee->email }}</p>
            <p><strong>Phone:</strong> {{ $employee->phone }}</p>
            @if($employee->profile_pic)
                <p><strong>Profile Picture:</strong></p>
                <img src="{{ asset('storage/' . $employee->profile_pic) }}" alt="Profile Picture" class="img-fluid">
            @endif
        </div>
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-primary mt-3">Back to Employees</a>
</div>
@endsection