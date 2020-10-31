(function (d) {
    d['okValue'] = '确定';
    d['cancelValue'] = '取消';
    d['title'] = '消息';
    d['lock'] = true;
})($.dialog.defaults);

$(document).ready(function (e) {
	
    $.dialog.alert = function (title, content, okfunc) {
        $.dialog({
            title: title,
            padding: '5px',
            content: content,
            ok: function () {
                if (okfunc) return okfunc();
            }
        });
    };
    $.dialog.confirm = function (title, content, okfunc, cancelfunc) {
        $.dialog({
            title: title,
            padding: '5px',
            content: content,
            ok: function () {
                if (okfunc) return okfunc();
                return true;
            },
            cancel: function () {
                if (cancelfunc) return cancelfunc();
                return true;
            }
        });
    };

    if (/Mobile/i.test(navigator.userAgent) || (/MIDP|SymbianOS|NOKIA|SAMSUNG|LG|NEC|TCL|Alcatel|BIRD|DBTEL|Dopod|PHILIPS|HAIER|LENOVO|MOT-|Nokia|SonyEricsson|SIE-|Amoi|ZTE/.test(navigator.userAgent))) {
        try {
            $(".web_pagePos").hide();
        } catch (e) {
        }
    }

    var timer;

    bindMouseover();

    $(".input").focus(function () {

        if ($.trim($(this).val()) == "您的联系方式(QQ、手机或邮箱)") {
            $(this).val("");
        }
    });

    $(".textarea").focus(function () {

        if ($.trim($(this).val()) == "您的反馈内容") {
            $(this).val("");
        }
    });


    var isOpen = false;
    $(".submit11").on('click', function () {
        var content = $.trim($("#postContent").val());
        var type = $.trim($("#feedbacktype").val());
        var contact = $.trim($(".input[name='contact']").val());

        if (type == "") {
            isOpen = true;
            $.dialog.alert("提示", '请选择意见反馈类型！');
            return;
        }
        if (content == "" || content == "您的反馈内容") {
            isOpen = true;
            $.dialog.alert("提示", '请填入反馈内容！');
            return;
        }
        if (contact == "" || contact == "您的联系方式(QQ、手机或邮箱)") {
            isOpen = true;
            $.dialog.alert("提示", '请填入联系方式！');
            return;
        }
        if (content.length < 10) {
            isOpen = true;
            $.dialog.alert("提示", '反馈内容不能少于10字！');
            return;
        }
        if (contact.length < 8) {
            isOpen = true;
            $.dialog.alert("提示", '联系方式不能少于8字！');
            return;
        }
        if (content.length > 200) {
            isOpen = true;
            $.dialog.alert("提示", '反馈内容不能多于500字！');
            return;
        }
        if (contact.length > 100) {
            isOpen = true;
            $.dialog.alert("提示", '联系方式不能多于100个字！');
            return;
        }
        var data = { type: type, content: content, contact: contact };

        $.post('/liu.html', data, function (result) {
            if (result.code =="0") {
                isOpen = false;
                $(".pageFormList .select").html("请选择意见反馈类型");
                $("input[name='type']").val("");
                $("input[name='contact']").val("您的联系方式(QQ、手机或邮箱)");
                $(".textarea").val("您的反馈内容");
                $.dialog.alert("提示", result.msg);
            } else {
                isOpen = true;
                $.dialog.alert("提示", result.msg);
            }

        }, 'json').error(function () {
            isOpen = false;
            $.dialog.alert("提示", "反馈失败，请稍后重新尝试！");
            $.dialog.loading.hide();
        });


    });

    $(".pageFanY").click(function () {
        if ($(".pageForm").css("display") != "none" || $(".web_pagePos").is(":animated")) {
            return;
        }
        if ($(".web_pagePos").attr("style") != undefined) {
            $(".web_pagePos").attr("style", "");
            return;
        }
        openPage();
    });

    $(".pageForm").hover(
        function () {
            isOpen = false;
            window.clearTimeout(timer);
        },
        function () {
            if (!isOpen) {
                timer = window.setTimeout(function () {
                    closePage();
                }, 500);
            }
        }
    );


    $(".pageFormList .select").click(function () {
        $(".pageFormList .option").fadeIn(100);
    });

    $(".pageFormList .option a").click(function () {

        $(".pageFormList .select_span input").val($(this).html());
        $(".pageFormList .select").html($(this).html());
        $(this).parent().fadeOut(100);
    });

    $(".pageFormList .option").mouseleave(function () {
        $(this).fadeOut(100);
    });


    function openPage() {

        $(".web_pagePos").stop(true, true);

        $(".web_pagePos").stop(true, true).animate({ width: 800, height: 678 }, 300, function () {
            $(".pageForm").stop(true, true).fadeIn(300);
        });

        $(".pagePen").fadeOut(200);
        $(".pageFanY").unbind("mouseenter");
        $(".pageFanY").unbind("mouseleave");
        $(".pageFanBg").removeClass("pageBgSmall");
        $(".pageFanBg").removeClass("pageHover");
        $(".pageFanY").removeClass("pageFanSmall");
    }


    function closePage() {

        $(".web_pagePos").stop(true, true);

        $(".web_pagePos").filter(':not(:animated)').stop(true, true).animate({ width: 100, height: 110 }, 300, function () {

            $(".pageFanY").addClass("pageFanSmall");
            $(".pageFanBg").addClass("pageBgSmall");
            $(".pagePen").fadeIn(200);

            $(".pageForm").css({ "display": "none" });
            $(".web_pagePos").removeAttr("style");

            bindMouseover();

        });

        $(".pageForm").filter(':not(:animated)').stop(true, true).fadeOut(200, function () {
            // $(".pageFormList .select").html("请选择意见反馈类型");
            // $("input[name='type']").val("");
            // $("input[name='contact']").val("您的联系方式(QQ、手机或邮箱)");
            // $(".textarea").val("您的反馈内容");
        });

    }


    function bindMouseover() {

        $(".pageFanY").bind("mouseenter",
                    function () {
                        $(".web_pagePos").removeAttr("style");
                        $(".pageFanBg").addClass("pageHover");
                    }
                )
        $(".pageFanY").bind("mouseleave",
                    function () {
                        $(".web_pagePos").removeAttr("style");
                        $(".pageFanBg").removeClass("pageHover");
                    }
                )
    }
});

//为反馈类型赋值
function setFeedbackType(type) {
    $("#leixing").val(type);

}
