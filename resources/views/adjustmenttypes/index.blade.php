@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">All adjustmenttypes </h5>
      <a href="{{ route('AdjustmentTypes.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i>
      </a>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Edit</th>
          </tr>
        </thead>
        <tbody class="table-border-bottom-0">
          @forelse ($adjustmenttypes as $adjustmenttype)
            <tr>
              <td>
                <span class="fw-medium">{{ $adjustmenttype->name.' '.$adjustmenttype->last_name }}</span>
              </td>

              <td>
              <a href="{{route('AdjustmentTypes.edit', $adjustmenttype->id)}}">
                <button class="btn btn-warning"><i class="ti ti-edit me-2"></i></button>
              </a>

              <form method="POST" action="{{ route('AdjustmentTypes.destroy', $adjustmenttype->id) }}"  onsubmit="return confirm('Are you sure you want to delete this adjustmenttype?');" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button class="btn btn-danger" type="submit"><i class="ti ti-trash me-2"></i></button>
                </form>

              </td>

            </tr>
          @empty
            <tr>
              <td colspan="12" class="text-center">No adjustmenttype found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
@endsection




