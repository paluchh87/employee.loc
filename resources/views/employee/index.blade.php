@extends('layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center">
        @if($employees)
        <div class="container col-md-7">
            <div class="card mb-6">
                <div class="card-header">Employees:</div>
                <div class="card-body">
                    <form class="form-inline" method="GET" action="{{ route('employee.index')}}">
                        @csrf
                        <label class="mr-sm-2" for="inlineFormCustomSelect">Order by</label>
                        <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="sort">
                            <option disabled>Choose...</option>
                            <option @if (isset($filters['sort']) && $filters['sort']=='last_name'){{'selected'}} @endif value="last_name">last_name</option>
                            <option @if (isset($filters['sort']) && $filters['sort']=='first_name'){{'selected'}} @endif value="first_name">first_name</option>
                            <option @if (isset($filters['sort']) && $filters['sort']=='position'){{'selected'}} @endif value="position">position</option>
                        </select>
                        <input type="text" list="last_name" class="form-control col-2" autocomplete="off" name="last_name" placeholder="Last Name" value="{{ $filters['last_name']??'' }}">
                        <datalist id="last_name">
                        </datalist>

                        <input type="text" class="form-control col-2" name="first_name" placeholder="First Name" value="{{ $filters['first_name']??'' }}">
                        <input type="text" class="form-control col-2" name="position" placeholder="Position" value="{{ $filters['position']??'' }}">
                        <label class="mr-sm-2"></label>
                        <button type="submit" class="btn btn-primary col-1 btn-sm" id="button_search">Search</button>
                        <label class="mr-sm-2"></label>
                        <button type="submit" class="btn btn-primary col-2 btn-sm"  id="button_search_ajax">Search Ajax</button>
                    </form>
                </div>

                <div class="card-body filters">
                    @if($filters)
                        <div class="alert alert-warning">
                            <span class="text-success">Applied filters:</span>
                            @foreach($filters as $key=>$value)
                                {{ $key }} : <span class="badge badge-info">{{ $value }}</span> &nbsp;&nbsp;
                            @endforeach
                            <a href="{{ route('employee.index') }}" class="btn btn-info btn-danger">Clear</a>
                        </div>
                    @endif
                </div>

                <div id="alert_index">

                </div>


            </div>
        </div>

        <div class="container col-md-7">

            <div class="row">
                <div class="col-md-12 col-xs-12 employees-columns">
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-secondary employees-list-item employees-navbar">
                            <div data-name="id" class="employee-item-id d-inline-block item-order">ID</div>
                            <div data-name="last_name" class="employee-item-last_name d-inline-block item-order @if (isset($filters['sort']) && $filters['sort']=='last_name'){{'active'}} {{$filters['order']}} @endif">Last Name</div>
                            <div data-name="first_name" class="employee-item-first_name d-inline-block item-order @if (isset($filters['sort']) && $filters['sort']=='first_name'){{'active'}} {{$filters['order']}} @endif">First Name</div>
                            <div data-name="position" class="employee-item-position d-inline-block item-order @if (isset($filters['sort']) && $filters['sort']=='position'){{'active'}} {{$filters['order']}} @endif">Position</div>
                            <div data-name="edit" class="employee-item-edit d-inline-block"></div>

                        </li>
                    </ul>
                </div>
            </div>

            <div class="employees-list-block modalitem">
                @include('employee.parts.employee-table')
            </div>

            <div class="employee-pagination-block row justify-content-center">
                @include('employee.parts.pagination')
            </div>

        </div>

        @endif

    </div>
@endsection
