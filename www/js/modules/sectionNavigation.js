function init() {
    return new Promise(function(resolve,reject){
        $(window).scroll(function() {
        	updateNavColors();
        });
        resolve();
    });
}

// main functions
function updateNavColors() {
	for(let section of getNavSections()){
	    let sectionId = section.getAttribute("data-section-id");
	    let navPoint = $( '.navPoint[data-section-id=' + sectionId + ']' )[0];
		let sectionBackground = section.style.backgroundColor;
		
		//console.log(sectionId);
		//console.log(sectionBackground);
		//console.log(navPoint);
		
		if(collidesWith(navPoint,section)){
			navPoint.style.color = invertColors(sectionBackground);
		}else{
			navPoint.style.color = sectionBackground;
		}
	}
}
function setUpNavPoints(){
    $("#navPointContainer").remove();
    
	var table = document.createElement('TABLE');
	table.setAttribute('id', 'navPointContainer');
	
	for(let section of getNavSections()){
		var tr = document.createElement('TR');
		var th = document.createElement('TH');
		var p = document.createElement('P');

		p.setAttribute('class', 'navPoint');
		p.setAttribute('data-section-id', section.getAttribute("data-section-id"));
		p.appendChild(document.createTextNode('•'));
		
		$(p).click(function(){
		    ScrollToSection(section.getAttribute("data-section-id"))
		});
		
		th.appendChild(p);
		tr.appendChild(th);
		table.appendChild(tr);
	}
	document.body.appendChild(table);
	
	updateNavColors();
}

function setupEventHandlers() {
    $(".scrollTriangle").click(function() {
        ScrollToSection(this.getAttribute("data-to-section"));
    });
}

// Helper Functions
function ScrollToElement(element) {
  $('html,body').animate({scrollTop: $(element).offset().top}, 'slow');
}
function ScrollToSection(id) {
    ScrollToElement($(getNavSections()[id]));
}
function invertColors(color){
	if(color == 'black'){
		return 'white';
	}else{
		return 'black';
	}
}
function getNavSections(){
	return $(".navSection");
}
function collidesWith (element1, element2) {
  var Element1 = {};
  var Element2 = {};

  Element1.top = $(element1).offset().top;
  Element1.left = $(element1).offset().left;
  Element1.right = Number($(element1).offset().left) + Number($(element1).width());
  Element1.bottom = Number($(element1).offset().top) + Number($(element1).height());

  Element2.top = $(element2).offset().top;
  Element2.left = $(element2).offset().left;
  Element2.right = Number($(element2).offset().left) + Number($(element2).width());
  Element2.bottom = Number($(element2).offset().top) + Number($(element2).height());

  return (Element1.right > Element2.left && Element1.left < Element2.right && Element1.top < Element2.bottom && Element1.bottom > Element2.top);
}

export{init, setUpNavPoints, setupEventHandlers, updateNavColors, ScrollToSection, ScrollToElement};