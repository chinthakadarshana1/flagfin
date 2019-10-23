cHiNCommon = (function($) {
    "use strict";

    let CommonFunctions = function() {
        //private

    };

    //public
    CommonFunctions.prototype.cHiNLoader = function(isShow, containerElement) {
        let container = containerElement;
        if(container)
            container.css("position", "relative");

        ((container && container.children()) || $("#mainBodyContainer")).addClass("blurred-background");

        let containerHeight = container ? container.height() : $(window).height();
        let imgWidth;

        if (containerHeight <= 10) {
            imgWidth = 50;
        } else if (containerHeight <= 50) {
            imgWidth = 30;
        } else if (containerHeight <= 200) {
            imgWidth = 50;
        } else {
            if (container) {
                imgWidth = (containerHeight / 6) > 60 ? 60 : (containerHeight / 6);
            } else {
                imgWidth = (containerHeight / 10);
            }
        }
        if (isShow) {
            if (container) {
                if ($("#initLoader").length === 0) {
                    container.append("<div class='loader-container'>"
                        + "<div style='width:" + imgWidth + "px;height:" + imgWidth + "px;'><div class='loader2'></div></div>"
                        +"</div>");
                }

            } else {
                $("body").append("<div class='loader-container' style='position:fixed'>"
                    + "<div style='width:" + imgWidth + "px;height:" + imgWidth + "px;'><div class='loader2'></div></div>"
                    +"</div>");
            }

        } else {
            if (container) {
                let ldr1 = container.children(".loader-container");
                ldr1.css("animation-name", "animateShadeOff");
                setTimeout(function () { ldr1.remove(); }, 750);
                if ($("#initLoader").length > 0) {
                    let ldr2 = $("body").children("#initLoader");
                    ldr2.css("animation-name", "animateShadeOff");
                    setTimeout(function () { ldr2.remove(); }, 750);
                }
                container.children().removeClass("blurred-background");
            } else {
                let ldr3 = $("body").find(".loader-container");
                ldr3.css("animation-name", "animateShadeOff");
                $("body").find(".blurred-background").removeClass("blurred-background");
                setTimeout(function () { ldr3.remove(); }, 750);
            }

        }
    };

    CommonFunctions.prototype.ServerAjaxPost = function(url, postData, type = "POST") {
        let headers = {};
        if(window.MasterVars.ApiToken){
            headers = { 'Authorization': 'Bearer '+window.MasterVars.ApiToken };
        }
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: url,
                headers : headers,
                type: type,
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify(postData),
                success: function(data) {
                    if(data){
                            resolve(data);
                    }else{
                        $.growl.error({title: "Error occurred", message: "Api Call Error" });
                        reject("Api Call Error");
                    }
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    let msg = "Error Occurred";
                    let title = "Error Occurred";
                    let isRedirect = false;
                    switch (jqXhr.status) {
                        case 400:
                            title = errorThrown;
                            msg ="";
                            $(jqXhr.responseJSON).each(function (index, item) {
                                msg += item.description+"<br>";
                            });
                            break;
                        case 403:
                            title = "Forbidden";
                            msg ="Request Forbidden";
                            break;
                        case 401:
                            title = "Session expired";
                            msg ="Session expired";
                            isRedirect = true;
                            break;
                        default:
                            break;
                    }
                    $.growl.error({title: title, message: msg });
                    reject(jqXhr);
                    window.CommonFunctions.cHiNLoader(false);
                    if(isRedirect){
                        setTimeout(function () {
                            window.location.href = window.MasterVars.BaseUrl+"index.php/user/logoutUser";
                        },1000);
                    }
                }
            });
        });
    };

    CommonFunctions.prototype.ServerAjaxPost2 = function(url, postData) {
        return new Promise(function (resolve, reject) {
            $.ajax({
                url: url,
                type: "POST",
                data: postData,
                success: function(data) {
                    if(data){
                        let status = data.status;
                        if(status.isSuccessfull)
                            resolve(data.data);
                        else{
                            if(status.redirect){
                                window.location.replace(status.redirect);
                            }else{
                                $.growl.error({title: "Error occurred", message: status.message });
                                console.log(status.message);
                                window.cHiNCommon.CommonFunctions.cHiNLoader(false);
                                reject(status.message);
                            }
                        }
                    }else{
                        $.growl.error({title: "Error occurred", message: "Api Call Error" });
                        reject("Api Call Error");
                    }
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    $.growl.error({title: "Error occurred", message: errorThrown });
                    reject(jqXhr);
                }
            });
        });
    };

    CommonFunctions.prototype.scrollTo = function(element) {
        $("html,body").animate({
                scrollTop: element.offset().top - 75
            },
            750);
    };

    CommonFunctions.prototype.validateFeilds = function (parentDiv) {
        let ret = true;
        parentDiv.find(".vue-validator-field").trigger("vue:validate-field");
        let invalidFeilds = parentDiv.find(".vue-invalid");
        if(invalidFeilds.length > 0){
            ret = false;
            window.cHiNCommon.CommonFunctions.scrollTo($(invalidFeilds[0]));
        }
        return ret;
    };

    CommonFunctions.prototype.getUrlParam = function (name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    };

    return {
        CommonFunctions : new CommonFunctions()
    }

}(window.jQuery));

