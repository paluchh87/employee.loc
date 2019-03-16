@extends('layouts.app')

@section('content')

<div class="row justify-content-center">

  <div class="card" style="width:30em;">
    @if($employee->photo)
      <img src="{{ asset('storage/photos/' . $employee->photo) }}" class="card-img-top">
    @else
      <img src="https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg" class="card-img-top">
    @endif

    <div class="card-body">
      <h5 class="card-title">{{ $employee->name }}</h5>
      <p><span class="font-weight-bold">Position</span> {{ $employee->position }}</p>
      <p><span class="font-weight-bold">Hired date</span> {{ $employee->hired->toFormattedDateString() }}</p>
      <p><span class="font-weight-bold">Salary</span> {{ $employee->salary }}</p>
      @isset($employee->superviser)
      <p><span class="font-weight-bold">Chief</span> {{ $employee->superviser->name }}</p>
      @endisset

      <a class="btn btn-outline-info" href="{{ route('employee.edit', ['employee' => $employee->id]) }}">&nbsp;&nbsp;edit&nbsp;&nbsp;</a>
      <form action="{{ route('employee.destroy', ['employee' => $employee->id]) }}" method="POST" style="display:inline">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('are you shure?')">delete</button>
      </form>
    </div>
  </div>

</div>
@endsection
