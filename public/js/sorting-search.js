$(document).ready(function () {
    var url = '/employee';
    var order = 'asc';
    var name = 'id';

    $(document).on('click', '.employees-navbar .item-order', function () {
        var $this = $(this);
        $this.data('order', ($this.data('order') === 'desc') ? 'asc' : 'desc');
        order = $this.data('order');
        name = $this.data('name');
        reloadList();

        $this.removeClass((order === 'desc') ? 'asc' : 'desc');
        $this.addClass(order);
        $('.employees-navbar .item-order').removeClass('active');
        $this.addClass('active');
    });

    $('#button_search_ajax').on('click', function (e) {
        e.preventDefault();
        name = $("select[name^='sort']").val();
        reloadList2();
    });

    function setFilters(data) {
        $('.employees-navbar .item-order').each(function () {
            $(this).removeClass('active');
            $(this).removeClass('desc');
            $(this).removeClass('asc');

            if ($(this).data('name') == data['filters']['sort']) {
                //var $this = $(this);
                //$this.removeClass((order === 'desc') ? 'asc' : 'desc');
                $(this).addClass(data['filters']['order']);
                $(this).addClass('active');
            }
        });
    }

    function getActualParams() {
        return {
            url: url,
            dataType: 'json',
            data: {
                sort: name,
                order: order,
                last_name: $("input[name^='last_name']").val(),
                first_name: $("input[name^='first_name']").val(),
                position: $("input[name^='position']").val()
            },
            method: 'GET'
        };
    }

    function reloadList() {
        var params = getActualParams();

        $.ajax(params).done(function (data) {
            //console.log(data['filters']);
            if (data['employees']['data'].length > 0) {
                $('.employees-list-block').fadeOut(500, function () {
                    $('.employees-list-block').empty().append(data['table']);
                });
                $('.employees-list-block').fadeIn(500);
                $('.employee-pagination-block').empty().append(data['pagination']);
                $('.filters').empty().append(data['filters2']);
            }
        }).fail(failMessage);
    }

    function reloadList2() {
        var params = getActualParams();

        $.ajax(params).done(function (data) {
            //console.log(data['filters']);
            if (data['employees']['data'].length > 0) {
                setFilters(data);
                $('.employees-list-block').fadeOut(500, function () {
                    $('.employees-list-block').empty().append(data['table']);
                });
                $('.employees-list-block').fadeIn(500);
                //$('.employees-list-block').empty().append(data['table']);
                $('.employee-pagination-block').empty().append(data['pagination']);
                $('.filters').empty().append(data['filters2']);
            }
        }).fail(failMessage);
    }

    function failMessage() {
        alert('Network error');
    }

    $('input[name="last_name"]').on('keyup', function () {
        var $this = $(this);
        if ($this.val().length >= 1) {
            $.ajax({
                url: '/autocomplete',
                data: {
                    _token: $('input[name="_token"]').val(),
                    fields: {
                        last_name: $this.val(),
                        first_name: $('input[name="first_name"]').val()
                    },
                    name: 'last_name'
                },
                method: 'POST',
                dataType: 'json',
                success: function (data) {
                    var str = '';
                    $.map(data, function (item) {
                        str = str + '<option>' + item.last_name + '</option>';
                    });
                    $('#last_name').empty().append(str);
                }
            })
        }
    });

    $('input[name="first_name"]').autocomplete({
        source: function (request, response) {
            $.ajax({
                url: '/autocomplete',
                dataType: "json",
                data: {
                    fields: {
                        last_name: $('input[name="last_name"]').val(),
                        first_name: request.term
                    },
                    name: 'first_name'

                },
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    var ar = [];
                    $.map(data, function (item) {
                        ar.push(item.first_name);
                    });
                    response(ar);
                },
            });
        },
        minLength: 2,
    });

});