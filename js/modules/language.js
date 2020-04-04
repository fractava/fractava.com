var language;
var languageData;

function init() {
    return new Promise(function(resolve,reject){
        loadNavigatorLanguageIfAvailable()
        .then(function() {
            resolve();
        });
    });
}
function loadNavigatorLanguageIfAvailable() {
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
                languageData = data;
                resolve();
            }
        })
        .fail(function() {
            reject();
        })
        language = languageName;
    });
}
function loadModuleLanguage(langArray) {
    if(langArray[navigator.language]) {
        return langArray[navigator.language];
    }else {
        return langArray["en-US"];
    }
    
}
function get(name) {
    return languageData[name];
}
function getLanguageName() {
    return language;
}

export{init, loadModuleLanguage, get, getLanguageName};