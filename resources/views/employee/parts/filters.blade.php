@if($filters)
    <div class="alert alert-warning">
        <span class="text-success">Applied filters:</span>
        @foreach($filters as $key=>$value)
            {{ $key }} : <span class="badge badge-info">{{ $value }}</span> &nbsp;&nbsp;
        @endforeach
        <a href="{{ route('employee.index') }}" class="btn btn-info btn-danger">Clear</a>
    </div>
@endif