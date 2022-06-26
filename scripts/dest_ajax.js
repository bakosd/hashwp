$(document).ready(function(){
    $('button[data-role="destUPD"]').click(function(e){
        e.stopPropagation();
        event.preventDefault();
        var id = $(this).data('id');
        var city = $('#'+id).children('p[data-target=city]').text();
        var address = $('#'+id).children('p[data-target=address]').text();
        var phone = $('#'+id).children('p[data-target=phone]').text();
        var email = $('#'+id).children('p[data-target=email]').text();
        var workdayStr = $('#'+id).children('p[data-target=workday]').text();
        var workday = workdayStr.split(" - ");
        var weekendStr = $('#'+id).children('p[data-target=weekend]').text();
        var weekend = weekendStr.split(" - ");
        var originalName = city+id;
        

        $('#ORIGINALNAME').val(originalName);
        $('#ID').val(id);
        $('#CITY').val(city);
        $('#ADDRESS').val(address);
        $('#EMAIL').val(email);
        $('#PHONE').val(phone);
        $('#WORKDAY_STR').val(workday);
        $('#WEEKEND_STR').val(weekend);
        $('#WORKDAY_START').val(workday[0]);
        $('#WORKDAY_END').val(workday[1]);
        $('#WEEKEND_START').val(weekend[0]);
        $('#WEEKEND_END').val(weekend[0]);
        $('#updDest-modal').modal('toggle');

    })
   
})