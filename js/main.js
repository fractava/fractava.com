import * as modules from "/js/modules/modules.js";

var router;
var vm;

$(document).ready(function(){
    initModules()
    .then(modules.vueRouter.getRouter)
    .then(function(getRouter) {
        router = getRouter;
        initVue();
    });
});

function initVue() {
    return new Promise(function(resolve,reject){
        vm = new Vue({
            router,
            data : () => ({
                modules
            }),
            watch : {
            },
            methods : {
            }
        }).$mount("#app");
        resolve();
  });
}

function initModules() {
    return new Promise(function(resolve,reject){
        let moduleNames = [];
        for(let module in modules){
            moduleNames.push(module);
        }
        
        function initModule(name){
            if(modules[name]["init"]) {
                return modules[name].init();
            }else {
                return Promise.resolve();
            }
        }
        
        function initModulesRecursive(i) {
            initModule(moduleNames[i])
            .then(function() {
                if(moduleNames[i+1]){
                    initModulesRecursive(i+1);
                }else {
                    resolve();
                }
            })
        }
        
        initModulesRecursive(0);
    });
}

