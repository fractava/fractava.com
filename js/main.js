import * as modules from "/js/modules/modules.js";

var sides = [];
var vueRoutes = [];
var router;
var vm;
var defaultSide = "/home";

getSites()
.then(assembleSideRoutes)
.then(initVueRouter)
.then(initNavigationGuard)
.then(initVue)
.then(function(){
    console.log(vueRoutes);
    modules.accountContainer.update();
});

function getSites() {
    return new Promise(function(resolve,reject){
        $.get({url: "/sites/sites.json", dataType: "json", success: function(data) {
            sides = data;
            resolve();
        }});
    });
}
function assembleSideRoutes() {
    return new Promise(function(resolve,reject){
        sides.forEach(function(sideName) {
            let route = {};
            
            route.path = "/" + sideName;
            
            let component = () => getComponent(sideName);
            route.component = component;
            
            vueRoutes.push(route);
        });
        
        let loginRoute = {};
        loginRoute.path = "/login";
        loginRoute["beforeEnter"] = function(to, from, next) {
            modules.dialogs.loginDialog();
            next(defaultSide);
        };
        vueRoutes.push(loginRoute);
        
        let registerRoute = {};
        registerRoute.path = "/register";
        registerRoute["beforeEnter"] = function(to, from, next) {
            modules.dialogs.registerDialog();
            next(defaultSide);
        };
        vueRoutes.push(registerRoute);
        
        let defaultRoute = {};
        defaultRoute.path = "*";
        defaultRoute.redirect = defaultSide;
        vueRoutes.push(defaultRoute);
        
        resolve();
    });
}
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
function initVueRouter(){
  return new Promise(function(resolve,reject){
    router = new VueRouter({
        routes: vueRoutes,
        mode: 'history',
        scrollBehavior (to, from, savedPosition) {
            return { x: 0, y: 0 }
        }
    });
    resolve();
  });
}
function getComponent(sideName) {
    return new Promise(function(resolve,reject){
        let template;
        let sideFile;
        let component;
        
        getTemplate()
        .then(getSideFile)
        .then(loadCSS)
        .then(assembleComponent)
        .then(function(){
            resolve(component);
        });
        
        function getTemplate() {
            return new Promise(function(resolve,reject){
                $.get({
                    "url": "/sites/" + sideName + ".html",
                    "dataType": "text",
                    "success": function(data) {
                        template = data;
                        resolve();
                    }
                });
            });
        }
        
        function getSideFile() {
            return new Promise(function(resolve,reject){
                let url = "/sites/" + sideName + ".js";
                import(url).then(function(data){
                    sideFile = data.site;
                    resolve();
                });
            });
        }
        
        function loadCSS(){
            return new Promise(function(resolve,reject){
                modules.stylesheetLoader.load("/sites/" + sideName + ".css");
                resolve();
            });
        }
        
        function assembleComponent() {
            return new Promise(function(resolve,reject){
                component = {
                    template: template,
                    props: {
                        storage: {
                            type: Object,
                            default: function () { return {} }
                        },
                        lang: {
                            type: Object,
                            default: function () { return sideFile.lang }
                        },
                        title: {
                            type: String,
                            default: sideFile.title
                        }
                    },
                    methods: sideFile.methods,
                    computed : sideFile.computed,
                    watch: sideFile.watch
                };
                
                resolve();
            });
        }
    });
}
function initNavigationGuard(){
    return new Promise(function(resolve,reject){
        router.afterEach((to, from) => {
            setTimeout(function() {
                console.log(to);
                modules.sectionNavigation.setUpNavPoints();
                modules.sectionNavigation.setupEventHandlers();
            }, 1000);
            document.title = to.matched[0].components.default.props.title.default + " - FRACTAVA";
	    });
        resolve();
    });
}
