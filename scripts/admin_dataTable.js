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

// ---- Customers ----

$(document).ready( function () {
    $('#customers').DataTable({
        scrollX: true,
        "iDisplayLength": 25,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });
    
} );

// ---- Employee ----

$(document).ready( function () {
    $('#employee').DataTable({
        scrollX: true,
        "iDisplayLength": 25,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });
} );

// ---- Histroy - Admin index ----
$(document).ready( function () {
    $('#history').DataTable({
        order: [[9, 'desc'], [3, 'asc'], [5, 'asc'], [10, 'desc']],
        scrollX: true,
        responsive: true,
        "iDisplayLength": 5,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });
    $('#cars').DataTable({
        order: [[0, 'asc'], [1, 'asc'], [2, 'asc']],
        scrollX: true,
        responsive: true,
        "iDisplayLength": 5,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });

    $('#favorites').DataTable({
        order: [[0, 'asc']],
        scrollX: true,
        responsive: true,
        "iDisplayLength": 5,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });
    $('#reports').DataTable({
        order: [[0, 'asc']],
        scrollX: true,
        responsive: true,
        "iDisplayLength": 5,
        "language":{
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Hungarian.json"
        }
    });
});