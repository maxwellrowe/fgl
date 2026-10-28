(function ($) {
    'use strict';
    $(function () {
        const table = $('#fglsw-order-table');
        const body = table.find('tbody');
        if (!body.length) return;
        table.find('.fglsw-order-controls').prop('hidden', false);

        function updatePositions(row) {
            body.children('tr').each(function (index) {
                $(this).find('input[type="number"]').val(index + 1);
            });
            $('#fglsw-order-message').text(row.attr('data-station-name') + ' moved to position ' + (row.index() + 1) + '. Save Route Order to apply changes.');
        }

        body.sortable({
            items: '> tr',
            handle: '.fglsw-drag-handle',
            axis: 'y',
            helper: function (event, row) {
                const helper = row.clone();
                helper.children().each(function (index) {
                    $(this).width(row.children().eq(index).width());
                });
                return helper;
            },
            update: function (event, ui) { updatePositions(ui.item); }
        });

        body.on('click', '.fglsw-move-up, .fglsw-move-down', function () {
            const row = $(this).closest('tr');
            const up = $(this).hasClass('fglsw-move-up');
            const neighbor = up ? row.prev() : row.next();
            if (!neighbor.length) return;
            if (up) row.insertBefore(neighbor);
            else row.insertAfter(neighbor);
            updatePositions(row);
            this.focus();
        });
    });
})(jQuery);
