var config;

function init() {
    $.get("/config/config.json")
    .then(function(data) {
        console.log(data);
        config = data;
    });
}
function getAttribute(name) {
    return config[name];
}

export{getAttribute};
