import * as modules from "/js/modules/modules.js";

function init() {
    return new Promise(function(resolve,reject){
        Vue.component('remoteValueInputField', {
            "props": [
                'getDataValues',
                'getDataValueName',
                'actionValues'
            ],
            "data": function () {
                return {
                    value: "",
                    modules: modules
                }
            },
            "methods": {
                "getRemoteValue": async function() {
                    let parameters = JSON.parse(this.getDataValues);
                    let data = await this.modules.network.getDataRequest(parameters);
                    this.value = $(data).find(this.getDataValueName)[0].textContent;
                },
                "setRemoteValue": function() {
                    let parameters = $.extend(JSON.parse(this.actionValues), {newValue: this.value});
                    this.modules.network.actionRequest(parameters);
                }
            },
            "watch": {
                "value": function() {
                    this.setRemoteValue();
                }
            },
            "mounted": function () {
                console.log(this);
                this.getRemoteValue();
            },
            "template": '<input v-model:value="value"></input>'
        });
        
        resolve();
    });
}

export {init};