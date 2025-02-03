@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Salary Slips</h5>
      @role('admin')
      <a href="{{ route('admin.salary-slips.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add new Salary Slip
      </a>
      @endrole
    </div>
    <form method="POST" action="{{route('salaryslips.send-bulk-action')}}" id="bulk-action-form">
      @csrf
      <div class="table-responsive text-nowrap">
        <table class="table">
          <thead>
            <tr>
              <th>
                <input type="checkbox" id="select-all">
              </th>
              <th>Employee Name</th>
              <th>Payroll</th>
              <th>Base Salary</th>
              <th>Fine</th>
              <th>Days Off Amount</th>
              <th>Bonus</th>
              <th>Net Amount</th>
              @role('admin')
              <th>Action</th>
              @endrole

            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            @if($salaryslips)
            @forelse ($salaryslips as $salaryslip)
              <tr>
                <td>
                  <input type="checkbox" name="selected_salary_slips[]" value="{{ $salaryslip->id }}">
                </td>
                <td>
                  <span class="fw-medium">{{ $salaryslip->employee->name }}</span>
                </td>
                <td>
                  <span class="fw-medium">{{ $salaryslip->payrollPeriod->month . " , " . $salaryslip->payrollPeriod->year }}</span>
                </td>
                <td>
                  <span class="fw-medium">{{ $salaryslip->base_salary }}</span>
                </td>
                <td>
                  <span class="fw-medium">{{ $salaryslip->fine }}</span>
                </td>
                <td>
                  <span class="fw-medium">{{ $salaryslip->days_off }}</span>
                </td>
                <td>
                  <span class="fw-medium">{{ $salaryslip->bonus }}</span>
                </td>
                <td>
                  <span class="fw-medium">{{ $salaryslip->net_salary }}</span>
                </td>
                @role('admin')
                <td>

                    <a href="{{route('admin.salary-slips.edit', $salaryslip->id)}}">
                        <i class="ti ti-edit me-2"></i>
                      </a>


                      <a href="{{route('admin.salary-slips.destroy', $salaryslip->id)}}">
                        <i class="ti ti-trash me-2"></i>
                      </a>

                </td>
                @endrole
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">No salary slips found.</td>
              </tr>
            @endforelse
            @endif
          </tbody>
        </table>
        <div class="m-5 d-flex gap-4">
            @role('admin')
        <button type="submit" name="action" value="send_email" class="btn btn-primary">Send Emails to Selected</button>
        @endrole
        <button type="submit" name="action" value="generate_pdf" class="btn btn-success">Generate PDFs for Selected</button>
      </div>
      </div>
    </form>
  </div>
</div>

@push('scripts')
{{-- No scripts will be loaded from the layout --}}
@endpush
<script>

// Select or deselect all checkboxes
document.getElementById('select-all').addEventListener('click', function () {
    const checkboxes = document.querySelectorAll('input[name="selected_salary_slips[]"]');
    checkboxes.forEach(checkbox => {
      checkbox.checked = this.checked;
    });
  });
</script>
@endsection
