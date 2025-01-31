@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All Payroll Periods </h5>
      <a href="{{ route('payroll-periods.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i>Add new Payroll Period
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Month</th>
            <th>Year</th>
            <th>Edit</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($payrollperiods as $payrollperiod)
            <tr>
              <td>
                <span class="fw-medium">{{ $payrollperiod->month}}</span>
              </td>
              <td>
                <span class="fw-medium">{{ $payrollperiod->year}}</span>
              </td>

              <td>
              <a href="{{route('payroll-periods.edit', $payrollperiod->id)}}">
                <button class="btn btn-warning"><i class="ti ti-edit me-2"></i></button>
              </a>

              <form method="POST" action="{{ route('payroll-periods.destroy', $payrollperiod->id) }}"  onsubmit="return confirm('Are you sure you want to delete this adjustmenttype?');" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger" type="submit"><i class="ti ti-trash me-2"></i></button>
                </form>

                <a href="{{route('selected.payroll-period.salary-slips', $payrollperiod->id)}}">
                <button class="btn btn-success">View Slips</button>
                </a>

              </td>

            </tr>
          @empty
            <tr>
              <td colspan="12" class="text-center">No payroll period found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection




