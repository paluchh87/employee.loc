$(document).ready(function () {
    $('.modalitem').on('click', '.modal-item', function () {
        var id = $(this).attr('data-employee-id');
        $.ajax({
            url: '/employee/' + id + '/edit/',
            dataType: 'json',
            data: {
                id: id
            },
            method: 'GET'
        }).done(function (data) {
            $('#Modal-edit').empty().append(data);
        }).fail(function (data) {
            console.log(data);
            $('#Modal-edit').modal('toggle');
            $('#alert_index').addClass('alert alert-success').html('<strong>Well done! Save</strong>').fadeIn().delay(2000).fadeOut();
        });
    });

    $('.modalitem').on('click', '#employee-btn-delete', function () {
        var id = $(this).attr('data-employee-id');
        $.ajax({
            url: '/show-delete-window',
            dataType: 'json',
            data: {
                _token: $('input[name="_token"]').val(),
                id: id,
                parent_id: $(this).attr('data-parent_id')
            },
            method: 'POST'
        }).done(function (data) {
            console.log(data);
            $('#Modal-delete').empty().append(data.table);
        }).fail(function () {
            alert('Ошибка trr');
        });
    });

    $(document).on("click", 'input[name="director"]', function (event) {
        $(this).autocomplete({
            select: function (event, ui) {
                $(this).attr('data-parent_id', ui.item.index);
            },
            source: function (request, response) {
                $.ajax({
                    url: '/autocomplete',
                    dataType: "json",
                    method: 'GET',
                    data: {
                        fields: {
                            last_name: request.term,
                        },
                        name: 'director'
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            return {
                                value: item.last_name + ' ' + item.first_name,
                                label: item.last_name + ' ' + item.first_name,
                                index: item.id
                            };
                        }));
                    },
                });
            },
            minLength: 2,
        });
    });

    $(document).on("click", "#employee-btn-update", function (event) {
        if ($('input[name="director"]').val() === '') {
            $('input[name="director"]').attr('data-parent_id', '');
        }

        var form_data = new FormData();
        form_data.append('avatar', $('input#input-avatar').prop('files')[0]);
        form_data.append('id', $('#form_modal_edit').attr('data-employee-id'));
        form_data.append('_method', $('input[name="_method"]').val());
        form_data.append('_token', $('input[name="_token"]').val());
        form_data.append('parent_id', $('input[name="director"]').attr('data-parent_id'));
        form_data.append('director', $('input[name="director"]').val());
        form_data.append('first_name', $('input[name="first_name_modal"]').val());
        form_data.append('last_name', $('input[name="last_name_modal"]').val());
        form_data.append('hired', $('input[name="employment_date"]').val());
        form_data.append('salary', $('input[name="salary"]').val());
        form_data.append('position', $('select[name="position_modal"]').val());
        form_data.append('id', $('#form_modal_edit').attr('data-employee-id'));
        form_data.append('photo', $('input[name="input-avatar"]').attr('data-avatar'));

        $.ajax({
            url: '/employee/' + $('#form_modal_edit').attr('data-employee-id'),
            method: 'POST',
            data: form_data,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data);
                if (data.result.error) {
                    $('#alert').removeClass('alert alert-danger').removeClass('alert alert-success');
                    $('#alert').addClass('alert alert-danger').html('<strong>' + data.result.error + '</strong>').fadeIn().delay(2000).fadeOut();


                } else {
                    $('#alert').removeClass('alert alert-danger').removeClass('alert alert-success');
                    $('#alert').addClass('alert alert-success').html('<strong>Well done! ' + data.result.status + '</strong>').fadeIn().delay(2000).fadeOut();
                    if (data['photo']==null){
                        data['photo']='avatar.default.png';
                    }
                    $('.employee-avatar').empty().append('<img src="images/'+data['photo']+'" class="img-circle">');

                }
            },
            error: function (data) {
                var str = '';
                $.each(data.responseJSON.errors, function (index, value) {
                    str = str + index + ': ' + value + '<br>';
                });

                $('#alert').removeClass('alert alert-danger').removeClass('alert alert-success');
                $('#alert').addClass('alert alert-danger').html('<strong>' + str + '</strong>').fadeIn().delay(2000).fadeOut();
            }
        });
    });

    $(document).on("click", "#employee-btn-update2", function (event) {
        $.ajax({
            url: '/can-delete',
            method: 'POST',
            data: {
                _token: $('input[name="_token"]').val(),
                director: $('select[name="director"]').val(),
                employee: $('select[name="employee"]').val(),
                parent_id: $('select[name="employee"]').attr('data-parent_id'),
                id: $('#form_modal_edit').attr('data-employee-id'),
                delete: $(this).attr('data-delete')
            },
            dataType: 'json',
            success: function (data) {
                if (data == true) {
                    $('#alert_delete').removeClass('alert alert-danger').removeClass('alert alert-success');
                    $('#alert_delete').addClass('alert alert-success').html('<strong>Well done!</strong>').fadeIn().delay(2000).fadeOut();
                    $(this).removeClass('alert alert-success');

                    var id = $('#employee-btn-delete').attr('data-employee-id');
                    $.ajax({
                        url: 'employee/' + id,
                        dataType: 'json',
                        data: {
                            _method: 'DELETE',
                            _token: $('input[name="_token"]').val(),
                            id: id
                        },
                        method: 'POST',
                        success: function (data) {
                            console.log(data);
                            if (data.error) {
                                $('#alert_delete').removeClass('alert alert-danger').removeClass('alert alert-success');
                                $('#alert_delete').addClass('alert alert-danger').html('<strong>' + data.error + '</strong>').fadeIn().delay(2000).fadeOut();
                            } else {
                                $('#exampleModal2').modal('toggle');
                                $('#exampleModal').modal('toggle');
                                $('#alert_index').removeClass('alert alert-danger').removeClass('alert alert-success');
                                $('#alert_index').addClass('alert alert-success').html('<strong>Well done! Delete' + data.status + '</strong>').fadeIn().delay(2000).fadeOut();
                                location.reload();
                            }
                        },
                        error: function (data) {
                            alert('Ошибка Ajax Delete');
                        }
                    });
                } else {
                    $('#alert_delete').removeClass('alert alert-danger').removeClass('alert alert-success');
                    $('#alert_delete').addClass('alert alert-danger').html('<strong>ERROR! Нужно сделать выбор!</strong>').fadeIn().delay(2000).fadeOut();
                }
            },
            error: function (data) {
                $('#alert_delete').removeClass('alert alert-danger').removeClass('alert alert-success');
                $('#alert_delete').addClass('alert alert-danger').html('<strong>ERROR! CAN-DELETE</strong>');
            }
        });
    });

    $(document).on("click", "#employee-btn-close", function () {
        location.reload();
    });

    $(document).on("click", "#employee-btn-close2", function () {
        $('#Modal-delete').modal('toggle');
    });

});