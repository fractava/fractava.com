import * as modules from "/js/modules/modules.js";

var sites = [];
var navBarLinks = [];
var vueRoutes = [];
var router;
var defaultSite = "/home";

function getSites() {
    return new Promise(function(resolve,reject){
        $.get({url: "/sites/sites.json", dataType: "json", success: function(data) {
            sites = data;
            resolve();
        }});
    });
}
function getComponent(site, title) {
    return new Promise(function(resolve,reject){
        let template;
        let siteFile;
        let component;
        
        getTemplate()
        .then(getSiteFile)
        .then(loadCSS)
        .then(assembleComponent)
        .then(function(){
            resolve(component);
        });
        
        function getTemplate() {
            return new Promise(function(resolve,reject){
                $.get({
                    "url": "/sites/" + site["template"],
                    "dataType": "text",
                    "success": function(data) {
                        template = data;
                        resolve();
                    }
                });
            });
        }
        
        function getSiteFile() {
            return new Promise(function(resolve,reject){
                let url = "/sites/" + site["js"];
                import(url).then(function(data) {
                    siteFile = data.site;
                    resolve();
                });
            });
        }
        
        function loadCSS(){
            return new Promise(function(resolve,reject){
                modules.resourceLoader.loadCSS("/sites/" + site["css"]);
                resolve();
            });
        }
        
        function assembleComponent() {
            return new Promise(function(resolve,reject){
                let props = {
                    lang: {
                        type: Object,
                        default: function () { return modules.language.loadModuleLanguage(siteFile.lang) }
                    }
                };
                
                let data = {};
                
                if(siteFile.data) {
                    data = Object.assign(data, siteFile.data);
                }
                
                Object.assign(data, {"title": title});
                Object.assign(data, {"modules": modules});
                
                component = {
                    template: template,
                    props: props,
                    data: function() {return data},
                    methods: siteFile.methods,
                    computed : siteFile.computed,
                    watch: siteFile.watch,
                    mounted: siteFile.init,
                    components: siteFile.components
                };
                
                resolve();
            });
        }
    });
}
function assembleSiteRoutes() {
    return new Promise(function(resolve,reject){
        Object.keys(sites).forEach(function (sitePath) {
            let site = sites[sitePath];
            let route = {};
            
            let title;
            
            if(site.visibleInNavbar) {
                if(site.title[navigator.language]) {
                    title = site.title[navigator.language];
                }else {
                    title = site.title["en-US"];
                }
                navBarLinks.push({"title": title, "path": "/" + sitePath});
            }
            
            route.path = "/" + sitePath;
            
            let component = () => getComponent(site, site.title);
            route.component = component;
            
            vueRoutes.push(route);
        });
        
        resolve();
    });
}
function assembleSpecialSiteRoutes() {
    return new Promise(function(resolve,reject){
        let loginRoute = {};
        loginRoute.path = "/login";
        loginRoute["beforeEnter"] = function(to, from, next) {
            modules.dialogs.loginDialog();
            next(defaultSite);
        };
        vueRoutes.push(loginRoute);
        
        let registerRoute = {};
        registerRoute.path = "/register";
        registerRoute["beforeEnter"] = function(to, from, next) {
            modules.dialogs.registerDialog();
            next(defaultSite);
        };
        vueRoutes.push(registerRoute);
        
        let logoutRoute = {};
        logoutRoute.path = "/logout";
        logoutRoute["beforeEnter"] = function(to, from, next) {
            modules.account.logout();
            next(defaultSite);
        };
        vueRoutes.push(logoutRoute);
        
        let defaultRoute = {};
        defaultRoute.path = "*";
        defaultRoute.redirect = defaultSite;
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
            
            let siteTitleArray = to.matched[0].components.default.data().title;
            if(siteTitleArray[navigator.language]) {
                document.title = siteTitleArray[navigator.language] + " - FRACTAVA";
            }else {
                document.title = siteTitleArray["en-US"] + " - FRACTAVA";
            }
            $("html").removeClass("loading");
	    });
        resolve();
    });
}
function getRouter(modules) {
    return new Promise(function(resolve,reject){
        getSites()
        .then(assembleSiteRoutes)
        .then(assembleSpecialSiteRoutes)
        .then(initVueRouter)
        .then(initNavigationGuard)
        .then(function() {
            resolve(router);
        });
    });
}

export{getRouter, navBarLinks};