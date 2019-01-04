var dev = false;

var player = new Trump();

var trump;
var wall;
var mexican;
var cook;
var turret;
var mine;
var Grenade;
var explosion;

var mexW = 10;
var mexH = 14;

var font;

var mouseReleased;

var aSkali;
var bSkaliX;
var bSkaliY;

var alive = true;
var won = false;
var gameFrameCount = 0;


var buildings = [];
var mexicans = [];

var dollars = 500;
var mines = 0;
var kills = 0;

var lastSpawn = 0;
var spawnWait = 120;

//ArrayList<PopUp> popUps;
var popUps = [];

function preload() {
trump = loadImage("Trump Pixel.png");
  wall = loadImage("Wall.png");
  mine = loadImage("Mine.png");
  mexican = loadImage("Mexican Pixel.png");
  cook = loadImage("Mexican Taco.png");
  turret = loadImage("Turret.png");
  Grenade = loadImage("Grenade.png");
  explosion = loadImage("Explosion.png");
  //effects = new var[2];
  var effects = [];
  effects[0] = loadImage("Building Hit.png");
  effects[1] = loadImage("Mexican Hit.png");
  //font = createFont("Air Americana.ttf", aSkali/4);
}

function setup() {
  createCanvas(1280, 720);
  rectMode(CENTER);
  noStroke();
  frameRate(30);
  //textFont(font);
  //fullScreen(P2D);
  autoScale();
  load();
  set();
  //usa.loop();
}

function draw() {

  background("#FFFFFF");
  if (alive == true && kills < 50 && won == false) {
    game();
    gui();
  } else if (alive == false) {
    crossed();
  } else if (kills >= 50) {
    won = true;
    reset();
  } else if (won == true) {
    win();
  }
  mouseReleased = false;
}

function game(){
  background("#EAE1B4");
  push();
  translate(width/2, height/2);
  scale(aSkali/64);
  player.show();
  for (var i = 0; i < buildings.length; i++) {
    buildings[i].show();
    buildings[i].funktion();
    buildings[i].update();
  }
  for (var i = 0; i < mexicans.length; i++) {
    mexicans[i].show();
    mexicans[i].check();
    mexicans[i].move();
    mexicans[i].update();
    //if (alive == false) {
      //break;
    //}
  }
  player.place();
  //console.log(frameCount-lastSpawn >= spawnWait);
  if (frameCount-lastSpawn >= spawnWait) {
	  
    if (gameFrameCount>600) {
		
      var w = int(random(0, 99));
      if (w > 89) {
        mexicans.push(new Cook(mexicans.length));
        console.log("Mexicaner gespawn");
      } else {
        mexicans.push(new Mexican(mexicans.length));
        console.log("Mexicaner gespawn");
      }
    } else {
      mexicans.push(new Mexican(mexicans.length));
      console.log("Mexicaner gespawn");
    }
    lastSpawn = frameCount;
    spawnWait=spawnWait*0.985;
    //println(spawnWait);
  }

  pop();
  gameFrameCount++;
}

function gui(){
  textAlign(LEFT, TOP);
  textSize(aSkali/8);
  fill("#00BC49");
  text(dollars+"$", aSkali/16, aSkali/16);
  rectMode(CORNER);
  fill("#FFFFFF");
  rect(aSkali/16, aSkali/4, aSkali/8, aSkali/2);
  rectMode(CENTER);
  textAlign(LEFT, CENTER);
  fill("#00BC49");
  textSize(aSkali/16);
  image(mine, aSkali/8, aSkali/4+aSkali/16, aSkali/8, aSkali/8);
  text("100$", aSkali/8+aSkali/16+aSkali/32, aSkali/4+aSkali/16);
  image(turret, aSkali/8, aSkali/4+aSkali/16+aSkali/8, aSkali/8, aSkali/8);
  text("150$", aSkali/8+aSkali/16+aSkali/32, aSkali/4+aSkali/16+aSkali/8);
  image(wall, aSkali/8, aSkali/2+aSkali/16, aSkali/8, aSkali/32);
  text("250$", aSkali/8+aSkali/16+aSkali/32, aSkali/2+aSkali/16);
  image(Grenade, aSkali/8, aSkali/2+aSkali/8+aSkali/16, aSkali/8, aSkali/8);
  text("150$", aSkali/8+aSkali/16+aSkali/32, aSkali/2+aSkali/8+aSkali/16);
  strokeWeight(aSkali/128);
  stroke("#00BC49");
  noFill();
  rect(aSkali/8, aSkali/4+aSkali/16+(aSkali/8*player.wich), aSkali/8, aSkali/8);
  if (mouseIsInsideCenter(aSkali/8, aSkali/2, aSkali/8, aSkali/2)) {
    player.placing=false;
    if (mouseReleased) {
      if (mouseY<aSkali/4+aSkali/8) {
        player.wich=0;
      } else if (mouseY<aSkali/2) {
        player.wich=1;
      } else if (mouseY<aSkali/2+aSkali/8) {
        player.wich=2;
      } else if (mouseY<aSkali/2+aSkali/4) {
        player.wich=3;
      }
      //println("HUIHU");
    }
  } else {
    player.placing=true;
  }
  noStroke();

  textAlign(CENTER, TOP);
  fill("#FF0000");
  textSize(aSkali/8);
  text(kills + "/50 kills", width/2, aSkali/16);

  if (dev) {
    textAlign(RIGHT, TOP);
    fill("#FFFFFF");
    text(int(frameRate)+" FPS", width-aSkali/16, aSkali/16);
  }

  for (var i = 0; i < popUps.length; i++) {
    popUps[i].show();
    popUps[i].update();
  }
}

function cross() {
  alive = false;
  reset();
}

function crossed() {
  background("#000000");
  textAlign(CENTER, CENTER);
  textSize(aSkali/8);
  fill("#DE1300");
  text("The mexicans crossed your border! Make america great again!", width/2, height/2);
  if (mouseReleased) {
    alive = true;
    spawnWait = 120;
    gameFrameCount=0;
  }
}

function win() {
  background("#A28B8B");
  textAlign(CENTER, CENTER);
  textSize(aSkali/8);
  fill("#FFE203");
  text("You made america great again! Go for your next period of office!", width/2, height/2);
  if (mouseReleased) {
    alive = true;
    won = false;
    spawnWait = 120;
    gameFrameCount=0;
  }
}

function reset() {
  mines = 0;
  buildings.clear();
  mexicans.clear();
  dollars = 500;
  kills = 0;
  popUps.clear();
}

function mouseReleased() {
  mouseReleased = true;
}

function autoScale() {
  if (width/16<=height/9) {
    bSkaliX = height/9*16;
    bSkaliY = height;
    aSkali = height/16*9;
  } else {
    bSkaliX = width;
    bSkaliY = width/16*9;
    aSkali = height/16*9;
  }
}

function PopUp(){
  var x;
  var y;
  var last;
  var id;
  
  var start;
  
  this.show = function(){
  };
  
  this.update = function(){
    if(frameCount - start >= last){
      popUps.remove(this.id);
      for(var i = 0; i < popUps.lenght; i++){
        popUps[i].id = i;
      }
    }
  };
}

function PopUpText(say, fill, x, y, last, id){
  this.base = PopUp;
  
  var say;
  var fill;
  
    this.say = say;
    this.fill = fill;
    this.x = x;
    this.y = y;
    this.last = last;
    this.id = id;
    this.start = frameCount;
  
  this.show = function(){
    fill(fill);
    textAlign(CENTER, CENTER);
    text(say,x,y);
  }
}

function PopUpImage(effect, x, y, last, id){
	this.base = PopUp;
  var effect;
    this.effect = effect;
    this.x = x;
    this.y = y;
    this.last = last;
    this.id = id;
    this.start = frameCount;
  
  function show(){
    image(effect, x, y, 16*aSkali/64, 16*aSkali/64);
    //println("I BIMUS!");
  }
}
 function Building(){
  var x;
  var y;
  var w;
  var h;

  var id;

  var way;


  var start = frameCount;

   function update(){
   }

   function show(){
   }

   function funktion(){
   }
}

function Mine (x, y, id){
	this.base = Building;
    this.x = x;
    this.y = y;
    this.w = 16;
    this.h = 16;
    this.id = id;
    this.way = 50;

  this.update = function() {
    if (this.way <= 0) {
      buildings.remove(this.id);
      for (var i = 0; i < buildings.length; i++) {
        buildings[i].id = i;
      }
      mines--;
    }
  }

  this.show = function() {
    image(mine, this.x, this.y);
  }

  this.funktion = function() {
    if (frameCount-this.start >= 45) {
      dollars = dollars+10;
      popUps.push(new PopUpText("+10$", "#FFE203", this.x*aSkali/64+width/2, this.y*aSkali/64+height/2, 10, popUps.length));
      this.start = frameCount;
    }
  }
}

function Wall (x, y, id){
	this.base = Building;
    this.x = x;
    this.y = y;
    this.w = 32;
    this.h = 8;
    this.id = id;
    this.way = 250;
    this.start = frameCount;

  this.update = function() {
    if (this.way <= 0) {
      buildings.remove(id);
      for (var i = 0; i < buildings.length; i++) {
        buildings[i].id = i;
      }
    }
  }

  this.show = function() {
    image(wall, x, y);
  }

  this.funktion = function() {
  }
}

function Turret (x, y, id){
	this.base = Bulding;
	var shots = [];
    this.x = x;
    this.y = y;
    this.w = 12;
    this.h = 2;
    this.id = id;
    this.way = 100;
    this.start = frameCount;

  this.update = function() {
    if (this.way <= 0) {
      buildings.remove(id);
      for (var i = 0; i < buildings.length; i++) {
        buildings[i].id = i;
      }
    }
  }

  this.show = function() {
    image(turret, this.x, this.y);
  }

  this.funktion = function() {
    if (frameCount-this.start >= 90) {
      shots.push(new Shot(this.x-1, this.y-8, shots.length));
      this.start = frameCount;
    }
    for (var i = 0; i < shots.length; i++) {
      shots[i].collide();
      shots[i].update();
      shots[i].show();
      if (shots[i].active == false) {
        shots.remove(i);
        for (var j = 0; j < shots.length; j++) {
          shots.get(j).id = j;
        }
      }
    }
  }
}

function Grenade (x, y, id){
  var explode = false;
    this.x = x;
    this.y = y;
    this.w = 8;
    this.h = 8;
    this.id = id;
    this.start = frameCount;

  this.update = function() {
    if (frameCount - this.start == 30) {
      this.explode = true;
    } else if (frameCount - this.start == 45) {
      buildings.remove(id);
      for (var i = 0; i < buildings.length; i++) {
        buildings[i].id = i;
      }
    }
  }

  this.show = function() {
    if (this.explode) {
      image(explosion, this.x, this.y);
    } else {
      image(Grenade, this.x, this.y);
    }
  }

  this.funktion  = function() {
    if(frameCount - this.start == 30){
      for(var i = 0; i < mexicans.length; i++){
        if(dist(mexicans[i].x, mexicans[i].y, this.x, this.y) < 24){
          mexicans[i].hp-=20;
          popUps.push(new PopUpImage(effects[1],mexicans[i].x*aSkali/64+width/2,int(mexicans[i].y*aSkali/64+height/2), 15, popUps.length));
        }
      }
    }
  }

}

function Shot (x, y, id){
  var x;
  var y;

  var id;

  var active = true;

    this.x = x;
    this.y = y;
    this.id = id;

  this.collide = function() {
    for (var i = 0; i < mexicans.length; i++) {
      if (rectRect(this.x, this.y, 2, 2, mexicans[i].x-1, mexicans[i].y, mexW, mexH)) {
        mexicans[i].hp-=5;
        popUps.push(new PopUpImage(effects[1],mexicans[i].x*aSkali/64+width/2,int(mexicans[i].y*aSkali/64+height/2), 6, popUps.length));
        active = false;
      }
    }
  }

  this.update = function() {
    y-=0.5;
    if (this.y <= -52) {
      active = false;
    }
  }

  this.show = function() {
    rectMode(CORNER);
    fill(50);
    rect(int(x), int(y), 2, 2);
    rectMode(CENTER);
  }
}
function rectRect(r1x, r1y, r1w, r1h, r2x, r2y, r2w, r2h) {

  // are the sides of one rectangle touching the other?

  if (r1x + r1w/2 >= r2x - r2w/2 &&    // r1 right edge past r2 left
    r1x - r1w/2 <= r2x + r2w/2 &&    // r1 left edge past r2 right
    r1y + r1h/2 >= r2y - r2h/2 &&    // r1 top edge past r2 bottom
    r1y - r1h/2 <= r2y + r2h/2) {    // r1 bottom edge past r2 top
    return true;
  }
  return false;
}

function mouseIsInsideCenter(x1, y1, breite, hoehe) {
  if (mouseX<x1+(breite/2) && mouseX>x1-(breite/2) && mouseY<y1+(hoehe/2) && mouseY>y1-(hoehe/2)) {

    return true;
  } else {
    return false;
  }
}
function Trump (){
  var x = 0;
  var wich = 0;

  var placing = true;

  this.show = function() {
    image(trump, x, 48);
  };

  this.control = function() {
  };

  this.place = function(){
    if (this.placing) {
      switch(wich) {
      case 0:
        fill(150, 135, 100, 100);
        strokeWeight(0.5);
        stroke(155, 135, 100);
        rect(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), 16, 16);
        noStroke();
        break;
      case 1:
        fill(100, 100, 100, 100);
        strokeWeight(0.5);
        stroke(100, 100, 100);
        rect(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), 16, 16);
        noStroke();
        break;
      case 2:
        fill(180, 18, 0, 100);
        strokeWeight(0.5);
        stroke(180, 18, 0);
        rect(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), 32, 8);
        noStroke();
        break;
      case 3:
        fill(230, 130, 50, 100);
        strokeWeight(0.5);
        stroke(230, 130, 50);
        ellipse(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), 24, 24);
        noStroke();
        break;
      }
      if (mouseReleased) {
        switch(wich) {
        case 0:
          if (dollars >= 100 && mines < 5) {
            buildings.push(new Mine(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), buildings.length));
            dollars = dollars-100;
            mines++;
          }
          break;
        case 1:
          if (dollars >= 150) {
            buildings.push(new Turret(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), buildings.length));
            dollars = dollars-150;
          }
          break;
        case 2:
          if (dollars >= 250) {
            buildings.push(new Wall(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), buildings.length));
            dollars = dollars-250;
          }
          break;
        case 3:
          if (dollars >= 150) {
            buildings.push(new Grenade(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), buildings.length));
            dollars = dollars-150;
          }
          break;
        }
      }
    }
  };
}

function Mexican (id){
  var id;
  var x = int(random(-96, 96));
  var y = "-48.0";
  var speed = "0.15";
  var hp = 20;
  var moving = true;

    this.id = id;
    //this.x = ;

  this.show = function() {
	  imageMode(CENTER);
    image(mexican, this.x, int(this.y),16,16);
    console.log("X:" + this.x);
  };

  this.check = function() {
    moving = true;
    for (var i = 0; i < buildings.length; i++) {
      if (rectRect(this.x, this.y+0.2, mexW, mexH, buildings[i].x, buildings[i].y, buildings[i].w, buildings[i].h)) {
        moving = false;
        if (frameCount%30==0) {
          if(buildings[i] instanceof Grenade == false){
          buildings[i].way-=10;
          popUps.push(new PopUpImage(effects[0],this.x*aSkali/64+width/2,int(buildings[i].y*aSkali/64+height/2), 10, popUps.length));
          }
        }
        break;
      }
    }
  };

  this.move = function() {
    if (this.moving) {
      this.y+=this.speed;
    }
  };

  this.update = function() {
    if (this.hp <= 0) {
      kills++;
      mexicans.remove(id);
      for (var i = 0; i < mexicans.length; i++) {
        mexicans[i].id = i;
      }
    }
    if (this.y > 48) {
      cross();
    }
  };
}

function Cook (id){
	this.base  = Mexican;
    this.id = id;
    this.x = int(random(-96, 96));
    this.speed = 0.25;
    this.hp = 45;

  this.show = function() {
    image(cook, this.x, int(this.y));
  };
}
function load() {
  //player = new Trump();
  //buildings = new ArrayList<Building>();
  //mexicans = new ArrayList<Mexican>();
  //popUps = new ArrayList<PopUp>();
}

