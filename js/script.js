$(function () {
    //for different brousers
    sessionDie();

    var $body = $(document.body);

    var files;

    $body.on('submit', '#post-form', function(e){
        e.preventDefault();

        files = $('#file-txt').get(0).files[0];

        var data = new FormData();
        data.append(0, files);

        $.ajax({
            type: 'POST',
            url: './php/ajax.php?uploadtxt',
            data: data,
            processData: false,
            contentType: false,
            success: function (data) {
                htmladd = $('#box-images').html() + data;
                $('#box-images').html(htmladd);
                $( ".images-img" ).load(function() {
                    resizeImages();
                });
            },
            error: function(xhr, status, error) {
                // alert(xhr.responseText + '|\n' + status + '|\n' +error);
            }

        });
    });
});


$(window).resize(function() {
    resizeImages();
});


resizeImages = function (){
    widthvar = $('#box-images').width();
    totalwidthimg = 0;
    counter = 0;

    $('.images-img').each(function() {

        $(this).attr('data-line', counter);
        
        widthimg = $(this).width();
        heightinmg = $(this).height();
        multiplier = 200 / heightinmg;
        widthimg = widthimg * multiplier;
        totalwidthimg = totalwidthimg + widthimg + 4;

        if(totalwidthimg > widthvar){
            multiplier = (widthvar - 10) / totalwidthimg;
            height = 200 * multiplier;
            totalwidthimg = 0;
            $('img[data-line=' + counter + ']').css("height", height);
            counter++;
        }
    });
}


sessionDie= function (){
    $.ajax({
        type: 'POST',
        url: './php/sessdie.php',
        success: function (data) {
        },
        error: function(xhr, status, error) {
        }
    });
};

//for different brousers
window.onbeforeunload = function() {
    sessionDie();
};