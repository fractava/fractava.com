<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112803937-1"></script>
    
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="shortcut icon" type="image/png" href="/assets/img/logo/logo_black.png"/>
	
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/fonts.css">
	<link rel="stylesheet" href="/css/cookieDialog.css">
	
	<script src='/js/libaries/vue.js'></script>
	<script src='/js/libaries/vue-router.js'></script>
	<script src='/js/libaries/jquery.min.js'></script>
	<script src='/js/libaries/mobile-detect.js'></script>
	<script src='/js/libaries/sweetalert2.js'></script>
    
	<script src='/js/main.js' type="module"></script>
	
	<title>FRACTAVA</title>
</head>
<body>
    <div id="cookieAlert">
        <p id="cookieAlertHeadline">Darf diese Website Cookies verwenden?</p>
        <div id="cookieAlertButtonConatainer">
            <button id="acceptCookiesButton" class="button whiteBackground blackBorder blackHoverBackground blackText whiteHoverText">Ja</button>
            <button id="declineCookiesButton" class="button whiteBackground blackBorder blackHoverBackground blackText whiteHoverText">Nein</button>
        </div>
    </div>
    
    <div id="accountContainer">
        <div id="accountContainerNotLoggedIn">
            <button class="button transparentBorder transparentBackground whiteHoverBorder whiteHoverBackground whiteText blackHoverText" id="accountRegister">Register</button>
            <button class="button whiteBorder transparentBackground whiteHoverBorder whiteHoverBackground whiteText blackHoverText" id="accountLogin">Login</button>
        </div>
        <div id="accountContainerLoggedIn" style="display: none;">
            <span class="textWhite" id="accountUsername"></span>
            <span class="textWhite"> | </span>
            <button id="accountLogout" class="button transparentBorder transparentBackground whiteHoverBorder whiteHoverBackground whiteText blackHoverText" id="accountRegister">Logout</button>
        </div>
    </div>
	
	<div id="app">
        <div id="navBarContainer">
            <router-link class="navBarItem" to="/home">Home</router-link>
            <router-link class="navBarItem" to="/products">Produkte</router-link>
        </div>
    
	    <!--<transition name="fade">-->
            <router-view></router-view>
        <!--</transition>-->
        
        <section id="footerSection" style='background-color: black;'>
            <router-link to="/policy">Datenschutzerklärung</router-link>
            <router-link to="/impressum">Impressum</router-link>
	    </section>
    </div>
</body>
