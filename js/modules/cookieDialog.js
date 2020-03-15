import * as cookies from "/js/modules/cookies.js";
import * as googleAnalytics from "/js/modules/googleAnalytics.js";

function init() {
    return new Promise(function(resolve,reject){
        checkCookiePermission();
        resolve();
    });
}
function checkCookiePermission(){
  if(cookies.getCookie("cookieLevel") == ""){
    console.log("hello");
    $("#cookieAlert").show();
  }else{
    onCookiesAccepted();
  }
}
function onCookiesAccepted(){
  googleAnalytics.run();
}
function acceptCookies(){
    cookies.setCookie("cookieLevel","1",400);
    onCookiesAccepted();
    $("#cookieAlert").hide();
}
function declineCookies(){
    $("#cookieAlert").hide();
}

export{init, checkCookiePermission, acceptCookies, declineCookies};