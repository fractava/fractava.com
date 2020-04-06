import * as modules from "/js/modules/modules.js";

function init() {
    return new Promise(function(resolve,reject){
        Vue.component('remoteValueInputField', {
            "props": [
                'getDataValues',
                'getDataValueName',
                'actionValues',
                'type'
            ],
            "data": function () {
                return {
                    value: "",
                    modules: modules
                };
            },
            "methods": {
                "getRemoteValue": async function() {
                    let parameters = JSON.parse(this.getDataValues);
                    let data = await this.modules.network.getDataRequest(parameters);
                    this.value = $(data).find(this.getDataValueName)[0].textContent;
                },
                "setRemoteValue": function() {
                    let element = this.$el;
                    let parameters = $.extend(JSON.parse(this.actionValues), {newValue: this.value});
                    this.modules.network.actionRequest(parameters)
                    .catch(function() {
                        $(element).addClass("invalidValue");
                    });
                },
                "invalidValue": function() {
                    if(this.value === "") {
                        return true;
                    }
                    if(this.type == "email") {
                        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        return !re.test(String(this.value).toLowerCase());
                    }
                    
                    return false;
                }
            },
            "watch": {
                "value": function() {
                    if(this.invalidValue()) {
                        $(this.$el).addClass("invalidValue");
                    }else {
                        $(this.$el).removeClass("invalidValue");
                        clearTimeout(this.timer);
                        this.timer = setTimeout(function(setRemoteValue){setRemoteValue(); }, 1000, this.setRemoteValue);
                    }
                }
            },
            "mounted": function () {
                this.getRemoteValue();
            },
            "template": '<input v-model:value="value"></input>'
        });
        
        resolve();
    });
}

export {init};