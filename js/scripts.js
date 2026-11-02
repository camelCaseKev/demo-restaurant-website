"use strict";
/*File:   scripts.js
  Author: Kevin Viren
  Date:   5/4/2024  
*/

var slides = ['carousel1.jpg','carousel2.jpg','carousel3.jpg'];
var h3 = ['Pizza','Fish Cakes','Hamburger'];
var para = ['Sausage and pepperoni', 'Fresh lake trout fish cakes with potato wedges, a salad, and vegetables', 'With a fried egg, bacon, lettuce, onion, and a side of coleslaw and potato wedges']

var indicators = document.getElementsByClassName("carousel-indicators")[0];
var inner = document.getElementsByClassName("carousel-inner")[0];

var htmlIndicators = "";
var htmlSlide = "";

for(let i=0; i<slides.length; i++) {
	
	htmlIndicators += "<button type='button' data-bs-target='#slide-show' data-bs-slide-to='"+i+"' class='active' aria-label='Slide "+i+"'";
	
	htmlSlide += '<div class="carousel-item';
	
	if(i == 0) {
		htmlIndicators += 'aria-current="true"';
		htmlSlide += ' active ';
	}
	htmlIndicators += "></button>";
	
	htmlSlide += '"><img src="assets/images/'+slides[i]+'" class="d-block w-100" alt="carousel slide"/>'+
					'<div class="carousel-caption d-none d-md-block">'+
					'<h3>'+h3[i]+'</h3>'+
					'<p>'+para[i]+'</p>'+
				'</div>'+
			'</div>';
}

indicators.innerHTML = htmlIndicators;
inner.innerHTML = htmlSlide;

var myCarousel = document.querySelector('#slide-show');

var carousel = new bootstrap.Carousel(myCarousel, {
	interval: 4000,
	touch: false,
});