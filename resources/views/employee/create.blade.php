@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
  <div class="col-6">
    <h3>Add employee</h3>
    <form method="POST" action="{{ route('employee.store')}}" enctype="multipart/form-data">
      {{ csrf_field() }}

      @include('partials.validation-errors')

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name">
      </div>

      <div class="form-group">
        <label for="position">Position</label>
        <input type="text" class="form-control" id="position" name="position">
      </div>

      <div class="form-group">
        <label for="hired">Hired date</label>
        <input type="date" class="form-control" id="hired" name="hired">
      </div>

      <div class="form-group">
        <label for="salary">Salary</label>
        <input type="input" class="form-control" id="salary" name="salary">
      </div>

      <div class="form-group">
        <label for="superviser">Chief</label>
        <select class="employee-form-superviser form-control" id="superviser" name="superviser">
          @isset($employee->superviser)
          <option value="{{ $employee->superviser->id }}">{{ $employee->superviser->name }}</option>
          @endisset
        </select>
      </div>

      <div class="custom-file mb-4">
        <input type="file" class="custom-file-input" id="photo" name="photo">
        <label class="custom-file-label" for="photo">Photo</label>
      </div>

      <button type="submit" class="btn btn-primary mb-1">Add employee</button>
    </form>
  </div>
</div>

@endsection
