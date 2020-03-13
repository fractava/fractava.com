import * as dialogs from "/js/modules/dialogs.js";
import * as network from "/js/modules/network.js";

$("#accountLogin").click(function() {
    dialogs.loginDialog();
});

$("#accountRegister").click(function() {
    dialogs.registerDialog();
});

$("#accountLogout").click(function() {
    network.actionRequest({action: "logout"}, true, true)
    .then(function() {
        update();
    });
});

function switchViewMode(loggedIn) {
    if(loggedIn){
        $("#accountContainerNotLoggedIn").hide();
        $("#accountContainerLoggedIn").show();
    }else {
        $("#accountContainerNotLoggedIn").show();
        $("#accountContainerLoggedIn").hide();
    }
}
function update() {
    network.getDataRequest({"getData": "loggedIn"})
    .then(function(data) {
        console.log(data);
        
        if($(data).find("isLoggedIn")[0].textContent == "true") {
            switchViewMode(true);
            $("#accountUsername").text($(data).find("username")[0].textContent)
            console.log("loggedIn");
        }else {
            switchViewMode(false);
        }
    });
}

export{update};