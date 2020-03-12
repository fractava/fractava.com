$(document).ready(function() {
    sides = [];
    vueRoutes = [];
    
    var router;
    
    defaultSide = "/index";
    
    getSides()
    .then(assembleSideRoutes)
    .then(initVueRouter)
    .then(initNavigationGuard)
    .then(initVue)
    .then(function(){
        console.log(vueRoutes);
    });
});
function getSides() {
    return new Promise(function(resolve,reject){
        $.get({url: "/sides/sides.json", dataType: "json", success: function(data) {
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
        
        let route = {};
        route["path"] = "*";
        route["redirect"] = defaultSide;
        vueRoutes.push(route);
        
        resolve();
    });
}
function initVue() {
    return new Promise(function(resolve,reject){
        vm = new Vue({
            router,
            data : () => ({
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
                template = $.get({
                    "url": "/sides/" + sideName + ".html",
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
                let url = "/sides/" + sideName + ".js";
                import(url).then(function(data){
                    sideFile = data.side;
                    resolve();
                });
            });
        }
        
        function loadCSS(){
            return new Promise(function(resolve,reject){
                loadStylesheet("/sides/" + sideName + ".css");
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
                setUpNavPoints();
            }, 1000);
	    });
        resolve();
    });
}
function loadStylesheet(path) {
    let link = document.createElement('LINK');
    link.rel = "stylesheet";
    link.href = path;
    
    $("head").append(link);
}
function runGoogleAnalytics() {
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-112803937-1');
}