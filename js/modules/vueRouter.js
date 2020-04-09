import * as modules from "./modules.js";
import * as sites from './../../sites/sites.js';

var navBarLinks = [];
var vueRoutes = [];
var router;
var defaultSite = "/home";

function getComponent(site) {
    return new Promise(function(resolve,reject){
        let component;
        
        createComponent()
        .then(loadCSS)
        .then(modifyComponent)
        .then(function(){
            resolve(component);
        });
        
        function createComponent() {
            return new Promise(function(resolve,reject){
                site.vue().then(function(data) {
                    component = data.default;
                    
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
        
        function modifyComponent() {
            return new Promise(function(resolve,reject){
                if(!component.props) {
                    component.props = {};
                }
                
                
                let lang = modules.language.loadModuleLanguage(component.lang);

                component.props.lang = {
                    type: Object,
                    default: function () { return lang}
                }

                if(!component.data) {
                    component.data = {};
                }
                
                component.data["modules"] = modules;
                
                console.log(component);
                
                resolve();
            });
        }
    });
}
function assembleSiteRoutes() {
    return new Promise(function(resolve,reject){
        Object.keys(sites.default).forEach(function (sitePath) {
            let site = sites.default[sitePath];
            
            let route = {};
            
            let title;
            if(site.title[navigator.language]) {
                title = site.title[navigator.language];
            }else {
                title = site.title["en-US"];
            }
                
            if(site.visibleInNavbar) {
                navBarLinks.push({"title": title, "path": "/" + sitePath});
            }
            
            route.path = "/" + sitePath;
            
            let component = () => getComponent(site);
            route.component = component;
            route.meta = {"title": title};
            
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
      console.log(vueRoutes);
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
            console.log(to);
            
            setTimeout(function() {
                modules.sectionNavigation.setUpNavPoints();
                modules.sectionNavigation.setupEventHandlers();
            }, 1000);  
            
            document.title = to.meta.title + " - FRACTAVA";
            
            $("html").removeClass("loading");
	    });
        resolve();
    });
}
function getRouter(modules) {
    return new Promise(function(resolve,reject){
        assembleSiteRoutes()
        .then(assembleSpecialSiteRoutes)
        .then(initVueRouter)
        .then(initNavigationGuard)
        .then(function() {
            resolve(router);
        });
    });
}

export{getRouter, navBarLinks};