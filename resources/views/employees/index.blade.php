@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Employees </h5>
      <a href="{{ route('employees.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i>Add new Employee
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Email</th>

            <th>Phone</th>
            <th>Address</th>
            <th>Salary</th>
            <th>Bank Name</th>
            <th>Account #</th>
            <th>Edit</th>
            <!-- <th>Status</th> -->

          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($employees as $employee)
            <tr>
              <td>
                <!-- <i class="ti ti-building ti-md text-primary me-4"></i> -->
                <span class="fw-medium">{{ $employee->name.' '.$employee->last_name }}</span>
              </td>
              <td>
                {{ $employee->email }}
              </td>
              <td>
                {{ $employee->phone}}
              </td>
              <td>
                {{ $employee->address}}
              </td>
              <td>
                {{ $employee->salary}}
              </td>
              <td>
                {{ $employee->bank}}
              </td>
              <td>
                {{ $employee->accountno}}
              </td>
              <td>
              <a href="{{route('employees.edit', $employee->id)}}">
                <button class="btn btn-warning"><i class="ti ti-edit me-2"></i></button>
              </a>

              <form method="POST" action="{{ route('employees.destroy', $employee->id) }}"  onsubmit="return confirm('Are you sure you want to delete this employee?');" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger" type="submit"><i class="ti ti-trash me-2"></i></button>
                </form>

                <a href="{{route('selected.employee.salary-slips', $employee->id)}}">
                <button class="btn btn-success">View Slips</button>
                </a>

              </td>

            </tr>
          @empty
            <tr>
              <td colspan="12" class="text-center">No employee found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

