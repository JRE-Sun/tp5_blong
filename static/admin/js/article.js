$(document).ready(function () {
    var editor       = editormd("editor", {
        width        : "100%",
        height       : 640,
        syncScrolling: "single",
        path         : window.path
    });
    var theme        = "ios";
    var mode         = "scroller";
    var display      = "bottom";
    var lang         = "zh";
    var currDateYrar = new Date();
    currDateYrar     = currDateYrar.getFullYear() * 1;
    $('#demo_datetime').mobiscroll().datetime({
        theme     : theme,
        mode      : mode,
        display   : display,
        lang      : lang,
        minDate   : new Date(currDateYrar - 3, 1, 1, 23, 59),
        maxDate   : new Date(currDateYrar + 3, 1, 1, 23, 59),
        stepMinute: 1
    });
    setTimeout(function () {
        $(window).resize();
    }, 100);
});