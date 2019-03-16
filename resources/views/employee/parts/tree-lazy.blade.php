@if (isset($employees))

    <ul class="list-group nav" id="sortable">
        @foreach ($employees as $employee)

            <li class="list-group-item list-group-item-action employees-list-item"
                data-chief_id="{{$employee['parent_id']}}" data-id="{{ $employee['id'] }}" data-child='none'>
                <div class="employees-item-lazy">
                    <div class="employee-item-id d-inline-block">{{$employee['id']}}</div>
                    <div class="employee-item-last_name d-inline-block">{{$employee['last_name']}}</div>
                    <div class="employee-item-first_name d-inline-block">{{$employee['first_name']}}</div>
                    <div class="employee-item-position d-inline-block">{{$employee['position']}}</div>
                </div>
            </li>

        @endforeach
    </ul>

@endif
