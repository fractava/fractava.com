import * as network from "/js/modules/network.js";

var loggedIn;
var username;

function init() {
    return new Promise(function(resolve,reject){
        checkLoggedIn();
        resolve();
    });
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
        //$("#avatarImg").attr("src", "/getData.php?getData=avatar&username="+username);
        network.getDataRequest({"getData": "avatar", "username": username})
        .then(function(data) {
            let imageData = $(data).find("imageData")[0].textContent;
            let avatarType = $(data).find("avatarType")[0].textContent;
            $("#avatarImg").removeClass("pixelArt default file");
            $("#avatarImg").addClass(avatarType);
            $("#avatarImg").attr("src", "data:image/png;base64,"+imageData);
        });
    }else {
        $("#accountContainerLoggedIn").hide();
        $("#accountContainerNotLoggedIn").show();
    }
}
function toggleDropdown() {
    $("#avatar").toggleClass("active");
}
function closeDropdown() {
    $("#avatar").removeClass("active");
}
function login(email, password) {
    
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

export{init, getLoggedIn, getUsername, checkLoggedIn, toggleDropdown, closeDropdown, login, logout};
