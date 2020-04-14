var loadedStylesheets = [];
var loadedJs = [];

function loadCSS(path) {
    if(!loadedStylesheets.includes(path)) {
        loadedStylesheets.push(path);
        let link = document.createElement('LINK');
        link.rel = "stylesheet";
        link.href = path;
        
        $("head").append(link);
    }
}
function loadJS(path) {
    if(!loadedJs.includes(path)) {
        loadedJs.push(path);
        let script = document.createElement('SCRIPT');
        script.src = path;
        
        $("head").append(script);
    }
}

export{loadCSS, loadJS};