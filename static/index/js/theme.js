(function () {
    "use strict";

    var Theme = {};

    Theme.backToTop = {
        register: function () {
            var $backToTop = $('#back-to-top');
            $(window).scroll(function () {
                setBackToTop();
            });

            setBackToTop();

            function setBackToTop() {
                if ($(window).scrollTop() > 100) {
                    $backToTop.fadeIn(700);
                } else {
                    $backToTop.fadeOut(700);
                }
            }

            $backToTop.click(function () {
                $('html,body').animate({scrollTop: 0});
            });
        }
    };

    Theme.fancybox = {
        register: function () {
            if ($.fancybox) {
                $('.post').each(function () {
                    $(this).find('img').each(function () {
                        $(this).wrap('<a class="fancybox" href="' + this.src + '" title="' + this.alt + '"></a>')
                    });
                });

                $('.fancybox').fancybox({
                    openEffect : 'elastic',
                    closeEffect: 'elastic'
                });
            }
        }
    };

    this.Theme = Theme;
}.call(this));


$(document).ready(function () {
    if (themeConfig.fancybox.enable) {
        Theme.fancybox.register();
    }

    Theme.backToTop.register();

    if ($('.post-content').length > 0) {
        var autocJS =new AutocJS({
            article: '#content',
            title  : '文章目录'
        });

        var str = '<div class="post-menu">目录</div>';
        $('.post-header').append(str);

        $(document).on('click', '.post-menu', function () {
            autocJS.toggle();
        });
    }
});
