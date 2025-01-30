@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Salary Slip Edit Form</h5>
    <form method="POST" action="{{ route('admin.salary-slips.update',$salaryslip->id) }} " class="card-body" id="salary-slip-form">
    @method('PUT')
      @csrf

      <!-- Employee -->
      <div class="mt-4">
          <label for="employee_id" class="form-label">Employee</label>
          <select name="employee_id" class="form-select">
              @foreach ($employees as $employee)
                  <option value="{{ $employee->id }}">
                      {{ $employee->name }}
                  </option>
              @endforeach
          </select>
          @error('name')
              <div class="mt-2 text-danger">{{ $message }}</div>
          @enderror
      </div>


      <!-- Payroll -->
      <div class="mt-4">
        <label for="payroll_period_id" class="form-label">Payroll</label>
        <select name="payroll_period_id" class="form-select">
          @foreach ($payrollperiods as $payrollperiod)
              <option value="{{ $payrollperiod->id }}">
                  {{ $payrollperiod->month." , ".$payrollperiod->year }}
              </option>
          @endforeach
        </select>
        @error('payroll_period_id')
            <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>


      <!-- Initial Adjustment Fields -->

      <div class="mt-4" id="adjustment-fields-container" >


      </div>
      <button type="button" class="btn btn-success  mt-3"  id="add-adjustment-field">Add Adjustment Type +</button>

      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('admin.salary-slips.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>

@endsection


@push('scripts')

    // Add new adjustment fields when "+" is clicked
    document.getElementById('add-adjustment-field').addEventListener('click', function() {
        var container = document.getElementById('adjustment-fields-container');

        var newAdjustmentField = `
            <div class="mt-4 adjustment-field">
                <label for="adjustment_type_id" class="form-label">Adjustment Type</label>
                <select name="adjustment_type_id[]" class="form-select">
                    @foreach ($adjustmenttypes as $adjustmenttype)
                        <option value="{{ $adjustmenttype->id }}">
                            {{ $adjustmenttype->name }}
                        </option>
                    @endforeach
                </select>

                <label for="adjustment_amount" class="form-label">Adjustment Amount</label>
                <input type="number" name="adjustment_amount[]" class="form-control" />

                <button type="button" class="btn btn-danger mt-2 delete-adjustment-field">-</button>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', newAdjustmentField);
    });

    // Delete the adjustment field when the "-" button is clicked
    document.getElementById('salary-slip-form').addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-adjustment-field')) {
            event.target.closest('.adjustment-field').remove();
        }
    });


@endpush

