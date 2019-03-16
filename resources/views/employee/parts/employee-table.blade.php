<div class="row">
    <div class="col-md-12 col-xs-12 employees-list">
        <ul class="list-group">
            @if($employees)
                @foreach ($employees as $employee)
                    <li class="list-group-item list-group-item-action employees-list-item">
                        <div class="employee-item-id d-inline-block">{{$employee['id']}}</div>
                        <div class="employee-item-last_name d-inline-block">{{$employee['last_name']}}</div>
                        <div class="employee-item-first_name d-inline-block">{{$employee['first_name']}}</div>
                        <div class="employee-item-position d-inline-block">{{$employee['position']}}</div>
                        <div class="employee-item-edit d-inline-block">
                            <a href="#" class="btn btn-info btn-sm modal-item" data-toggle="modal"
                               data-target="#Modal-edit" data-employee-id="{{$employee['id']}}">Edit</a>
                        </div>

                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>

<!-- Modal -->
<div class="modal fade bd-modal-lg" id="Modal-edit" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

</div>