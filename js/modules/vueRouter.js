import * as modules from "/js/modules/modules.js";

var sides = [];
var vueRoutes = [];
var router;
var defaultSide = "/home";

function getSites() {
    return new Promise(function(resolve,reject){
        $.get({url: "/sites/sites.json", dataType: "json", success: function(data) {
            sides = data;
            resolve();
        }});
    });
}
function getComponent(side) {
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
                    "url": "/sites/" + side["template"],
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
                let url = "/sites/" + side["js"];
                import(url).then(function(data){
                    sideFile = data.site;
                    resolve();
                });
            });
        }
        
        function loadCSS(){
            return new Promise(function(resolve,reject){
                modules.stylesheetLoader.load("/sites/" + side["css"]);
                resolve();
            });
        }
        
        function assembleComponent() {
            return new Promise(function(resolve,reject){
                let props = {
                    lang: {
                        type: Object,
                        default: function () { return modules.language.loadModuleLanguage(sideFile.lang) }
                    },
                    title: {
                        type: String,
                        default: sideFile.title
                    }
                };
                
                let data;
                
                if(sideFile.data) {
                    data = function() {return sideFile.data };
                }else {
                    data = undefined;
                }
                
                component = {
                    template: template,
                    props: props,
                    data: data,
                    methods: sideFile.methods,
                    computed : sideFile.computed,
                    watch: sideFile.watch,
                    components: sideFile.components
                };
                
                resolve();
            });
        }
    });
}
function assembleSideRoutes() {
    return new Promise(function(resolve,reject){
        Object.keys(sides).forEach(function (sidePath) {
            let side = sides[sidePath];
            let route = {};
            
            route.path = "/" + sidePath;
            
            let component = () => getComponent(side);
            route.component = component;
            
            vueRoutes.push(route);
        });
        
        resolve();
    });
}
function assembleSpecialSideRoutes() {
    return new Promise(function(resolve,reject){
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
        
        let logoutRoute = {};
        logoutRoute.path = "/logout";
        logoutRoute["beforeEnter"] = function(to, from, next) {
            modules.account.logout();
            next(defaultSide);
        };
        vueRoutes.push(logoutRoute);
        
        let defaultRoute = {};
        defaultRoute.path = "*";
        defaultRoute.redirect = defaultSide;
        vueRoutes.push(defaultRoute);
        
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

function initNavigationGuard(){
    return new Promise(function(resolve,reject){
        router.beforeEach((to, from, next) => {
            $("html").addClass("loading");
            next();
        });
        router.afterEach((to, from) => {
            setTimeout(function() {
                console.log(to);
                modules.sectionNavigation.setUpNavPoints();
                modules.sectionNavigation.setupEventHandlers();
            }, 1000);
            document.title = to.matched[0].components.default.props.title.default + " - FRACTAVA";
            $("html").removeClass("loading");
	    });
        resolve();
    });
}
function getRouter(modules) {
    return new Promise(function(resolve,reject){
        getSites()
        .then(assembleSideRoutes)
        .then(assembleSpecialSideRoutes)
        .then(initVueRouter)
        .then(initNavigationGuard)
        .then(function() {
            resolve(router);
        });
    });
}

export{getRouter};