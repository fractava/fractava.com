import * as modules from "/js/modules/modules.js";

var router;
var vm;

initModules()
.then(modules.vueRouter.getRouter)
.then(function(getRouter) {
    router = getRouter;
    initVue();
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
        for(let module in modules){
            if(modules[module]["init"]) {
                modules[module].init();
            }
        }
        resolve();
    });
}

