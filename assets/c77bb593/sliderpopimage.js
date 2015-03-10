/**
 * @preserve SliderPopImage v 1.1 2013-05-19
 * http://www.webkit.gr
 *
 * Copyright (c) 2013, Konapaz
 * Licensed under the NEW BSD license.
 */

$(document).ready(function() {

    var popupStatus = 0;
    var RepopupBox = true;
    var timeoutPopImg;

    function loadPopup(thethis) {

        if (popupStatus == 0) {
            if (RepopupBox) {
                var im1 = $('<img style="z-index:10000"/>').attr('src', mypopimageAssets + '/ajax-loader.gif').load(function() {
                    $("#popupBox").hide();
                    if (!document.getElementById("imgPreload-fix")) {
                        $('<div id="imgPreload-fix" />').append(im1).appendTo('body');
                        centerPopup("#imgPreload-fix img");
                    }
                    loadImg(thethis);
                });
            } else {
                var im1 = $('<img style="position:absolute; top:0; left:0;  z-index:10000"/>').attr('src', mypopimageAssets + '/ajax-loader-min.gif').load(function() {
                    if (!document.getElementById("imgPreload-fix")) {
                        $('<div id="imgPreload-fix" />').append(im1).appendTo('#popupBox');

                    }

                    loadImg(thethis);
                });
            }
        }
    }

    function loadImg(thethis) {
        $("#backgroundPopup").css({
            "opacity": "0.7"
        });

        $("#backgroundPopup").fadeIn("fast");
        var url = $(thethis).attr('src');
        curThumbImgUrl = url; //store for slideshow issue

        var re = "" + postfixThumb + ".";  ///_thumb./;
        url = url.replace(re, ".");

        if (relPathThumbs  instanceof Array) {
            for (index in relPathThumbs) {
                re = "/" + relPathThumbs[index] + "/";   // /\/thumbs\//;
                url = url.replace(re, "/");
            }
        } else {
            re = "/" + relPathThumbs + "/";   // /\/thumbs\//;
            url = url.replace(re, "/");
        }

        timeoutPopImg = setTimeout(function() {
            $('<img />').attr('src', url).load(function() {

                $("#popupBox #poptheimg").attr('src', $(this).attr('src'));
                var diff = $('#popupBox').outerWidth() - $('#popupBox').width();
                $('#popupBox  #poptheimg').css('max-width', maxpopuwidth - diff);

                centerPopup();
                $("#popupBox").fadeIn("fast");
                $('#imgPreload-fix').remove();

            });
        }, 100);

        popupStatus = 1;
    }


    function disablePopup() {
        $("#backgroundPopup").fadeOut("fast");
        $("#popupBox").fadeOut("fast");
        $('#imgPreload-fix').remove();
        popupStatus = 0;
        RepopupBox = true;
        clearTimeout(timeoutPopImg);
    }


    function centerPopup(selector) {
        selector = selector || "#popupBox";

        var windowWidth = $(window).width(); //document.documentElement.clientWidth;  
        var windowHeight = $(window).height(); //document.documentElement.clientHeight;  
        var popupHeight = $(selector).outerHeight();
        var popupWidth = $(selector).outerWidth();

        $(selector).css({
            "position": "fixed",
            "top": windowHeight / 2 - popupHeight / 2,
            "left": windowWidth / 2 - popupWidth / 2
        });

    }

    $.fn.getClassByPrefix = function(prefix) {
        var classes = $(this).attr('class').split(' ');
        for (var i = 0; i < classes.length; i++) {
            var regex = new RegExp('^' + prefix);
            var matches = regex.exec(classes[i]);
            if (matches != null) {
                return classes[i];
            }
        }
    };

    $(window).resize(function() {
        centerPopup();
    });




    $(document).ajaxComplete(function() {
        initialPopClass();
    });


    var maxImgPops = 0;
    initialPopClass();
    function initialPopClass() {
        maxImgPops = 0;
        $(selectorImgPop).each(function() {
            $(this).addClass("customImgPopId-" + maxImgPops);
            maxImgPops++;
        });
        initialBoxes();
    }

    var curPopImgId = -1;

    function initialBoxes() { //alert(maxImgPops);
        if (popupwithpaginate == false || maxImgPops < 2) {
            $('#popupBox,#popupBox #block-arr,#popupBox #close-but').addClass('no-disp');
        } else {
            $('#popupBox,#popupBox #block-arr,#popupBox #close-but').removeClass('no-disp');

            $("#popupBox #arrow-l").click(function() {
                popupimgnav(-1);
            });

            $("#popupBox #arrow-r").click(function() {
                popupimgnav(1);
            });


        }
    }



    function popupimgnav(direct) {

        if (direct == 1) {

            curid = (curPopImgId.split('-')[1]);
            curid++;
            curid = curid % maxImgPops;
            curPopImgId = curPopImgId.split('-')[0] + '-' + curid;


            popupStatus = 0;
            RepopupBox = false;
            $('.' + curPopImgId).trigger("click");
        }

        if (direct == -1) {

            curid = (curPopImgId.split('-')[1]);
            curid--;
            if (curid < 0)
                curid = maxImgPops + curid;
            curPopImgId = curPopImgId.split('-')[0] + '-' + curid;

            popupStatus = 0;
            RepopupBox = false;
            $('.' + curPopImgId).trigger("click");
        }

    }


    $(document).on('click', selectorImgPop, function() {
        curPopImgId = $(this).getClassByPrefix('customImgPopId-');   // $(this).attr("class").split(' ');
        //alert(curPopImgId);
        loadPopup(this);
    });



    $("#popupBox #close-but, #backgroundPopup").click(function() {
        disablePopup();
    });

    $(document).keyup(function(e) { //TODO den doulevei!

        if ((e.keyCode == 27 || e.keyCode == 13 || e.keyCode == 32)) {  // && popupStatus==1
            disablePopup();
        }

        if (popupwithpaginate == true) {
            if (popupStatus != 0) {
                if (e.keyCode == 39) {
                    popupimgnav(1);
                }

                if (e.keyCode == 37) {
                    popupimgnav(-1);
                }
            }
        }
    });
});