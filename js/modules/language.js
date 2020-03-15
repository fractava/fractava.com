var language;

function init() {
    return new Promise(function(resolve,reject){
        let languageName = "de";
        $.get({
            "url": "/lang/" + languageName + ".json",
            "dataType": "json",
            "success": function(data) {
                language = data;
                resolve();
            }
        });
    });
}
function get(name) {
    return language[name];
}

export{init, get};