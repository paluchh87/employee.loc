@extends('layouts.app')

@section('content')

    <div class="row justify-content-center align-items-center">

        @if ($table)
            <div class="container col-md-7">
                <div class="employees-all">
                    <div class="row">
                        <div class="col-md-12">
                            {!! $table!!}
                        </div>
                    </div>
                </div>
            </div>

        @endif

    </div>

@endsection
