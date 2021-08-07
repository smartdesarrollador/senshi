/*$('.myAccount').dropdown();
mediumZoom('[data-zoomable]', {
    margin: 0,
    background: '#000000',
    scrollOffset: 40

});*/
/*$(function () {
    $('[data-toggle="popover"]').popover()
})*/
$(function () {

    var $formLogin = $('#login-form');
    var $formLost = $('#lost-form');
    var $formRegister = $('#register-form');
    var $divForms = $('#div-forms');
    var $modalAnimateTime = 300;
    var $msgAnimateTime = 150;
    var $msgShowTime = 2000;

    $("form").submit(function () {
        switch (this.id) {
            case "login-form":
                /*var $lg_username = $('#login_username').val();
                var $lg_password = $('#login_password').val();
                if ($lg_username == "ERROR") {
                    msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "error", "glyphicon-remove", "Login error");
                } else {
                    msgChange($('#div-login-msg'), $('#icon-login-msg'), $('#text-login-msg'), "success", "glyphicon-ok", "Login OK");
                }*/
                return true;
                break;
            case "lost-form":
                return true;
            case "register-form":


                var $rg_password = $('#register_password').val();
                var $rg_password2 = $('#register_password2').val();

                if ($rg_password !== $rg_password2) {
                    document.getElementById('alertaContrasenas').classList.remove('d-none');
                    setTimeout(()=>{
                        document.getElementById('alertaContrasenas').classList.add('d-none');

                    },3000)

                } else {
                    /*msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok", "Register OK");*/
                    return true;

                }
                break;
            case "resetPass-form":

                var $rg_password = $('#passwordReset').val();
                var $rg_password2 = $('#passwordReset2').val();

                if ($rg_password !== $rg_password2) {
                    $('#nocoinciden').show();
                    $('#passwordReset2').val('');
                    $('#passwordReset').val('');


                } else {
                    /*msgChange($('#div-register-msg'), $('#icon-register-msg'), $('#text-register-msg'), "success", "glyphicon-ok", "Register OK");*/
                    return true;

                }
                break;
            default:
                return true;
        }
        return false;
    });

    $('#login_register_btn').click(function () {
        modalAnimate($formLogin, $formRegister)
    });
    $('#register_login_btn').click(function () {
        modalAnimate($formRegister, $formLogin);
    });
    $('#login_lost_btn').click(function () {
        modalAnimate($formLogin, $formLost);
    });
    $('#lost_login_btn').click(function () {
        modalAnimate($formLost, $formLogin);
    });
    $('#lost_register_btn').click(function () {
        modalAnimate($formLost, $formRegister);
    });
    $('#register_lost_btn').click(function () {
        modalAnimate($formRegister, $formLost);
    });

    function modalAnimate($oldForm, $newForm) {
        var $oldH = $oldForm.height();
        var $newH = $newForm.height();
        $divForms.css("height", $oldH);
        $oldForm.fadeToggle($modalAnimateTime, function () {
            $divForms.animate({height: $newH}, $modalAnimateTime, function () {
                $newForm.fadeToggle($modalAnimateTime);
            });
        });
    }

    function msgFade($msgId, $msgText) {
        $msgId.fadeOut($msgAnimateTime, function () {
            $(this).text($msgText).fadeIn($msgAnimateTime);
        });
    }

    function msgChange($divTag, $iconTag, $textTag, $divClass, $iconClass, $msgText) {
        var $msgOld = $divTag.text();
        msgFade($textTag, $msgText);
        $divTag.addClass($divClass);
        $iconTag.removeClass("glyphicon-chevron-right");
        $iconTag.addClass($iconClass + " " + $divClass);
        setTimeout(function () {
            msgFade($textTag, $msgOld);
            $divTag.removeClass($divClass);
            $iconTag.addClass("glyphicon-chevron-right");
            $iconTag.removeClass($iconClass + " " + $divClass);
        }, $msgShowTime);
    }
});

/*function changeQty(value, param) {
    const parent = value.parentElement;
    let add = parent.childNodes[3];
    if (param === 'add') {
        add.value = parseInt(add.value) + 1;
    }
    if (param === 'minus') {
        if (parseInt(add.value)>1){
            add.value = parseInt(add.value) - 1;
        }else{
        }

    }


}*/
function changeQtyMin0(value, param, min, max) {
    const parent = value.parentElement;
    let add = parent.childNodes[3];
    if (param === 'add') {
        if (parseInt(add.value) < max) {
            add.value = parseInt(add.value) + 1;
        }
    }
    if (param === 'minus') {

        if (parseInt(add.value) > min) {
            add.value = parseInt(add.value) - 1;
        } else {
        }

    }


}

function toLowerCase(e) {
    e.value = e.value.toLowerCase();
}

function solonumeros(e) {
    var keynum = window.event ? window.event.keyCode : e.which;
    if ((keynum == 8) || (keynum == 46))
        return true;

    return /\d/.test(String.fromCharCode(keynum));
};

/*
setTimeout(manteniminto,5000);

function manteniminto(){
    Swal.fire(
        'Lamentamos las molestias, este sitio se encuentra en mantenimiento',
        'Por favor aún no realice compras',
        'warning'
    )
}*/
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function mostrarLoading() {
    document.getElementById("loading").style.display = "block";
}

function forceLower(strInput) {
    strInput.value = strInput.value.toLowerCase();
}

function changeQty(value, param) {
    const parent = value.parentElement;
    let add = parent.childNodes[3];
    if (param === 'add') {
        add.value = parseInt(add.value) + 1;
    }
    if (param === 'minus') {
        if (parseInt(add.value) > 1) {
            add.value = parseInt(add.value) - 1;
        } else {
        }
    }
}

function checkboxlimit(checkgroup, limit, productoName = 'makis') {
    for (var i = 0; i < checkgroup.length; i++) {

        let checkedcount = 0;
        for (let i = 0; i < checkgroup.length; i++)
            checkedcount += (checkgroup[i].checked) ? 1 : 0;

        if (checkedcount !== limit) {
            alert("En este paquete puedes elegir " + limit + " " + productoName + ".");
            return false;
            /* this.checked = false*/
        }
        return true;


    }
}

function checkboxlimitGeneric(checkgroup, limit) {
    var checkgroup = checkgroup
    var limit = limit
    for (var i = 0; i < checkgroup.length; i++) {
        checkgroup[i].onclick = function () {
            var checkedcount = 0
            for (var i = 0; i < checkgroup.length; i++)
                checkedcount += (checkgroup[i].checked) ? 1 : 0
            if (checkedcount > limit) {
                alert("You can only select a maximum of " + limit + " checkboxes")
                this.checked = false
            }
        }
    }
}

