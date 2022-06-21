$('input[type=range]').on('input', function () {
    let inputNumMin = $(this).parent().parent().parent().children('.num-input').children('.min').children('input[type=number]');
    let inputNumMax = $(this).parent().parent().parent().children('.num-input').children('.max').children('input[type=number]');
    let sliderProgress = $(this).parent().parent().children('.slider-progress');
    let gap = parseInt($(this).parent().parent().children('input[name=gap]').val());

    if($(this).attr('name') === "min"){
        let sliderMax = parseInt($(this).parent().children('input[name=max]').val());
        if($(this).val() < sliderMax - gap) {
            inputNumMin.val($(this).val());
        }
        else{
            $(this).val(sliderMax - gap);
        }
        sliderProgress.css("left", ((inputNumMin.val() / inputNumMin.attr('max')) * 100) + "%");
    }
    else if($(this).attr('name') === "max"){
        let sliderMin = parseInt($(this).parent().children('input[name=min]').val());
        if($(this).val() > sliderMin + gap) {
            inputNumMax.val($(this).val());
        }else{
            $(this).val(sliderMin + gap);
        }
        sliderProgress.css("right", "calc( 75% - " + (+(((inputNumMax.val()-gap) / (inputNumMax.attr('max')- (gap/2))) * 100) +"%") + ")" );
    }
});


    $(document).ready(function () {
        let getParams = new URLSearchParams(window.location.search);
        if (getParams.has('comment')) {
            $([document.documentElement, document.body]).animate({
                scrollTop: $("#comment_" + getParams.get('comment')).offset().top
            }, 1500);
            console.log(getParams.get('comment'));
        }
    });

// onclick=\"window.location.href='car.php?car=$value->carID'\"
//     onclick = function (){\"window.location.href='car.php?car=$value->carID'\"; scrollToComment($value->carID)}