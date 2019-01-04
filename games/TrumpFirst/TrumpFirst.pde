boolean dev = false;

PImage trumpImage;
PImage wall;
PImage mexican;
PImage cook;
PImage turret;
PImage mine;
PImage Grenade;
PImage explosion;

PImage[] effects;

int mexW = 10;
int mexH = 14;

boolean mouseReleased;

float aSkali;
float bSkaliX;
float bSkaliY;

boolean alive = true;
boolean won = false;
int gameFrameCount = 0;

Trump player;
ArrayList<Building> buildings;
ArrayList<Mexican> mexicans;

int dollars = 500;
int mines = 0;
int kills = 0;

int lastSpawn = 0;
float spawnWait = 120;

ArrayList<PopUp> popUps;

void setup() {
  size(1280, 720);
  player = new Trump();
  //fullScreen(P2D);
  autoScale();
  load();
  set();
  //usa.loop();
}

void draw() {
if(mousePressed){
mouseReleased = true;
}
  background(#FFFFFF);
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

void game() {
  background(#EAE1B4);
  pushMatrix();
  translate(width/2, height/2);
  scale(aSkali/64);
  player.show();
  for (int i = 0; i < buildings.size(); i++) {
    buildings.get(i).show();
    buildings.get(i).function();
    buildings.get(i).update();
  }
  for (int i = 0; i < mexicans.size(); i++) {
    mexicans.get(i).show();
    mexicans.get(i).check();
    mexicans.get(i).move();
    mexicans.get(i).update();
    if (alive == false) {
      break;
    }
  }
  player.place();
  if (frameCount-lastSpawn >= spawnWait) {
    if (gameFrameCount>600) {
      int w = int(random(0, 99));
      if (w > 89) {
        mexicans.add(new Cook(mexicans.size()));
      } else {
        mexicans.add(new Mexican(mexicans.size()));
      }
    } else {
      mexicans.add(new Mexican(mexicans.size()));
    }
    lastSpawn = frameCount;
    spawnWait=spawnWait*0.985;
    println(spawnWait);
  }

  popMatrix();
  gameFrameCount++;
}

void gui() {
  textAlign(LEFT, TOP);
  textSize(aSkali/8);
  fill(#00BC49);
  text(dollars+"$", aSkali/16, aSkali/16);
  rectMode(CORNER);
  fill(#FFFFFF);
  rect(aSkali/16, aSkali/4, aSkali/8, aSkali/2);
  rectMode(CENTER);
  textAlign(LEFT, CENTER);
  fill(#00BC49);
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
  stroke(#00BC49);
  noFill();
  rect(aSkali/8, aSkali/4+aSkali/16+(aSkali/8*player.wich), aSkali/8, aSkali/8);
  if (mouseIsInsideCenter(aSkali/8, aSkali/2, aSkali/8, aSkali/2)) {
    player.place=false;
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
      println("HUIHU");
    }
  } else {
    player.place=true;
  }
  noStroke();

  textAlign(CENTER, TOP);
  fill(#FF0000);
  textSize(aSkali/8);
  text(kills + "/50 kills", width/2, aSkali/16);

  if (dev) {
    textAlign(RIGHT, TOP);
    fill(#FFFFFF);
    text(int(frameRate)+" FPS", width-aSkali/16, aSkali/16);
  }

  for (int i = 0; i < popUps.size(); i++) {
    popUps.get(i).show();
    popUps.get(i).update();
  }
}

void cross() {
  alive = false;
  reset();
}

void crossed() {
  background(#000000);
  textAlign(CENTER, CENTER);
  textSize(aSkali/8);
  fill(#DE1300);
  text("The mexicans crossed your border! Make america great again!", width/2, height/2);
  if (mouseReleased) {
    alive = true;
    spawnWait = 120;
    gameFrameCount=0;
  }
}

void win() {
  background(#A28B8B);
  textAlign(CENTER, CENTER);
  textSize(aSkali/8);
  fill(#FFE203);
  text("You made america great again! Go for your next period of office!", width/2, height/2);
  if (mouseReleased) {
    alive = true;
    won = false;
    spawnWait = 120;
    gameFrameCount=0;
  }
}

void reset() {
  mines = 0;
  buildings.clear();
  mexicans.clear();
  dollars = 500;
  kills = 0;
  popUps.clear();
}


void set() {
  //surface.setTitle("Trump First");
  //frame.setIconImage(java.awt.Toolkit.getDefaultToolkit().getImage("Trump Pixel.png"));
  imageMode(CENTER);
  //((PGraphicsOpenGL)g).textureSampling(3);
  //noSmooth();
  rectMode(CENTER);
  noStroke();
  frameRate(30);
}

void autoScale() {
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
abstract class PopUp{
  float x;
  float y;
  int last;
  int id;
  
  int start;
  
  abstract void show();
  
  void update(){
    if(frameCount - start >= last){
      popUps.remove(this.id);
      for(int i = 0; i < popUps.size(); i++){
        popUps.get(i).id = i;
      }
    }
  }
}

class PopUpText extends PopUp{
  String say;
  color fill;
  
  PopUpText(String say, color fill, float x, float y, int last, int id){
    this.say = say;
    this.fill = fill;
    this.x = x;
    this.y = y;
    this.last = last;
    this.id = id;
    this.start = frameCount;
  }
  
  void show(){
    fill(fill);
    textAlign(CENTER, CENTER);
    text(say,x,y);
  }
}

class PopUpImage extends PopUp{
  PImage effect;
  PopUpImage(PImage effect, float x, float y, int last, int id){
    this.effect = effect;
    this.x = x;
    this.y = y;
    this.last = last;
    this.id = id;
    this.start = frameCount;
  }
  
  void show(){
    image(effect, x, y, 16*aSkali/64, 16*aSkali/64);
    println("I BIMUS!");
  }
}
void load() {
  trumpImage = loadImage("Trump Pixel.png");
  wall = loadImage("Wall.png");
  mine = loadImage("Mine.png");
  mexican = loadImage("Mexican Pixel.png");
  cook = loadImage("Mexican Taco.png");
  turret = loadImage("Turret.png");
  Grenade = loadImage("Grenade.png");
  explosion = loadImage("Explosion.png");
  effects = new PImage[2];
  effects[0] = loadImage("Building Hit.png");
  effects[1] = loadImage("Mexican Hit.png");
  //player = new Trump();
  buildings = new ArrayList<Building>();
  mexicans = new ArrayList<Mexican>();
  popUps = new ArrayList<PopUp>();
}
class Trump {
  float x = 0;
  int wich = 0;

  boolean place = true;

  Trump() {
  println("Class initialised");
  }

  void show() {
    image(trumpImage, x, 48);
  }

  void control() {
  }

  void place() {
    if (this.place) {
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
            buildings.add(new Mine(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), buildings.size()));
            dollars = dollars-100;
            mines++;
          }
          break;
        case 1:
          if (dollars >= 150) {
            buildings.add(new Turret(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), buildings.size()));
            dollars = dollars-150;
          }
          break;
        case 2:
          if (dollars >= 250) {
            buildings.add(new Wall(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), buildings.size()));
            dollars = dollars-250;
          }
          break;
        case 3:
          if (dollars >= 150) {
            buildings.add(new Grenade(int((mouseX-width/2)/(aSkali/64)), int((mouseY-height/2)/(aSkali/64)), buildings.size()));
            dollars = dollars-150;
          }
          break;
        }
      }
    }
  }
}

class Mexican {
  int id;
  int x;
  float y = -48;
  float speed = 0.15;
  int hp = 20;
  boolean move = true;

  Mexican() {
  }

  Mexican(int id) {
    this.id = id;
    x = int(random(-96, 96));
  }

  void show() {
    image(mexican, x, int(y));
  }

  void check() {
    move = true;
    for (int i = 0; i < buildings.size(); i++) {
      if (rectRect(this.x, this.y+0.2, mexW, mexH, buildings.get(i).x, buildings.get(i).y, buildings.get(i).w, buildings.get(i).h)) {
        move = false;
        if (frameCount%30==0) {
          if(buildings.get(i) instanceof Grenade == false){
          buildings.get(i).way-=10;
          popUps.add(new PopUpImage(effects[0],this.x*aSkali/64+width/2,int(buildings.get(i).y*aSkali/64+height/2), 10, popUps.size()));
          }
        }
        break;
      }
    }
  }

  void move() {
    if (move) {
      y+=speed;
    }
  }

  void update() {
    if (hp <= 0) {
      kills++;
      mexicans.remove(id);
      for (int i = 0; i < mexicans.size(); i++) {
        mexicans.get(i).id = i;
      }
    }
    if (y > 48) {
      cross();
    }
  }
}

class Cook extends Mexican {
  Cook(int id) {
    this.id = id;
    x = int(random(-96, 96));
    this.speed = 0.25;
    this.hp = 45;
  }

  void show() {
    image(cook, x, int(y));
  }
}
boolean rectRect(float r1x, float r1y, float r1w, float r1h, float r2x, float r2y, float r2w, float r2h) {

  // are the sides of one rectangle touching the other?

  if (r1x + r1w/2 >= r2x - r2w/2 &&    // r1 right edge past r2 left
    r1x - r1w/2 <= r2x + r2w/2 &&    // r1 left edge past r2 right
    r1y + r1h/2 >= r2y - r2h/2 &&    // r1 top edge past r2 bottom
    r1y - r1h/2 <= r2y + r2h/2) {    // r1 bottom edge past r2 top
    return true;
  }
  return false;
}

boolean mouseIsInsideCenter(float x1, float y1, float breite, float hoehe) {
  if (mouseX<x1+(breite/2) && mouseX>x1-(breite/2) && mouseY<y1+(hoehe/2) && mouseY>y1-(hoehe/2)) {

    return true;
  } else {
    return false;
  }
}
abstract class Building {
  int x;
  int y;
  int w;
  int h;

  int id;

  int way;


  int start;

  abstract void update();

  abstract void show();

  abstract void function();
}

class Mine extends Building {
  Mine(int x, int y, int id) {
    this.x = x;
    this.y = y;
    this.w = 16;
    this.h = 16;
    this.id = id;
    this.way = 50;
    this.start = frameCount;
  }

  void update() {
    if (way <= 0) {
      buildings.remove(id);
      for (int i = 0; i < buildings.size(); i++) {
        buildings.get(i).id = i;
      }
      mines--;
    }
  }

  void show() {
    image(mine, x, y);
  }

  void function() {
    if (frameCount-start >= 45) {
      dollars = dollars+10;
      popUps.add(new PopUpText("+10$", #FFE203, this.x*aSkali/64+width/2, this.y*aSkali/64+height/2, 10, popUps.size()));
      start = frameCount;
    }
  }
}

class Wall extends Building {
  Wall(int x, int y, int id) {
    this.x = x;
    this.y = y;
    this.w = 32;
    this.h = 8;
    this.id = id;
    this.way = 250;
    this.start = frameCount;
  }

  void update() {
    if (way <= 0) {
      buildings.remove(id);
      for (int i = 0; i < buildings.size(); i++) {
        buildings.get(i).id = i;
      }
    }
  }

  void show() {
    image(wall, x, y);
  }

  void function() {
  }
}

class Turret extends Building {
  ArrayList<Shot> shots;
  Turret(int x, int y, int id) {
    this.x = x;
    this.y = y;
    this.w = 12;
    this.h = 2;
    this.id = id;
    this.way = 100;
    this.start = frameCount;

    shots = new ArrayList<Shot>();
  }

  void update() {
    if (way <= 0) {
      buildings.remove(id);
      for (int i = 0; i < buildings.size(); i++) {
        buildings.get(i).id = i;
      }
    }
  }

  void show() {
    image(turret, x, y);
  }

  void function() {
    if (frameCount-start >= 90) {
      shots.add(new Shot(this.x-1, this.y-8, shots.size()));
      start = frameCount;
    }
    for (int i = 0; i < shots.size(); i++) {
      shots.get(i).collide();
      shots.get(i).update();
      shots.get(i).show();
      if (shots.get(i).active == false) {
        shots.remove(i);
        for (int j = 0; j < shots.size(); j++) {
          shots.get(j).id = j;
        }
      }
    }
  }
}

class Grenade extends Building {
  boolean explode = false;
  Grenade(int x, int y, int id) {
    this.x = x;
    this.y = y;
    this.w = 8;
    this.h = 8;
    this.id = id;
    this.start = frameCount;
  }

  void update() {
    if (frameCount - start == 30) {
      explode = true;
    } else if (frameCount - start == 45) {
      buildings.remove(id);
      for (int i = 0; i < buildings.size(); i++) {
        buildings.get(i).id = i;
      }
    }
  }

  void show() {
    if (explode) {
      image(explosion, x, y);
    } else {
      image(Grenade, x, y);
    }
  }

  void function() {
    if(frameCount - start == 30){
      for(int i = 0; i < mexicans.size(); i++){
        if(dist(mexicans.get(i).x, mexicans.get(i).y, this.x, this.y) < 24){
          mexicans.get(i).hp-=20;
          popUps.add(new PopUpImage(effects[1],mexicans.get(i).x*aSkali/64+width/2,int(mexicans.get(i).y*aSkali/64+height/2), 15, popUps.size()));
        }
      }
    }
  }
}

class Shot {
  float x;
  float y;

  int id;

  boolean active = true;

  Shot(float x, float y, int id) {
    this.x = x;
    this.y = y;
    this.id = id;
  }

  void collide() {
    for (int i = 0; i < mexicans.size(); i++) {
      if (rectRect(this.x, this.y, 2, 2, mexicans.get(i).x-1, mexicans.get(i).y, mexW, mexH)) {
        mexicans.get(i).hp-=5;
        popUps.add(new PopUpImage(effects[1],mexicans.get(i).x*aSkali/64+width/2,int(mexicans.get(i).y*aSkali/64+height/2), 6, popUps.size()));
        active = false;
      }
    }
  }

  void update() {
    y-=0.5;
    if (this.y <= -52) {
      active = false;
    }
  }

  void show() {
    rectMode(CORNER);
    fill(50);
    rect(int(x), int(y), 2, 2);
    rectMode(CENTER);
  }
}
