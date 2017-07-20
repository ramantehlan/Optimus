/******************************************
This is to show effect on page

Creator:- raman tehlan
Date of creation:- 03/02/2017
*******************************************/

//to check if page is ready
$(document).ready(function(){

		//effect_1
		$(".effect_1").show("drop" , {direction:"up"} , 300);

		setTimeout(function(){

			//effect_2
			$(".effect_2").show("drop" , {direction: "left"} , 500);

				setTimeout(function(){

					//effect_3
					$(".effect_3").show("drop" , {direction: "left"} , 500);

				}, 550);

		} , 350);

		//this is for app
		$(".effect_top_1").show("drop" , {direction : "up"} , 300);


});