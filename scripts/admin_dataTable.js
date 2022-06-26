// ---- admin_index ----

/*$(document).ready( function () {
    $('#example').DataTable({
        scrollX: true,
        darkmode: true,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });
} );*/

// ---- Adding Jquery DataTable to selected items in array ----

$(document).ready( function () {
    $.each([$('#customers'), $('#admins'), $('#employee'), $('#favorites'), $('#reports')], function () {
        $(this).DataTable({
            scrollX: true,
            "iDisplayLength": 5,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
            }
        });
    });
    //Admin_index, history (orders list)
    $('#history').DataTable({
        order: [[9, 'desc'], [2, 'asc'], [4, 'asc'], [10, 'desc']],
        scrollX: true,
        responsive: true,
        "iDisplayLength": 5,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });
    //Admin_index cars list
    $('#cars').DataTable({
        order: [[0, 'asc'], [1, 'asc'], [2, 'asc']],
        scrollX: true,
        responsive: true,
        "iDisplayLength": 5,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });
});