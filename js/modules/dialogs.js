import * as network from "/js/modules/network.js";

function loginDialog(){
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
          confirmButton: 'buttonBlack',
          cancelButton: 'buttonBlack',
          footer: 'swal-footer'
        },
        "buttonsStyling": false,
        "showCloseButton": true,
        "title": "Login",
        "html":
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
            network.actionRequest({"action": "login", "email": result.value.email, "password": result.value.password}, true, true);
        }
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

export{loginDialog, errorDialog};