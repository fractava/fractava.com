
//Menüs:
// 0-9: Server Information
// 0. für Server Übersicht reserviert
// 1. CPU
// 2. RAM
// 3. Disks / Geräte
// 4. Network
// 5. weitere Informationen (z.b. Linux Version , Uptime)
// 
// 10-19
// 10. Management Übersicht
// 11. User Liste
// 12. User Details
// 

var menue = 1;

function setup() {
  createCanvas(windowWidth, windowHeight);
}

function draw() {
  background(0);
  
}

function windowResized() {
  resizeCanvas(windowWidth, windowHeight);
}
