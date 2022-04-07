let body = $('body');


$(document).on({
    ajaxStart: function () {
        body.addClass("loadingajax");
        body.addClass("cursor-wait");
    },
    ajaxStop: function () {

        body.removeClass("loadingajax");
        body.removeClass("cursor-wait");
    },
    ajaxSuccess: function (o, e) {
        let ajaxResp = e.responseJSON;
        if (ajaxResp.msg) {
            toastr.success(ajaxResp.msg)
        }
    },
    ajaxError: function myErrorHandler(event, xhr) {
        let error = xhr.responseJSON;

        let errorMsg = '';
        let errorTitle = 'Error!'
        if (error) {
            if (error.rules) {
                errorTitle = 'Validation Error!'
                for (const [key, value] of Object.entries(error.rules)) {
                    errorMsg = errorMsg + ` ${value}` + `<br>`;
                }
            } else if (error.msg) {
                errorMsg = error.msg;
            }else if (error.message) {
                errorMsg = error.message;
            }  else if (error) {
                errorMsg = error.error;
            }
            toastr.error(errorMsg, errorTitle);
        }
    }
});


var classHolder = document.getElementsByTagName("BODY")[0],
    /**
     * Load from localstorage
     **/
    themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
        {"themeOptions": "mod-skin-light mod-nav-link mod-bg-1", "themeURL": "/assets/css/themes/cust-theme-3.css"},
    themeURL = themeSettings.themeURL || '',
    themeOptions = themeSettings.themeOptions || '';
/**
 * Load theme options
 **/
if (themeSettings.themeOptions) {
    classHolder.className = themeSettings.themeOptions;
    console.log("%c✔ Theme settings loaded", "color: #148f32");
} else {
    console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...", "color: #ed1c24");
}
if (themeSettings.themeURL && !document.getElementById('mytheme')) {
    var cssfile = document.createElement('link');
    cssfile.id = 'mytheme';
    cssfile.rel = 'stylesheet';
    cssfile.href = themeURL;
    document.getElementsByTagName('head')[0].appendChild(cssfile);

} else if (themeSettings.themeURL && document.getElementById('mytheme')) {
    document.getElementById('mytheme').href = themeSettings.themeURL;
}
/**
 * Save to localstorage
 **/
var saveSettings = function () {
    themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function (item) {
        return /^(nav|header|footer|mod|display)-/i.test(item);
    }).join(' ');
    if (document.getElementById('mytheme')) {
        themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
    }
    ;
    localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
}
/**
 * Reset settings
 **/
var resetSettings = function () {
    localStorage.setItem("themeSettings", "");
}

$('form').on('focus', 'input[type=number]', function (e) {
    $(this).on('wheel.disableScroll', function (e) {
        e.preventDefault()
    })
})
$('form').on('blur', 'input[type=number]', function (e) {
    $(this).off('wheel.disableScroll')
})


toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": true,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 100,
    "timeOut": 5000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


body.on('click', '.deleteNotification', function (e) {
    e.preventDefault();
    let id = $(this).data('id');
    let that = $(this);

    Swal.fire(
        {
            title: deleteConfirmMsg,
            type: "question",
            showCancelButton: true,
            cancelButtonText: cancelButton,
            confirmButtonText: confirmButton
        }).then(function (result) {
        if (!result.dismiss) {
            $.ajax({
                url: deleteNotificationRoute,
                type: "POST",
                data: {
                    id: id,
                },
                timeout: 600000,
                success: function (data) {
                    if (data.success) {
                        that.parent().parent().parent().remove();
                        let notifyCount = $('.notificationCount');
                        notifyCount.html(parseFloat(notifyCount.data('count')) - 1)
                        toastr.success(data.success)
                    }
                    if (data.error) {
                        toastr.error(data.error)
                    }
                }
            });
        }

    });
})


body.on('click', '.readNotification', function (e) {
    e.preventDefault();
    let that = $(this);

    $.ajax({
        url: readNotificationRoute,
        type: "POST",
        data: {
            id: that.data('id'),
        },
        timeout: 600000,
        success: function (data) {
            if (data.success) {
                that.parent().parent().parent().removeClass('unread');
                let notifyCount = $('.notificationCount');
                notifyCount.html(parseFloat(notifyCount.data('count')) - 1)
            }
            if (data.error) {
                toastr.error(data.error)
            }
        }
    });
})

body.on('click', '#markAllAsRead', function (e) {
    e.preventDefault();

    $.ajax({
        url: readAllNotificationRoute,
        type: "POST",
        data: null,
        timeout: 600000,
        success: function (data) {
            if (data.success) {
                $('.notification li').removeClass('unread')
                let notifyCount = $('.notificationCount');
                notifyCount.html(0)
                $('.notificationCountNum').remove();
            }
            if (data.error) {
                toastr.error(data.error)
            }
        }
    });
})


if (body.hasClass('mod-skin-light')) {
    $('#darkModeSwitch').prop('checked', false)
} else {
    $('#darkModeSwitch').prop('checked', true)
}

body.on('click', '#darkModeSwitch', function (e) {
    localStorage.removeItem('themeSettings')
    if (body.hasClass('mod-skin-light')) {
        localStorage.setItem("themeSettings", "{\"themeOptions\":\"mod-nav-link mod-bg-1 mod-skin-dark\",\"themeURL\":\"/assets/css/themes/cust-theme-3.css\"}");

        body.removeClass('mod-skin-light').addClass('mod-skin-dark')
    } else {
        localStorage.setItem("themeSettings", "{\"themeOptions\":\"mod-nav-link mod-bg-1 mod-skin-light\",\"themeURL\":\"/assets/css/themes/cust-theme-3.css\"}");

        body.removeClass('mod-skin-dark').addClass('mod-skin-light')

    }

})
