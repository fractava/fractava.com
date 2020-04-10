let md;

function init() {
    return new Promise(function(resolve,reject){
        refresh();
        
        window.addEventListener('resize', refresh);
        
        resolve();
    });
}
function refresh() {
    refreshCSSClasses()
    .then(loadCSS);
}
function refreshCSSClasses(){
    return new Promise(function(resolve,reject){
        md = new MobileDetect(window.navigator.userAgent);
        
        $("html").removeClass("mobile no-mobile phone no-phone tablet no-tablet");
        
        $("html").addClass((md.mobile() ? "mobile":"no-mobile"));
        $("html").addClass((md.phone() ? "phone":"no-phone"));
        $("html").addClass((md.tablet() ? "tablet":"no-tablet"));
        resolve();
    });
}
function loadCSS() {
    return new Promise(function(resolve,reject){
        if(md.mobile()) {
            import("./../../css/mobile.css");
        }else {
            import("./../../css/desktop.css");
        }
    });
}

export{init, refreshCSSClasses};