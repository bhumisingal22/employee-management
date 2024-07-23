@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Employees</h1>
    
    <!-- Add Employee Button -->
    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">Add Employee</a>
    
    <!-- Search Form -->
    <form id="searchForm" method="POST" action="{{ route('employees.search') }}">
        @csrf
        <div class="input-group mb-3">
            <input type="text" id="employeeSearch" name="query" class="form-control" placeholder="Search employees..." aria-label="Search employees...">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>

    <div id="employeeTable">
        @include('partials._employee_table', ['employees' => $employees])
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                
            </div>
            <div class="modal-body" id="editEmployeeFormContainer">
                <!-- Edit form will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEmployeeChanges">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Search form submit
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(data) {
                    $('#employeeTable').html(data);
                },
                error: function(xhr, status, error) {
                    console.log('Search error:', error);
                }
            });
        });
    
        // Load edit form in modal
        $(document).on('click', '.edit-employee', function(e) {
            e.preventDefault();
            var employeeId = $(this).data('id');
            $.ajax({
                url: '/employees/' + employeeId + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#editEmployeeFormContainer').html(data);
                    $('#editEmployeeModal').modal('show');
                }
            });
        });
    
        // Save changes
        $('#saveEmployeeChanges').on('click', function() {
            var form = $('#editEmployeeForm');
            var formData = new FormData(form[0]);
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#editEmployeeModal').modal('hide');
                    $('#searchForm').submit(); // Refresh the list
                },
                error: function(response) {
                    // Handle validation errors here
                }
            });
        });

         // Handle pagination links click
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            url: url,
            success: function(data) {
                $('#employeeTable').html(data);
            },
            error: function(xhr, status, error) {
                console.log('Pagination error:', error);
            }
        });
    });
    });
    </script>
    
@endsection