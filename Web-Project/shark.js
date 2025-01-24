$(document).ready(function() 
{
    $("button").click(function() {
        if ($(".slideshow-container").is(":visible")) {
            $(".slideshow-container").animate({ right: '2500px' });
            $(".slideshow-container").fadeOut();
            $("#head-text").css("color", "midnightblue").slideUp(2000);
            $("#div3").fadeToggle(4000);
        }
        else {
            $("#div3").fadeToggle(1);
            $(".slideshow-container").fadeIn().animate({ right: '0px' });
            $("#head-text").slideDown(2000).css("color", "black");
        }
    });
    $("#choose-car-btn").click(function(event)
     {
        event.preventDefault(); 
        window.location.href = "SR.html";
    });
});
