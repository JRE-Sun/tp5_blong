$(document).ready(function () {
    $('img').attr('draggable', 'false');
    $('a').attr('draggable', 'false');
    var checkall = document.getElementsByName("checkbox[]");

    // 全选
    function select() {
        for (var $i = 0; $i < checkall.length; $i++) {
            checkall[$i].checked = true;
        }
    };

    // 反选
    function reverse() {
        for (var $i = 0; $i < checkall.length; $i++) {
            if (checkall[$i].checked) {
                checkall[$i].checked = false;
            } else {
                checkall[$i].checked = true;
            }
        }
    }

    // 全不选
    function noselect() {
        for (var $i = 0; $i < checkall.length; $i++) {
            checkall[$i].checked = false;
        }
    }

    $('.btn-event a').on('click', function () {
        var index = $(this).index();
        switch (index) {
            case 0:
                // 全选
                select();
                break;
            case 1:
                // 反选
                reverse();
                break;
            case 2
            :
                // 不选
                noselect();
                break;
        }
    });

    $("#main table tbody tr td a").click(function (e) {
        if (event.srcElement.outerText === "删除") {
            if (!window.confirm("此操作不可逆，是否确认？")) {
                e.stopPropagation();
                e.preventDefault();
                return false;
            }
        }
    });

    $(document).on('click', '.delete-btn,.recovery-btn', function () {
        var $this        = $(this);
        var checkedInput = $('.table .input-control:checked');
        var checkedIndex = [];
        for (var i in checkedInput) {
            if (typeof checkedInput[i].value == 'undefined') {
                continue;
            }
            checkedIndex.push(checkedInput[i].value);
        }
        $.ajax({
            type    : "post",
            url     : $this.data('api'),
            dataType: "json",
            data    : {
                type        : $this.data('type'),
                checkedIndex: checkedIndex,
            },
            success : function (data) {
                data = JSON.parse(data);
                if (data.error == 0) {
                    alert('服务器错误!');
                    return;
                }
                if (!data.status) {
                    alert('删除失败');
                    return;
                }
                checkedInput.parents('tr').remove();
            },
        });
    });
});