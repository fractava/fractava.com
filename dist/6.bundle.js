(window.webpackJsonp=window.webpackJsonp||[]).push([[6],{22:function(n,a,t){(a=t(0)(!1)).push([n.i,"/* Disable Mobile Stuff*/\nhtml.no-mobile #mobileSidenav {\n    display: none;\n}\nhtml.no-mobile #openMobileSidenavDiv {\n    display: none;\n}\n\n/* Nav Points */\n#navPointContainer {\n    position: fixed;\n    width: auto;\n    font-size: 60px;\n    top: 50%;\n    transform: translateY(-50%);\n}\n.navPoint {\n    margin-top: 10px;\n    margin-bottom: 10px;\n    margin-left: 4px;\n    font-size: 70px;\n    font-family: nextfont;\n    transition: all .1s ease-in-out;\n}\n.navPoint:hover {\n    transform: scale(1.2);\n}\n\n/* Account Container*/\n#accountContainer {\n    position: absolute;\n    top: 10px;\n    right: 10px;\n    font-family: timeburner;\n}\n\n/*  Avatar */\n#avatar {\n    display: flex;\n    flex-flow: column;\n    align-items: flex-end;\n}\n#avatarImg {\n    width: 5vw;\n    border-radius: .3125em;\n}\n#avatarImg.pixelArt {\n    image-rendering: pixelated;\n}\n#avatarDropdown {\n  /*display: none;*/\n  display: flex;\n  background-color: white;\n  min-width: 160px;\n  padding: 12px 16px;\n  z-index: 1;\n  flex-flow: column;\n  flex-wrap: wrap;\n  border-radius: .3125em 0px .3125em .3125em;\n  transition: all .1s ease-in-out;\n  opacity: 0;\n}\n#avatar.active #avatarDropdown {\n  opacity: 1;\n}\n#avatarDropdown span, #avatarDropdown button {\n    padding: 12px 16px;\n    margin-bottom: 3px;\n}\n#avatarDropdown button, #avatarDropdown a {\n    width: 100%;\n}\n#avatar.active #avatarImg{\n    border-radius: .3125em .3125em 0px 0px;\n}\n\n/* Navbar */\n#navBarContainer {\n    position: absolute;\n    top: 10px;\n    left: 5%;\n    padding-top: 13px;\n}\n#navBarContainer .navBarItem {\n    color: white;\n    font-family: timeburner;\n    margin-bottom: 3px solid transparent;\n    padding-left: 10px;\n    padding-right: 10px;\n    padding-bottom: 3px;\n    line-height: 1.3333333;\n    font-size: 18px;\n    text-decoration: none;\n}\n#navBarContainer .navBarItem:hover, #navBarContainer .navBarItem.router-link-active{\n    border-bottom: 3px solid white;\n}",""]),n.exports=a},24:function(n,a,t){var o=t(22);"string"==typeof o&&(o=[[n.i,o,""]]),o.locals&&(n.exports=o.locals);(0,t(1).default)("53b20776",o,!1,{})}}]);