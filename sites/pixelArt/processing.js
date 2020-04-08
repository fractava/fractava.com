var pixel = [];
var colors = [];

var selectedColor = 0;

var mouseReleasedM;
var mousePressedM;

function setup() {
	var canvas = createCanvas(windowWidth, windowHeight);
	canvas.parent("#pixelArtContainer");
	
	getColors();
    initPixels();
}

function draw() {
    drawUI();
}

function getColors() {
    $.get("/getData.php?getData=avatar:colors")
    .then(function(data) {
        children = $(data).find("results")[0].children;
        
        for(colorName in children) {
            if(children[colorName].innerHTML) {
                colors.push(children[colorName].innerHTML);
            }
        }
        
        console.log(colors);
    });
}
function initPixels() {
    for (var i = 0; i < 16; i++) {
		pixel[i] = [];
		for (var j = 0; j < 16; j++) {
			pixel[i][j] = 8;
		}
	}
}

function imageToText() {
	var text = "";
	for (var y = 0; y < 16; y++) {
		for (var x = 0; x < 16; x++) {
			text += pixel[x][y] + ";";
		}
		text += "|";
	}
	return text;
}

// UI
function drawUI() {
    background(0);
	drawPixelGrid();
	drawColorSelectors();
	drawSubmitButton();
}
function drawColorSelectors() {
}
function drawSubmitButton() {
	rectMode(CORNER);
	textSize(29);
	textAlign(CENTER, CENTER);
	fill(255);
	rect(windowWidth - 200, windowHeight - 80, 170, 50);
	fill(0);
	text("Übernehmen", windowWidth - 200 + 85, windowHeight - 80 + 25);
	
	if (mouseIsInside(windowWidth - 200, windowHeight - 80, 170, 50, CORNER, RELEASED)) {
		print(imageToText());
		var postData = {
			pixeldata: imageToText()
		};
		$.post("https://fractava.com/getData.php?getData=avatar:change", "xml", postData, function(result) {
			print(result);
		});

	}
}
function drawPixelGrid() {
	stroke(0);
	strokeWeight(1);
	for (var i = 0; i < 16; i++) {
		for (var j = 0; j < 16; j++) {
		}
	}
}

function windowResized() {
	resizeCanvas(windowWidth, windowHeight);
}
// Mouse/Touch
function mouseReleased() {
	mouseReleasedM = true;
}

function touchStarted() {
	print("touch started");
	if (!mouseIsPressed) {
		mousePressedM = true;
	}
}

function touchEnded() {
	print("touch ended");
	mousePressedM = false;
	mouseReleasedM = true;
}

var ALWAYS = 0;
var RELEASED = 1;
var PRESSED = 2;
function mouseIsInside(x1, y1, x2, y2, mode, mode2) { //Mode 2: 0 = always | 1= mouseReleased | 2 = mousePressed
	if (mode2 == ALWAYS | (mode2 == RELEASED && mouseReleasedM) | (mode2 == PRESSED && (mouseIsPressed | mousePressedM))) {
		if (mode == CENTER) {
			return (mouseX < x1 + (x2 / 2) && mouseX > x1 - (x2 / 2) && mouseY < y1 + (y2 / 2) && mouseY > y1 - (y2 / 2));
		} else if (mode == CORNER) {
			return (mouseX > x1 && mouseX < x1 + x2 && mouseY > y1 && mouseY < y1 + y2);
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
		//Unreachable
		return false;
	}
}