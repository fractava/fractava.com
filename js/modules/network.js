import * as lang from "/js/modules/language.js";

function getRequest(url,parameters,type,callbackSucess,callbackFail){
	let jqxhr = $.get(url, parameters, function(data,textStatus,jqXHR){
	    callbackSucess(data,textStatus);
	});
	jqxhr.fail(function(jqXHR, exception){callbackFail(jqXHR, exception);});
}
function postRequest(url,parameters,type,callbackSucess,callbackFail){
	let jqxhr = $.post(url, parameters, function(data,textStatus,jqXHR){
	    callbackSucess(data,textStatus,jqXHR);
	});
	jqxhr.fail(function(jqXHR, exception){callbackFail(jqXHR, exception);});
}
function getDataRequest(parameters,retry,showError,maxRetries){
	return new Promise(function(resolve, reject) {

		if(!maxRetries){
			maxRetries = 5;
		}
		let retries = 0;
		let retryWait = 3000;
		execute();

		function request(parameters){
			let jqxhr = $.get("/getData.php", parameters, function(data,textStatus,jqXHR){
				let requestReturn;
			try{
				xml = $(data);
				if(xml.length > 0){
					requestReturn = xml;
				}else{
					requestReturn = data;
				}
			}catch(e){
				requestReturn = data;
			}
			resolve(requestReturn);
				//sucess(data,textStatus,xml);
			});
			jqxhr.fail(function(jqXHR,exception){
				fail(jqXHR, exception);
			});
		}
		function execute(){
			request(parameters);
		}
		function sucess(data,status,xml){
			resolve();
		}
		function fail(jqXHR, exception){
			if(jqXHR.status == 400){
				let xml = $(jqXHR.responseText);
				let errors = xml.find("error");
				
				errorText = "";
				if(showError){
					for(let i = 0; i< errors.length; i++){
						newError = (lang.get("error"+errors[i].getAttribute("id"))+"\n");
						console.log(errors[i].getAttribute("extraDetail"));
						if(errors[i].getAttribute("extraDetail")){
							newError = newError.replace("[extraInfo]",errors[i].getAttribute("extraDetail"));
						}
						errorText += newError;
					}
					errorDialog(errorText);
				}
				let rejectArray = [];
				for(let i = 0; i< errors.length; i++){
					rejectArray.push({"errorLangName": "error"+errors[i].getAttribute("id"),"extraDetail": errors[i].getAttribute("extraDetail"),"type" : "internal", "error": errors[i].getAttribute("id")});
				}
				reject(rejectArray);
			}else{
				if(retry && retries < maxRetries){
					retries++;
					setTimeout(function(){execute()},retryWait);
				}else{
					if(showError){
						errorDialog(lang.get("httpError"+jqXHR.status));
					}
					reject([{"errorLangName": "httpError"+jqXHR.status, "type": "http", "error": jqXHR.status}]);
				}
			}
		}
	});
}

function actionRequest(parameters,retry,showError,maxRetries){
	return new Promise(function(resolve, reject) {

		if(!maxRetries){
			maxRetries = 5;
		}
		let retries = 0;
		let retryWait = 3000;
		
		let xml;
		
		execute();

		function request(parameters){
			let jqxhr = $.post("/action.php", parameters, function(data,textStatus,jqXHR){
				if(xml = $(data)){
					resolve(xml);
				}else{
					resolve(data);
				}
				//sucess(data,textStatus,xml);
			});
			jqxhr.fail(function(jqXHR,exception){
				fail(jqXHR, exception);
			});
		}
		function execute(){
			request(parameters);
		}
		function sucess(data,status,xml){
			resolve();
		}
		function fail(jqXHR, exception){
			if(jqXHR.status == 400){
				xml = $(jqXHR.responseText);
				let errors = xml.find("error");
				console.log(errors);
				
				errorText = "";
				if(showError){
					for(let i = 0; i< errors.length; i++){
						newError = (lang.get("error"+errors[i].getAttribute("id"))+"\n");
						console.log(errors[i].getAttribute("extraDetail"));
						if(errors[i].getAttribute("extraDetail")){
							newError = newError.replace("[extraInfo]",errors[i].getAttribute("extraDetail"));
						}
						errorText += newError;
					}
					errorDialog(errorText);
				}
				let rejectArray = [];
				for(let i = 0; i< errors.length; i++){
					rejectArray.push({"errorLangName": "error"+errors[i].getAttribute("id"),"extraDetail": errors[i].getAttribute("extraDetail"),"type" : "internal", "error": errors[i].getAttribute("id")});
				}
				reject(rejectArray);
			}else{
				if(retry && retries < maxRetries){
					retries++;
					setTimeout(function(){execute()},retryWait);
				}else{
					if(showError){
						errorDialog(lang.get("httpError"+jqXHR.status));
					}
					reject([{"errorLangName": "httpError"+jqXHR.status, "type": "http", "error": jqXHR.status}]);
				}
			}
		}
	});
}

export{getRequest, postRequest, getDataRequest, actionRequest};