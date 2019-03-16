@if (is_array($employeesTree) and isset($employeesTree[$parent_id]))
    <ul class="list-group nav" id="sortable">

        @foreach ($employeesTree[$parent_id] as $item)
            <li class="list-group-item list-group-item-action employees-list-item"
                data-chief_id="{{$item['parent_id']}}" data-id="{{ $item['id'] }}">
                <div class="employees-item">
                    <div class="employee-item-id d-inline-block">{{$item['id']}}</div>
                    <div class="employee-item-last_name d-inline-block">{{$item['last_name']}}</div>
                    <div class="employee-item-first_name d-inline-block">{{$item['first_name']}}</div>
                    <div class="employee-item-position d-inline-block">{{$item['position']}}</div>
                </div>

                {!! view('employee.parts.tree')->with(['employeesTree'=>$employeesTree,'parent_id'=>$item['id']])->render()!!}
            </li>
        @endforeach

    </ul>

@endif
