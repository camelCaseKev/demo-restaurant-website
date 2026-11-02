"use strict";
/*File:   showMap.js
  Author: Kevin Viren
  Date:   12/11/2024  
*/


function showMap() {
   
   let displayMap = document.getElementById("gMap");
   let efhLocation = {lat: 47.74911937722522, lng: -90.33510344274004};
   
   let myMap = new google.maps.Map(displayMap, {
       zoom: 15, // was 20
	   center: efhLocation,
	   fullscreenControl: false,
   });
   
   
   /*new google.maps.marker.AdvancedMarkerElement({
	   position: efhLocation,
	   map: myMap,
	   title: "Eat Food Here"
   });*/
   
   
   new google.maps.Marker({
	   position: efhLocation,
	   map: myMap,
	   title: "Eat Food Here"
   });
}