import * as network from "/js/modules/network.js";

var loggedIn;
var username;

function init() {
    checkLoggedIn();
}
function checkLoggedIn() {
    network.getDataRequest({"getData": "loggedIn"})
    .then(function(data) {
        if($(data).find("isLoggedIn")[0].textContent == "true") {
            loggedIn = true;
            username = $(data).find("username")[0].textContent;
        }else {
            loggedIn = false;
            username = undefined;
        }
        updateAccountContainer();
    });
}
function updateAccountContainer() {
    if(loggedIn) {
        $("#accountUsername").text(username);
        $("#accountContainerNotLoggedIn").hide();
        $("#accountContainerLoggedIn").show();
    }else {
        $("#accountContainerLoggedIn").hide();
        $("#accountContainerNotLoggedIn").show();
    }
}
function login(username, password) {
    
}
function logout() {
    network.actionRequest({action: "logout"}, true, true)
    .then(function() {
        checkLoggedIn();
    });
}
function getLoggedIn() {
    return loggedIn;
}
function getUsername() {
    return username;
}

export{init, getLoggedIn, getUsername, checkLoggedIn, login, logout};
