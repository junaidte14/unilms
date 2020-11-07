jQuery(document).ready(function($) {
    var numCourseSections = $('.courseconsec').length;
    $('#total_sections').val(numCourseSections);
    $('.unilms_coursecont_data_submit').click(function(e) {
        e.preventDefault();
        $('#publish').click();
    });

    $('#add-unilms-coursecont-row').on('click', function() {
        var row = $('.empty-unilms-coursecont-row.screen-reader-text').clone(true);
        row.removeClass('empty-unilms-coursecont-row screen-reader-text');
        row.insertBefore('#repeatable-fieldset-unilms-coursecont tbody>tr:last');
        return false;
    });
    $('.remove-row-unilms-coursecont').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
    $('#repeatable-fieldset-unilms-coursecont tbody').sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        handle: '.sort'
    });


});
