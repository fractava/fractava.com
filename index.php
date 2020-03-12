<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112803937-1"></script>
    
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<link rel="shortcut icon" type="image/png" href="/assets/img/logo/logo_black.png"/>
	
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/fonts.css">
	<link rel="stylesheet" href="/css/cookieAlert.css">
	
	<script src='/js/libaries/vue.js'></script>
	<script src='/js/libaries/vue-router.js'></script>
	<script src='/js/libaries/jquery.min.js'></script>
	<script src='/js/libaries/mobile-detect.js'></script>
	
	<script src='/js/sectionNavigation.js'></script>
	<script src='/js/main.js'></script>
	<script src='/js/network.js'></script>
	<script src='/js/functions.js'></script>
	<script src='/js/cookieAlert.js'></script>
	<script src='/js/mobileDetect.js'></script>
	
	<title>FRACTAVA</title>
</head>
<body>
    <div id="cookieAlert">
        <p id="cookieAlertHeadline">Darf diese Website Cookies verwenden?</p>
        <div id="cookieAlertButtonConatainer">
            <button class="cookieAlertButton" onclick="acceptCookies()">Ja</button>
            <button class="cookieAlertButton" onclick="declineCookies()">Nein</button>
        </div>
    </div>
	
	<div id="app">
	    <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>
</body>
