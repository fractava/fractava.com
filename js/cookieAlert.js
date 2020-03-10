$(document).ready(function() {
    check_cookie_permission();
});
function check_cookie_permission(){
  if(getCookie("cookie_level") == ""){
    $("#cookieAlert").show();
  }else{
    cookies_accepted();
  }
}
function cookies_accepted(){
  run_google_analytics();
}
function accept_cookies(){
    setCookie("cookie_level","1",400);
    cookies_accepted();
    $("#cookieAlert").hide();
}
function decline_cookies(){
    $("#cookieAlert").hide();
}
