"use strict";
/*File:   pullMenuItems.js
  Author: Kevin Viren
  Date:   5/4/2024  
*/

$(document).ready(function() {
	
	$.get('assets/data/menuItems.xml', function(data) {
		var str="";

		$(data).find('Category').each(function() { 
			str += "<h2>"+$(this).attr('name')+"</h2><table class='table'>";
			str += "<thead><th>Dish</th><th>Description</th><th></th></thead><tbody>";
			$(this).find('Item').each(function() {
				str += "<tr>";
				str += "<td>"+$(this).find('Name').text()+"</td>";
				str += "<td colspan='2'>"+$(this).find('Description').text()+"<br/><br/><br/></td>";
				str += "</tr>";
			});
			str += "</tbody></table>";
		});
		$('#menu-content').html(str);
	});
});