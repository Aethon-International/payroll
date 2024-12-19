@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Edit Payroll Period</h5>
    <form method="POST" action="{{ route('payroll-periods.update', $payrollperiod->id) }}" class="card-body">
      @csrf
      @method('PUT')

       <!-- Name -->
       <div class="mt-4">
        <label for="month" class="form-label">Month</label>
        <input type="text" id="month" name="month"  value="{{ old('month', $payrollperiod->month) }}" class="form-control"  autofocus autocomplete="month" />
        @error('month')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
        <!-- Mode -->
       <div class="mt-4">
        <label for="year" class="form-label">Year</label>
        <input type="year" id="year" name="year"  value="{{ old('year', $payrollperiod->year) }}" class="form-control"  autofocus autocomplete="year" />
        @error('year')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('payroll-periods.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection

