var config;

function init() {
    return new Promise(function(resolve, reject) {
        $.get("/config/config.json")
        .then(function(data) {
            console.log(data);
            config = data;
            resolve();
        });
    });
}
function getAttribute(name) {
    return config[name];
}

export{init, getAttribute};
