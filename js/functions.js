function ScrollToElement(element) {
  //id = id.replace("link", 
  $('html,body').animate({scrollTop: $(element).offset().top}, 'slow');
  //);
}
function ScrollTo(id) {
    ScrollToElement($(getNavSections()[id]));
}
$(document).ready(function() {
	setUpNavPoints();
	updateNavColors();
});
$(window).scroll(function() {
	updateNavColors();
});

function getNavSections(){
	return $(".nav_section");
}

function invertColors(color){
	if(color == 'black'){
		return 'white';
	}else{
		return 'black';
	}
}
function updateNavColors() {
	for(let section of getNavSections()){
	    let sectionId = section.getAttribute("data-section-id");
	    let navPoint = $( '.navPoint[data-section-id=' + sectionId + ']' )[0];
		let sectionBackground = section.style.backgroundColor;
		
		console.log(sectionId);
		console.log(sectionBackground);
		console.log(navPoint);
		
		if(collidesWith(navPoint,section)){
		    console.log("collides");
			navPoint.style.color = invertColors(sectionBackground);
		}else{
		    console.log("doesnt collide");
			navPoint.style.color = sectionBackground;
		}
	}
}
function setUpNavPoints(){
	var table = document.createElement('TABLE');
	table.setAttribute('id', 'lnav');
	for(let section of getNavSections()){
		var tr = document.createElement('TR');
		var th = document.createElement('TH');
		var p = document.createElement('P');

		p.setAttribute('class', 'navPoint');
		p.setAttribute('data-section-id', section.getAttribute("data-section-id"));
		p.appendChild(document.createTextNode('•'));
		$(p).click(function(){ScrollTo(section.getAttribute("data-section-id"))});
		th.appendChild(p);
		tr.appendChild(th);
		table.appendChild(tr);
	}
	document.body.appendChild(table);
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

var overlaps = (function () {
  function getPositions( elem ) {
    var pos, width, height;
    pos = $( elem ).position();
    width = $( elem ).width();
    height = $( elem ).height();
    return [ [ pos.left, pos.left + width ], [ pos.top, pos.top + height ] ];
  }
  function comparePositions( p1, p2 ) {
    var r1, r2;
    r1 = p1[0] < p2[0] ? p1 : p2;
    r2 = p1[0] < p2[0] ? p2 : p1;
    return r1[1] > r2[0] || r1[0] === r2[0];
  }
  return function ( a, b ) {
    var pos1 = getPositions( a ), pos2 = getPositions( b );
    return comparePositions( pos1[0], pos2[0] ) && comparePositions( pos1[1], pos2[1] );
  };
})();

$(function () {
  var area = $( '#area' )[0],
  box = $( '#box0' )[0], html;
  html = $( area ).children().not( box ).map( function ( i ) {
    return '<p>Red box + Box ' + ( i + 1 ) + ' = ' + overlaps( box, this ) + '</p>';
  }).get().join( '' );
  $( 'body' ).append( html );
});
