"use strict";


$("document").ready(
    function () {
        window.CommonFunctions.cHiNLoader(true);
        window.CommonFunctions.ServerAjaxPost(window.pageVars.dashboardUrl,null, "POST")
            .then(function (data) {
                if (data) {
                    $("#lblPendingReviews").html(data[0]);
                    $("#lblApprovedReviews").html(data[1]);
                    $("#lblRejectedReviews").html(data[2]);
                }else{
                    $.growl.warning({title: "Error Occurred", message: "couldn't retrieve data" });
                    window.CommonFunctions.cHiNLoader(false);
                }
                window.CommonFunctions.cHiNLoader(false);
            });
    }
);