export default {
    "home": {
        "vue": () => import("./home/home.vue"),
        "css": "home/home.css",
        "title": {
            "de-DE": "Start",
            "en-US": "Home"
        },
        "visibleInNavbar": true
    },
    "products": {
        "vue": () => import("./products/products.vue"),
        "css": "products/products.css",
        "title": {
            "de-DE": "Produkte",
            "en-US": "Products"
        },
        "visibleInNavbar": true
    },
    "policy": {
        "vue": () => import("./policy/policy.vue"),
        "css": "policy/policy.css",
        "title": {
            "de-DE": "Datenschutzerklärung",
            "en-US": "Privacy Policy"
        },
        "visibleInNavbar": false
    },
    "impressum": {
        "vue": () => import("./impressum/impressum.vue"),
        "css": "impressum/impressum.css",
        "title": {
            "de-DE": "Impressum",
            "en-US": "Legal Notice"
        },
        "visibleInNavbar": false
    },
    "settings": {
        "vue": () => import("./settings/settings.vue"),
        "css": "settings/settings.css",
        "title": {
            "de-DE": "Einstellungen",
            "en-US": "Settings"
        },
        "visibleInNavbar": false
    },
    "pixelArt": {
        "vue": () => import("./pixelArt/pixelArt.vue"),
        "css": "pixelArt/pixelArt.css",
        "title": {
            "en-US": "Pixel Art"
        },
        "visibleInNavbar": false
    }
}