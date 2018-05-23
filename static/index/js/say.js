$(document).ready(function () {
    $('.say .content').each(function (index) {
        var text = $(this).html();
        // 找到
        if (text.search(/\$\$/ig) > -1) {
            text = text.replace(/\$\$/ig, '<div class="say-img-wrap">');
            text = text.replace(/%%/ig, '</div>');
            $(this).html(text);
        }
    });
});