function setFormat(format) {
    $("#format").val(format);
    $(".format").removeClass("active");
    $("#format_" + format).addClass("active");
}

function checkAdb() {
    if (typeof(adsOn) == "undefined") {
        $("body").addClass('adb');
        if (typeof(ga) == "function") ga('send', 'event', 'adblock', 'showBlocker');
        return false;
    }
    return true;
}

function popup(){
    console.log("popup");
    $('body').addClass("popup");
    $("#popup .close").click(function() {$('body').removeClass("popup");});
    $(".input_content input").off("focus", popup);
    setCookie("know-x", 1, "session");
}

function like_popup(){
    if ($("#like_popup").length > 0) {
        $('body').addClass("like_popup");
        $("#like_popup .close").click(function() {$('body').removeClass("like_popup");});
    }
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    var expires = "";
    if (exdays != "session") {
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        expires = "expires="+d.toUTCString();
    }
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

$('#mainForm').on('beforeSubmit', function () {
    if (checkAdb()) {
        $("#loader").fadeIn(500);
    } else {
        return false;
    }
});