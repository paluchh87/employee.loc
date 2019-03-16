<div class="modal-dialog modal-lg">
    <div class="modal-content">

        @if(isset($error))
            <div class="modal-header">
                <div class="container">
                    <h3 class="modal-title">{{$error}}</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(isset($employee))
            <div class="modal-header">

                <div class="container">
                    <h3 class="modal-title">{{$employee->first_name}} {{$employee->last_name}}</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="employee-form-edit employee-form row" id='form_modal_edit'
                      data-employee-id="{{$employee->id}}"
                      method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-6">
                        <div class="form-group">
                            <label for="input-avatar">
                                <div class="employee-avatar">
                                    <img src="@if($employee->photo)
                                    {{ asset('images/'.$employee->photo)}}
                                    @else {{asset('images/avatar.default.png')}}
                                    @endif" class="img-circle">

                                </div>
                            </label>
                            <input type="file" id="input-avatar" name="input-avatar" class="form-control"
                                   accept="image/jpeg,image/png"
                                   data-avatar="@if($employee->photo){{$employee->photo}} @endif" hidden>
                        </div>

                        <div class="form-group">
                            <label for="input-first-name">First name</label>
                            <input id="input-first-name" name="first_name_modal" class="form-control" placeholder="First Name" value="{{$employee->first_name}}">
                        </div>
                        <div class="form-group">
                            <label for="input-last-name">Last name</label>
                            <input id="input-last-name" name="last_name_modal" class="form-control" placeholder="Last Name" value="{{$employee->last_name}}">
                        </div>
                        <div class="form-group">
                            <label for="input-employment-date">Hired</label>
                            <input id="input-employment-date" type="date" name="employment_date" class="form-control" placeholder="Hired" value="{{$employee->hired}}">
                        </div>

                    </div>

                    <div class="col-6">

                        <div class="form-group">
                            <label for="input-position">Position</label>
                            <select id="input-position" class="form-control" name="position_modal" size="5">

                                @if(isset($positions))
                                    @foreach ($positions as $position)
                                        <option value="{{$position->position}}"
                                                @if($position->position==$employee->position) selected @endif>{{$position->position}}</option>
                                    @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="input-salary">Salary</label>
                            <input id="input-salary" type="number" class="form-control" name="salary" placeholder="Salary" value="{{$employee->salary}}">
                        </div>
                        <div class="form-group ui-front">

                            <label for="input-director">Director</label>
                            <div id="input-director">
                                @if(isset($director))
                                    <input class="d-inline-block form-control form-inline" autocomplete="off"
                                           value="{{$director->last_name}} {{$director->first_name}}" name="director"
                                           data-parent_id="{{$director->id}}">
                                @else
                                    <input class="d-inline-block form-control form-inline" autocomplete="off" value=""
                                           name="director" data-parent_id="">
                                @endif
                            </div>

                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger modalitem2" id="employee-btn-delete" data-toggle="modal"
                        data-target="#Modal-delete" data-employee-id="{{$employee->id}}"
                        data-parent_id="{{$employee->parent_id}}">Delete
                </button>
                <button type="button" class="btn btn-secondary" id="employee-btn-close" data-dismiss="modal">Close
                </button>
                <button type="button" class="btn btn-success" id="employee-btn-update">Save</button>
            </div>
        @endif
        <div id="alert">

        </div>

    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="Modal-delete" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">

</div>
