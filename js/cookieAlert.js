$(document).ready(function() {
    checkCookiePermission();
});
function checkCookiePermission(){
  if(getCookie("cookieLevel") == ""){
    $("#cookieAlert").show();
  }else{
    cookiesAccepted();
  }
}
function cookiesAccepted(){
  runGoogleAnalytics();
}
function acceptCookies(){
    setCookie("cookieLevel","1",400);
    cookiesAccepted();
    $("#cookieAlert").hide();
}
function declineCookies(){
    $("#cookieAlert").hide();
}
