<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <div class="container">
                <div class="alert alert-danger">Группе нужен начальник</div>
            </div>
            <button type="button" class="close" id="employee-btn-close2" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">

            <form class="employee-form-edit employee-form row" id='form_modal_edit' method="POST">
                @csrf

                @if($employees)

                    <div class="col-6">

                        <div class="form-group">
                            <label for="input-position">Сделать начальником группы</label>
                            <select id="input-position" class="form-control" name="employee" size="5"
                                    data-parent_id="{{$parent}}">

                                @foreach ($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->first_name}} {{$employee->last_name}}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="input-position">Отправить в новую группу</label>
                            <select id="input-position" class="form-control" name="director" size="5">
                                <option value="" selected>None</option>
                                @foreach ($directors as $director)
                                    <option value="{{$director->id}}">{{$director->last_name}} {{$director->first_name}}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>



                @endif

            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="employee-btn-close2">Close</button>
            <button type="button" class="btn btn-success" id="employee-btn-update2" data-delete="">Save</button>
        </div>


        <div id="alert_delete">

        </div>

    </div>
</div>