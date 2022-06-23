$(document).ready(function(){
    $(document).on('click','button[data-role=update]', function(){
        var id = $(this).data('id');
        var level = $('#'+id).children('td[data-target=level]').text();
        var lastname = $('#'+id).children('td[data-target=lastname]').text();
        var firstname = $('#'+id).children('td[data-target=firstname]').text();
        var birthdate = $('#'+id).children('td[data-target=birthdate]').text();
        var phone = $('#'+id).children('td[data-target=phone]').text();
        var place = $('#'+id).children('td[data-target=place]').text();
        var idcardNum = $('#'+id).children('td[data-target=idNum]').text();
        var licenseNum = $('#'+id).children('td[data-target=licenseNum]').text();
        var email = $('#'+id).children('td[data-target=email]').text();
        var username = $('#'+id).children('td[data-target=usname]').text();
        
        $('#level').val(level);
        $('#usname').val(username);
        $('#emailc').val(email);
        $('#lname').val(lastname);
        $('#fname').val(firstname);
        $('#phone').val(phone);
        $('#birthd').val(birthdate);
        $('#licenseplace').val(place);
        $('#idNum').val(idcardNum);
        $('#licensenum').val(licenseNum);
        $('#ID').val(id);
        $('#customerdata-modal').modal('toggle');
    })

    $('button[name="update"]').click(function(){
                
        var id = $('#ID').val();
        var username = $('#usname').val();
        var place = $('#places').val();
        var level = $('#level').val();
        var email = $('#emailc').val();
        var lastname = $('#lname').val();
        var firstname = $('#fname').val();
        var phone = $('#phone').val();
        var birthdate = $('#birthd').val();
        var licenseplace = $('#licenseplace').val();
        var idcardNum = $('#idNum').val();
        var licenseNum = $('#licensenum').val();
        
        $.ajax({
            url : 'admin_update.php',
            method : 'post',
            data : { id : id, email : email, lastname : lastname, firstname : firstname, phone : phone, birthdate : birthdate, licenseplace : licenseplace, idcardNum : idcardNum, licenseNum : licenseNum, level : level, username : username, place : place},
            success : function(){
                $('#'+id).children('td[data-target=usname]').text(username);
                $('#'+id).children('td[data-target=place]').text(place);
                $('#'+id).children('td[data-target=level]').text(level);
                $('#'+id).children('td[data-target=email]').text(email);
                $('#'+id).children('td[data-target=lastname]').text(lastname);
                $('#'+id).children('td[data-target=firstname]').text(firstname);
                $('#'+id).children('td[data-target=birthdate]').text(birthdate);
                $('#'+id).children('td[data-target=phone]').text(phone);
                
                $('#customerdata-modal').modal('toggle');
            }
        });
    });

    $('button[name="del"]').click(function(){
        var id = $('#ID').val();

        $.ajax({
            url:'admin_delete.php',
            method: 'post',
            data: { id : id },
            success : function (){
                $('#customerdata-modal').modal('toggle');
                document.getElementById(id).style.display = "none";
            }
        });
    });
});