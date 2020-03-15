var language;

function init() {
    return new Promise(function(resolve,reject){
        loadLanguage(navigator.language)
        .then(function() {
            console.log("lang loading successfull");
            resolve();
        })
        .catch(function() {
            console.log("loading en-US instead of " + navigator.language);
            loadLanguage("en-US").then(function() {
                resolve();
            });
        });
    });
}
function loadLanguage(languageName) {
    return new Promise(function(resolve,reject){
        $.get({
            "url": "/lang/" + languageName + ".json",
            "dataType": "json",
            "success": function(data) {
                language = data;
                resolve();
            }
        })
        .fail(function() {
            reject();
        })
    });
}
function get(name) {
    return language[name];
}

export{init, get};