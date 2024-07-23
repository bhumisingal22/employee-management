@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Employee</h1>
    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
            @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="company_id">Company</label>
            <select id="company_id" name="company_id" class="form-control @error('company_id') is-invalid @enderror" required>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
            </select>
            @error('company_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="profile_pic">Profile Picture</label>
            <input type="file" id="profile_pic" name="profile_pic" class="form-control @error('profile_pic') is-invalid @enderror">
            @error('profile_pic')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<!-- Client-side Validation Script -->
<script>
    $(document).ready(function() {
        $('form').validate({
            rules: {
                first_name: {
                    required: true,
                    minlength: 2
                },
                last_name: {
                    required: true,
                    minlength: 2
                },
                company_id: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                phone: {
                    number: true
                },
                profile_pic: {
                    extension: "jpg|png|jpeg|gif"
                }
            },
            messages: {
                first_name: {
                    required: "Please enter your first name.",
                    minlength: "Your first name must consist of at least 2 characters."
                },
                last_name: {
                    required: "Please enter your last name.",
                    minlength: "Your last name must consist of at least 2 characters."
                },
                company_id: {
                    required: "Please select a company."
                },
                email: {
                    required: "Please enter a valid email address.",
                    email: "Please enter a valid email address."
                },
                phone: {
                    number: "Please enter a valid phone number."
                },
                profile_pic: {
                    extension: "Please upload a valid image file (jpg, jpeg, png, gif)."
                }
            }
        });
    });
</script>
@endsection