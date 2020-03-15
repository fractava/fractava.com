import * as network from "/js/modules/network.js";
import * as lang from "/js/modules/language.js";
import * as account from "/js/modules/account.js";

function loginDialog(){
    htmlDialog({
        title: "Login",
        html:
            "<input autocomplete='on' type='email' id='loginEmail' placeholder='Email' class='inputWhite'></input>" +
            "<input autocomplete='on' type='password' id='loginPassword' placeholder='Passwort' class='inputWhite'></input>",
        preConfirm: () => {
            return {
              "email": document.getElementById('loginEmail').value,
              "password": document.getElementById('loginPassword').value
            }
        }
    }).then(function(result) {
        if(!result.dismiss){
            console.log(result);
            network.actionRequest({"action": "login", "email": result.value.email, "password": result.value.password}, true, true)
            .then(function() {
                account.checkLoggedIn();
            });
        }
    });
}
function registerDialog(){
    htmlDialog({
        title: "Registrieren",
        html:
            "<p id='registerError'></p>" +
            "<input autocomplete='on' type='text' id='registerFirstName' placeholder='Vorname' class='inputWhite'></input>" +
            "<input autocomplete='on' type='text' id='registerLastName' placeholder='Nachnahme' class='inputWhite'></input>" +
            "<input autocomplete='on' type='text' id='registerUsername' placeholder='Username' class='inputWhite'></input>" +
            "<input autocomplete='on' type='email' id='registerEmail' placeholder='Email' class='inputWhite'></input>" +
            "<input autocomplete='on' type='password' id='registerPassword' placeholder='Passwort' class='inputWhite'></input>" +
            "<input autocomplete='on' type='password' id='registerPassword2' placeholder='Passwort wiederholen' class='inputWhite'></input>",

        preConfirm: () => {
            let firstName = document.getElementById('registerFirstName').value;
            let lastName = document.getElementById('registerLastName').value;
            let username = document.getElementById('registerUsername').value;
            let email = document.getElementById('registerEmail').value;
            let password = document.getElementById('registerPassword').value;
            let password2 = document.getElementById('registerPassword2').value;
            
            if(!firstName || !lastName || !username || !email || !password || !password2){
                $("#registerError").text("Fehlende Angabe(n)");
                return false;
            }
            
            if(password != password2) {
                $("#registerError").text("Die Passwörter stimmen nicht überein");
                return false;
            }
            
            return network.actionRequest({action: "register",firstName: firstName, lastName: lastName, username: username, email: email, password: password}, true, false)
            .then(function(){
                return {
                    firstName,
                    lastName,
                    username,
                    email,
                    password
                }
            })
            .catch(function(errors) {
                $("#registerError").text(lang.get(errors[0].errorLangName));
                return false;
            })
        }
    }).then(function(result) {
        if(!result.dismiss){
            console.log(result);
            
        }
    });
}
function htmlDialog(parameters) {
    return new Promise(function(resolve, reject) {
        Swal.fire({
            "background": "white",
            "customClass": {
              container: 'swal-container',
              popup: 'swal-popup',
              header: 'swal-header',
              title: 'swal-title',
              closeButton: 'swal-close-button',
              icon: 'swal-icon',
              image: 'swal-image',
              content: 'swal-content',
              input: 'inputWhite',
              actions: 'swal-actions',
              confirmButton: 'button blackBorder whiteBackground blackHoverBackground blackText whiteHoverText',
              cancelButton: 'button blackBorder whiteBackground blackHoverBackground blackText whiteHoverText',
              footer: 'swal-footer'
            },
            buttonsStyling: false,
            showCloseButton: true,
            title: parameters.title,
            html: parameters.html,
            preConfirm: parameters.preConfirm
        }).then(function(result) {
            resolve(result);
        });
    });
}
function errorDialog(error_text, reset_time){
	console.warn(error_text);
	Swal.fire({
		confirmButtonClass: 'button',
		title : 'Error',
		text : error_text,
		type : 'error',
		buttonsStyling: false,
		timer: reset_time
	});
}

export{htmlDialog, loginDialog, registerDialog, errorDialog};