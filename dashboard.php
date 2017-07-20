<div class="optimus_in_app">
					<img src="http://localhost/assets/image/18134461ca57c4513277c0a134274dae.jpg">
			</div>

<div class="welcome_heading effect_top_1">
Welcome ABinBev
</div>
<div class="welcome_body effect_top_1">
I am optimus. I know your are king of beers <br>and I am here to make sure you stay forever.
</div>

<?php

$tips = array(
		"Longer the beer bottle neck, More pressure it can hold.",
		"Amsterdam pays alcoholics in beer. For cleaning the city streets, local alcoholics get 10 Euros, half a packet of rolling tobacco and 5 beers as payment by a government-funded organization.",
		"Steven Petrosino of New Cumberland, Pennsylvania downed 1 liter of beer or 33 ounces in a chilly 1.3 seconds in 1977 which made him a World Beer Chugging Champion according to the Guinness Book of World Records.",
		"Beer is one of the world's oldest prepared beverages, possibly dating back to the early Neolithic or 9500 BC.",
		"In 1814, almost 400,000 gallons of beer flooded several streets in London after a huge vat ruptured in the parish of St. Giles.",
		"The world's strongest beer is Brewmeister's „Snake Venom'. While regular beer usually have about 5% ABV, this Scottish killer has a stomach-burning 67,5% ABV.",
		"Stanford researchers found that beer bubbles create a gravity-defying loop. Bubbles head up in the center where frictional drag from the glass is less and down on the outside as the top gets crowded.",
		"The Ancient Egyptians built the pyramids under the influence. According to Patrick McGovern, an archaeologist from the University of Pennsylvania, workers at Giza received about four liters of beer a day.",
		"Beer prevents kidney stones. A study published in American Journal of Epidemiology estimated that a bottle of beer consumed every day reduces the risk by 40%.",
		"Beer commercials in the US aren't really allowed to show people actually drinking the beer. It's a US law that people cannot actually be shown consuming an alcoholic beverage on television.",
		"The study of beer and beer-making even has an official scientific name – zythology. It derives from the Greek words 'zythos' (beer) and 'logos' (study).",
		"The most beer-drinking country in the world is the Czech Republic. With an incredible per capita beer consumption of almost 40 gallons a year, the Czechs are way out in front in the beer drinking world league table.",
		"The world's most expensive beer is Belgian's 'Vielle Bon Secours'. One bottle costs around 1000 American dollars.",
		"Experimenting with beer has taken many forms. John Lubbock, an 18th-century English biologist, studied the behavior of beer on drunken ants.",
		"Old Vikings believed that in their heaven called Valhalla, there is a giant goat whose udders provided unlimited supply of beer.",
		"Nowadays, there are about 400 types of beer in the world. Belgium is the country that has the most individual beer brands.",
		"Ancient Babylonians were so serious about brewing beer that if anyone brewed a bad batch, they would drown him in it as a punishment.",
		"Cenosillicaphobia is the fear of an empty beer glass. Terrifying phobia indeed.",
		"The oldest drinkable beer in the world was found in 2010, in an early 19th-century shipwreck discovered near Finland. The beer was preserved in bottles by the cold abyss and it tasted very old (unsurprisingly), with some burnt notes and an acidic aftertaste.",
		"The first professional brewers were all women called brewsters. The women had to be very beautiful to be able to become brewsters.",
		"The world's largest beer festival is Oktoberfest. Held annually in Munich, Germany, it is a 16-day funfair running from late September to the first weekend in October with more than 6 million people from around the world attending the event every year.",
		"At any given time, 0.7% of the world population is drunk. It means 50 million people are drunk right now. Beer is obviously the main contributor to the drunkenness.",
		"The foamy head is a very important part of the beer. It is formed by a complex carbon-dioxide reaction and can say a lot about the quality of the beer. If the head is missing, it can mean that your beer is flat and bland-tasting.",
		"Beer and marijuana have more in common than you would think. Beer's hops are in the same family of flowering plants as marijuana.",
		"Beer strengthens bones. It is rich in silicon that increases calcium deposits and minerals for bone tissue.",
		"American president George Washington had his own brewhouse on the grounds of Mount Vernon.",
		);

?>

<div class="tip_box">
		<div class="tip_heading">
			Fact/Tip Of The Day
		</div>
		<div class="tip_body">
				<?php

					//to know the size of tips array
					$tips_size = count($tips);
					//to create random number better size
					$random_tip = rand(0 , ($tips_size - 1) );
					//to print random tip 
					echo $tips[$random_tip];

				?>
		</div>
</div>


<?php

//to connect to database
include "connect.inc.php";


$brand_names = "";

$brand_code = mysqli_query($connect , "SELECT DISTINCT brand_value as 'brand' from `$db_name`.`$table_name` where `brewer_value` = 'ABI'");



while ($brand_data = mysqli_fetch_array($brand_code) ) {
	  $bn = $brand_data['brand'];
      
      $brand_names .= "<option value='$bn'>$bn</option> ";
}

?>

<div class="investment_planner_box">
			<div class="investment_planner_heading">
						Investment simulator
			</div>
			<div class="investment_planner_body">
				
				$ <input type="investment" class="investment_input" id="investment_input" placeholder="Investment Value">
				  <select class="investment_input" id='brand'>
				  	 	<option selected>Select Brand</option>
				  	 	<?php echo $brand_names; ?>
				  </select>
				<input type="button" class="investment_button" id="start_stimulation" value="Start simulation">

				<div class="simulator_result" style='display:none; '>Processing...</div>

			</div>
</div>


<script type="text/javascript">
		
	$(document).ready(function(){

		$("#start_stimulation").click(function(){


				var investment = document.getElementById('investment_input').value;
				var brand  	   = document.getElementById("brand").value;

				$(".simulator_result").show();

				$.post("http://localhost/investment_simulator.php" , {investment:investment,brand:brand} , function(response){
						$(".simulator_result").html(response);
				});

		});

	});

</script>
