<form id="editEmployeeForm" action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $employee->first_name) }}" required>
        @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $employee->last_name) }}" required>
        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="company_id">Company</label>
        <select id="company_id" name="company_id" class="form-control @error('company_id') is-invalid @enderror" required>
            @foreach($companies as $company)
                <option value="{{ $company->id }}" {{ old('company_id', $employee->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
            @endforeach
        </select>
        @error('company_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $employee->email) }}" required>
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group">
        <label for="phone">Phone</label>
        <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $employee->phone) }}">
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

        @if($employee->profile_pic)
            <img src="{{ asset('storage/' . $employee->profile_pic) }}" alt="Profile Picture" class="mt-2" style="max-width: 150px;">
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include jQuery Validate Plugin -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/additional-methods.min.js"></script>

<!-- Client-side Validation Script -->
<script>
    $(document).ready(function() {
        $('#editEmployeeForm').validate({
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
                    extension: "jpg|jpeg|png|gif"
                }
            },
            messages: {
                first_name: {
                    required: "Please enter your first name.",
                    minlength: "Your first name must be at least 2 characters long."
                },
                last_name: {
                    required: "Please enter your last name.",
                    minlength: "Your last name must be at least 2 characters long."
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
            },
            errorElement: "div",
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
