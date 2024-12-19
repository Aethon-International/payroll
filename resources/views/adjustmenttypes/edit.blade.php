@extends('layouts.app')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-6">
    <h5 class="card-header">Edit adjustmenttype</h5>
    <form method="POST" action="{{ route('adjustment-types.update', $adjustmenttype->id) }}" class="card-body">
      @csrf
      @method('PUT')

       <!-- Name -->
       <div class="mt-4">
        <label for="name" class="form-label">Name</label>
        <input type="text" id="name" name="name"  value="{{ old('name', $adjustmenttype->name) }}" class="form-control"  autofocus autocomplete="name" />
        @error('name')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>
        <!-- Mode -->
       <div class="mt-4">
        <label for="mode" class="form-label">Name</label>
        <input type="text" id="mode" name="mode"  value="{{ old('mode', $adjustmenttype->mode) }}" class="form-control"  autofocus autocomplete="mode" />
        @error('mode')
          <div class="mt-2 text-danger">{{ $message }}</div>
        @enderror
      </div>

      <!-- Submit and Cancel -->
      <div class="pt-4">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <a href="{{ route('adjustment-types.index') }}" class="btn btn-secondary">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection

