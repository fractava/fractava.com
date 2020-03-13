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
            <button id="acceptCookiesButton" class="cookieAlertButton">Ja</button>
            <button id="declineCookiesButton" class="cookieAlertButton">Nein</button>
        </div>
    </div>
    
    <div id="accountContainer">
        <div id="accountContainerNotLoggedIn">
            <span class="textWhite" id="accountLogin">Login</span>
            <span class="textWhite"> | </span>
            <span class="textWhite" id="accountRegister">Register</span>
        </div>
        <div id="accountContainerLoggedIn" style="display: none;">
            <span class="textWhite" id="accountUsername"></span>
            <span class="textWhite"> | </span>
            <span class="textWhite" id="accountLogout">Logout</span>
        </div>
    </div>
	
	<div id="app">
	    <transition name="fade">
            <router-view></router-view>
        </transition>
    </div>
    
    <section id="footerSection" style='background-color: black;'>
		<div>
			<span class="textWhite">Impressum: Bruno Trautsch - support@fractava.com - 93051 Regensburg Klenzestrasse 13</span>
		</div>
	</section>
</body>
