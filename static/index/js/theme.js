$(document).ready(function () {
    var editor = editormd.markdownToHTML("editor", {
        htmlDecode     : "style,script,iframe",  // you can filter tags decode
        emoji          : true,
        taskList       : true,
        tex            : true,  // 默认不解析
        flowChart      : true,  // 默认不解析
        sequenceDiagram: true,  // 默认不解析
    });

    if ($('.post-content').length > 0) {
        setTimeout(function () {
            var autocJS = new AutocJS({
                article: '#content',
                title  : '文章目录'
            });

            var str = '<div class="post-menu">目录</div>';
            $('.post-header').append(str);

            $(document).on('click', '.post-menu', function () {
                autocJS.toggle();
            });
        }, 1500);
    }

    new PageGallery({
        selector: '.post-content img'
    });

});
