let CommonFunctions = cHiNCommon.CommonFunctions;

$(document).ready(
    function () {
        bindUI();
    }
);

function bindUI() {
    $("#frmLogin").on('keypress',function(e) {
        if(e.which == 13) {
            loginUser();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
    $("#btnLogin").click(loginUser);
}

function validateFields() {
    let ret = true;
    if(!$("#txtUserName").val()){
        ret = false;
        invalidField($("#txtUserName"));
    }
    if(!$("#txtPassword").val()){
        ret = false;
        invalidField($("#txtPassword"));
    }
    return ret;
}

function invalidField(ele) {
    ele.addClass("vue-invalid");
    ele.tooltip("show");
}

function loginUser() {
    if(validateFields()){
        let loginBox = $("#divLogin");
        let req= {
            username : $("#txtUserName").val(),
            password : $("#txtPassword").val()
        };
        CommonFunctions.cHiNLoader(true,loginBox);
        CommonFunctions.ServerAjaxPost2(window.pageVars.loginUrl,req)
            .then(function (data) {
                if (data && data.UserId) {
                    console.log(data);
                    CommonFunctions.cHiNLoader(false,loginBox);

                    let returnUrl = CommonFunctions.getUrlParam("return") || window.pageVars.baseUrl;
                    window.location.replace(returnUrl);
                }else{
                    CommonFunctions.cHiNLoader(false,loginBox);
                    $.growl.error({title: "Login Error occurred", message: "Couldn't Login to system" });
                }
            }.bind(this))
            .catch(function (error) {
                $("#txtUserName").val("");
                $("#txtPassword").val("");
            });
    }
}