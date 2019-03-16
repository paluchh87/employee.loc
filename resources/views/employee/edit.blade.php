@extends('layouts.app')

@section('content')

    <div class="container">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::open(['url' => route('tree.edit'),'class'=>'form-horizontal','method'=>'POST','enctype'=>'multipart/form-data']) !!}

        <div class="form-group">

            {!! Form::label('first_name','First Name:',['class' => 'col-xs-2 control-label'])   !!}
            <div class="col-xs-3">
                {!! Form::text('first_name',old('first_name'),['class' => 'form-control','placeholder'=>'First Name'])!!}
            </div>

        </div>

        <div class="form-group">
            {!! Form::label('last_name', 'Last Name:',['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-3">
                {!! Form::text('last_name', old('last_name'), ['class' => 'form-control','placeholder'=>'Last Name']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('position', 'Position:',['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-3">
                {!! Form::select('position', ['Manager' => 'Manager', 'Seller' => 'Seller'], 'Manager', ['placeholder' => 'Pick a position...']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('salary', 'Salary:',['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-3">
                {!! Form::text('salary', old('salary'), ['class' => 'form-control','placeholder'=>'Salary']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('hired', 'Hired:',['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-3">
                {!! Form::date('hired', old('hired'), ['class' => 'form-control','placeholder'=>'Hired']) !!}
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('avatar', 'Image:',['class'=>'col-xs-2 control-label']) !!}
            <div class="col-xs-3">
                {!! Form::file('avatar', ['class' => 'filestyle','data-buttonText'=>'Choose image','data-buttonName'=>"btn-primary",'data-placeholder'=>"No file"]) !!}
            </div>
        </div>

        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                {!! Form::button('Save', ['class' => 'btn btn-primary','type'=>'submit']) !!}
            </div>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
