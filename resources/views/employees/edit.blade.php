@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Edit Employee</h5>
    <form method="POST" action="{{ route('employees.update', $employee->id) }}" class="card-body">
      @csrf
      @method('PUT')

       <!-- Name -->
       <div class="mt-4">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $employee->name) }}" class="form-control"  autofocus autocomplete="first_name" />
        @error('name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Email -->
      <div class="mt-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $employee->email) }}" class="form-control"  autocomplete="employeename" />
        @error('email')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Phone -->
      <div class="mt-4">
        <label for="phone" class="form-label">Phone</label>
        <input type="phone" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" class="form-control"  autocomplete="employeename" />
        @error('phone')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Address -->
      <div class="mt-4">
        <label for="address" class="form-label">Address</label>
        <input type="text" id="address" name="address" value="{{ old('address', $employee->address) }}" class="form-control"  autocomplete="employeename" />
        @error('address')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

        <!-- Bank -->
        <div class="mt-4">
        <label for="bank" class="form-label">Bank Name</label>
        <input type="text" id="bank" name="bank" value="{{ old('bank', $employee->bank) }}" class="form-control"  autocomplete="new-password" />
        @error('bank')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

        <!-- Account No -->
        <div class="mt-4">
        <label for="accountno" class="form-label">Account #</label>
        <input type="text" id="accountno" name="accountno" class="form-control"  value="{{ old('accountno', $employee->accountno) }}" autocomplete="new-password" />
        @error('accountno')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
      <!-- Salary -->
      <div class="mt-4">
        <label for="salary" class="form-label">Salary</label>
        <input type="text" id="salary" name="salary" class="form-control"  value="{{ old('salary', $employee->salary) }}" autocomplete="new-password" />
        @error('salary')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>



      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection


