$(document).ready(function () {
    // 文章详情页
    editormd.markdownToHTML("editor", {
        htmlDecode     : "style,script,iframe",  // you can filter tags decode
        emoji          : false,
        taskList       : false,
        tex            : false,  // 默认不解析
        flowChart      : false,  // 默认不解析
        sequenceDiagram: false,  // 默认不解析
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
        selector: '.primary img'
    });

});
