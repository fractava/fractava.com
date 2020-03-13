refreshCSSClasses();

window.addEventListener('resize', function(event){
    refreshCSSClasses();
});
function refreshCSSClasses(){
    return new Promise(function(resolve,reject){
        let md = new MobileDetect(window.navigator.userAgent);
        
        $("html").removeClass("mobile no-mobile phone no-phone tablet no-tablet");
        
        $("html").addClass((md.mobile() ? "mobile":"no-mobile"));
        $("html").addClass((md.phone() ? "phone":"no-phone"));
        $("html").addClass((md.tablet() ? "tablet":"no-tablet"));
        resolve();
    });
}

export{refreshCSSClasses};