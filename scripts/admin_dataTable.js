// ---- admin_index ----

$(document).ready( function () {
    $('#example').DataTable({
        scrollX: true,
        darkmode: true
    });
} );

// ---- Customers ----

$(document).ready( function () {
    $('#customers').DataTable({
        scrollX: true,
        "iDisplayLength": 25,
    });
    
} );

// ---- Employee ----

$(document).ready( function () {
    $('#employee').DataTable({
        scrollX: true,
        "iDisplayLength": 25
    });
} );

// ---- Megrendeléseim ----
$(document).ready( function () {
    $('#history').DataTable({
        scrollX: true,
        "iDisplayLength": 25,
    });
} );