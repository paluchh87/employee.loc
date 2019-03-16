$(document).ready(function () {

    $('ul li:has(ul)').addClass('has-child');

    $('.employees-item').on('click', function () {
        $(this).parent().find('>ul').toggleClass('open');
    });

    $('.employees-list-item').on('click', '.employees-item-lazy', function () {
        var $this = $(this);
        var child = $this.parent().attr('data-child');

        if (child === 'none') {
            $.ajax({
                url: '/lazy',
                dataType: 'json',
                data: {
                    chief_id: null,
                    id: $this.parent().attr('data-id')
                },
                method: 'GET'
            }).done(function (data) {
                // console.log(data);
                $this.parent().attr('data-child', 'yes');
                $this.append(data['table']);
                $this.find("ul:first").toggleClass('open');
            }).fail(function () {
                alert('Ошибка');
            });
        } else {
            if ($this.find("ul:first").hasClass('open')) {
                $this.find("ul:first").toggleClass('open');
                $this.find("ul:first").hide();
            } else {
                $this.find("ul:first").show();
                $this.find("ul:first").toggleClass('open');
            }
        }
        return false;
    });

    $("#sortable").sortable({
        cursor: 'pointer',
        revert: true,
        update: function (event, ui) {
            var id = ui.item.attr('data-id');
            var data_id = ui.item.prev().attr('data-chief_id');

            if (!data_id) {
                data_id = ui.item.next().attr('data-chief_id');
            }

            if (data_id === '' || !data_id) {
                alert('Сюда перетаскивать нельзя');
                data_id = ui.item.attr('data-chief_id');
                $(this).sortable('cancel');
                //$(ui.sender).sortable('cancel');
            }
            ui.item.attr('data-chief_id', data_id);

            $.ajax({
                url: '/tree',
                dataType: 'json',
                data: {
                    chief_id: data_id,
                    id: id
                },
                method: 'GET'
            }).done(function (data) {
                //console.log(data);
                //$('#par_answer').html(data);
            }).fail(function () {
                alert('Ошибка');
            });
        }
    });
});