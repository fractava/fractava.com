var pixel = [];

var rot = '#DB2828';
var haut = '#F2A464';
var grun = '#31E85D';
var blau  = '#2F64BC';
var cyan = '#13A4A7';
var lila = '#B306CE';
var magenta = '#DE1278';
var gelb = '#FAD517';
var schwarz = '#1F1F1F';
var weiss = '#F0F0F0';
var grau = '#A5A5A5';
var lime = '#B0F514';
var orange = '#FC7317';
var braun = '#5F3716';

var farben = [];

var n = 12;

var selected = 0;

var mouseReleasedM;
var mousePressedM;

var h = 0;

var m = 0;

var x = 0;
var y = 0;

function setup() {
  farben.push(rot); //1
  farben.push(grun);//2
  farben.push(blau);//3
  farben.push(gelb);//4
  farben.push(cyan);//5
  farben.push(orange);//6
  farben.push(haut);//7
  farben.push(braun);//8
  farben.push(weiss);//9
  farben.push(schwarz);//10
  farben.push(grau);//11
  farben.push(lila);//12

  createCanvas(windowWidth, windowHeight);
  h = windowHeight/n*0.8;
  background(70);

  for (var i = 0; i < 16; i++) {
    pixel[i] = [];
    for (var j = 0; j < 16; j++) {
      pixel[i][j] = 8;
    }
  }

  noStroke();
  rectMode(CENTER);


  for (var i = 0; i < n; i++) {
    farbpalette(farben[i], i);
  }
  m = windowWidth*0.016;
}

function draw() {
	print(mousePressedM);
  background(70);
  rectMode(CORNER);
  textSize(29);
  textAlign(CENTER, CENTER);
  fill(255);
  rect(windowWidth-200, windowHeight-80, 170, 50);
  fill(0);
  text("Übernehmen", windowWidth-200+85, windowHeight-80+25);
  if (mouseIsInside(windowWidth-200, windowHeight-80, 170, 50, CORNER, RELEASED)) {
	print(imageToText()); 
	var postData = {pixeldata: imageToText()}; 
    httpPost("https://fractava.com/avatar.php?type=pixelartonline","text",postData,function(result){
		print(result);
		if(result === "\nready"){
			print("leite weiter");
			sleep(500);
			window.open('https://fractava.com', '_self');
		}
		
	});
    
  }
  rectMode(CENTER);

  x = int((mouseX-(windowWidth/2-(m*7.5)-m/2))/(m));
  y = int((mouseY-(windowHeight/2-(m*7.5)-m/2))/(m));
  //text(x + " " + y, 50,150);
  if ((mouseIsPressed || mousePressedM) && x >= 0 && x < 16 && y >= 0 && y < 16) {
    pixel[x][y] = selected;
  }
  pixelGrid();

  for (var i = 0; i < n; i++) {
    farbpalette(farben[i], i);
  }
  mouseReleasedM = false;
}

function windowResized() {
  resizeCanvas(windowWidth, windowHeight);
  h = windowHeight/n*0.8;
  m = windowWidth*0.016;
}

function farbpalette(farbe, id) {
  fill(farbe);
  noStroke();
  rect(h*1.6, windowHeight/2-(h*(n-1)/2)+h*id, h, h);
}

function pixelGrid() {
  stroke(0);
  strokeWeight(1);
  for (var i = 0; i < 16; i++) {
    for (var j = 0; j < 16; j++) {
      fill(farben[pixel[i][j]]);
      rect(windowWidth/2-7.5*m+i*m, windowHeight/2-7.5*m+j*m, m, m);
    }
  }
}

function mouseReleased() {
  if (mouseX > h*1.1 && mouseX < h*2.1 && mouseY > windowHeight/2-(h*(n-1)/2)-h/2 && mouseY < windowHeight/2+(h*(n-1)/2)+h/2) {
    selected = int((mouseY-(windowHeight/2-(h*(n-1)/2)-h/2))/h);
  }

  //

  //}
  mouseReleasedM = true;
}

function touchStarted(){
	print("touch started");
	if(!mouseIsPressed){
	mousePressedM = true;
	}
}
function touchEnded(){
	print("touch ended");
	mousePressedM = false;
	mouseReleasedM = true;
}
//function anfrage_abschicken()
//{    
//  // Browserkompatibles Request-Objekt erzeugen:
//  r = null;

//  if (window.XMLHttpRequest)
//  {
//    r = new XMLHttpRequest();
//  } else if (window.ActiveXObject)
//  {
//    try
//    {
//      r = new ActiveXObject('Msxml2.XMLHTTP');
//    }
//    catch(e1)
//    {
//      try
//      {
//        r = new ActiveXObject('Microsoft.XMLHTTP');
//      }
//      catch(e2)
//      {
//        document.getElementById('status').innerHTML = 
//          "Request nicht möglich.";
//      }
//    }
//  }

//  // Wenn Request-Objekt vorhanden, dann Anfrage senden:
//  if (r != null)
//  {
//    var vorname = window.document.getElementById('vorname').value;
//    var nachname = window.document.getElementById('nachname').value;

//    // HTTP-POST
//    r.open('POST', 'http://localhost/js/verarbeitung.php', true);
//    r.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//    r.send('vor='+vorname+'&nach='+nachname);

//    window.document.getElementById('status').innerHTML = 'Request gesendet.';
//  }
//}


var ALWAYS   = 0;
var RELEASED = 1;
var PRESSED  = 2;

function mouseIsInside(x1, y1, x2, y2, mode, mode2) {  //Mode 2: 0 = always | 1= mouseReleased | 2 = mousePressed
  if (mode2 == ALWAYS | (mode2 == RELEASED && mouseReleasedM) | (mode2 == PRESSED && (mouseIsPressed | mousePressedM))) {
    if (mode == CENTER) {
      return(mouseX<x1+(x2/2) && mouseX>x1-(x2/2) && mouseY<y1+(y2/2) && mouseY>y1-(y2/2));
    } else if (mode == CORNER) {
      return (mouseX > x1 && mouseX < x1+x2 && mouseY > y1 && mouseY < y1+y2);
    } else if (mode = CORNERS) {
      var lowX = min(x1, x2);
      var lowY = min(y1, y2);
      var highX = max(x1, x2);
      var highY = max(y1, y2);

      return (mouseX > lowX && mouseX < highX && mouseY > lowY && mouseY < highY && (mouseIsPressed | mousePressedM));
    } else {
      //Unknown Mode
      return false;
    }
  } else {
    //unreachable
    return false;
  }
}
function imageToText(){
	var text = "";
	for(var y = 0;y <16;y++){
		for(var x = 0;x < 16;x++){
			text += pixel[x][y]+";";
		}
		text += "|";
	}
	return text;
}


function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
