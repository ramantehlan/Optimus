<?php
/****************************************************
This is to analyse various factores 

creator:- Raman Tehlan
Date of creation:- 04/02/2017
****************************************************/
?>		

<?php 
/**************************************************
this is to get data from database to print it
****************************************************/

//to connec
include "connect.inc.php";

/***********************************
this is the information we are going to show 

total unit sold in last four year
total volume sold in last four year
*************************************/

$years = array( 2016 , 2015 , 2014 , 2013);

//this is the string for putting it in javascript
$javascript_str_set1 = array();

//running loop to find out sales according to 
//month for year array

/*****************************
algoritham is 

	(in 1 and 2 month and year will remain same)
1) we are going to find out no of units sold on a day 
2) then we will multiply it with the cost on that day 
3) then we will add it to the final of that month

*****************************/


for($set = 0; $set < count($years) ; $set++){

		//to store total sum according to there month
		$year_str = "";

		//running loop for the 12 months
		for($m = 1; $m <= 12; $m++){

			$year = $years[$set];

			//code to get info for respective month and year
			$code_set1 = mysqli_query($connect , "SELECT sum(price_per_unit * unit_sales) as 'sum' from `$db_name`.`$table_name` where `date` like '$m/%/$year' or `date` like '$m/%%/$year' and `brewer_value` = 'ABI';");

			$set1_db = mysqli_fetch_array($code_set1);
	
		//this is to add the total month sales (m_sales) 
		//to year_string with comman to make it javascript friendly
	    $year_str .=  $set1_db['sum'] . " , ";

	}
	
	//this is to remove the last comman
	$year_str = rtrim($year_str , ",");

	//this is to add 1year string to all year array string
	$javascript_str_set1[$set] = $year_str; 


}


//This is for the set 2

//we will find out the demand of brands


/******************************************
ALgoritham 

1) we will search for distinct brand name and store them
2) then we will find out no of units sold under them
*******************************************/

//this array is to store brand and package names
$brand_names = array();
$package_names = array();

//getting distinct brand names
$code_set2_brand = mysqli_query($connect , "SELECT DISTINCT brand_value as 'brand' from `$db_name`.`$table_name` where `brewer_value` = 'ABI'");
$code_set2_package = mysqli_query($connect , "SELECT DISTINCT package_value as 'package' from `$db_name`.`$table_name` where `brewer_value` = 'ABI'");

$no_set2_brand = mysqli_num_rows($code_set2_brand);
$no_set2_package = mysqli_num_rows($code_set2_package);

/*******************************************
this is to decide which is more 
and then using the greater one to 
run all the loops
********************************************/
	
	if($no_set2_brand >= $no_set2_package){
		$limit = $no_set2_brand;
	}else{
		$limit = $no_set2_package;
	}


//this works as a index
$n = 0;

while ($brand_data = mysqli_fetch_array($code_set2_brand) ) {
	$brand_names[$n] = $brand_data['brand'];

	$n++;
}

$n = 0;

while($package_data = mysqli_fetch_array($code_set2_package)){
	$package_names[$n] = $package_data['package'];

	$n++;
}

//this string store data about brand name for charts
$brand_str = "";
//this store the number of units sold by brands
$brand_sold_str = "";

//this string store data of packages 
$package_str = "";
//this store the number of units sold of a package
$package_sold_str = "";


for($no = 0; $no < $limit; $no++){

	//this is for brand
	
	 if($no_set2_brand > $no){
		$bd = $brand_names[$no];

		$brand_sold_code = mysqli_query($connect , "SELECT SUM(unit_sales) as 'sales' from `$db_name`.`$table_name` where `brand_value` = '$bd' and `brewer_value` = 'ABI';");
		$brand_sold_array = mysqli_fetch_array($brand_sold_code);

		$brand_str .= " '$bd' , ";
		$brand_sold_str .= $brand_sold_array['sales'] . " , ";
		}

	//this is for package
	 if($no_set2_package > $no){
	 	$pg = $package_names[$no];

	 	$package_sold_code = mysqli_query($connect , "SELECT SUM(unit_sales) as 'sales' from `$db_name`.`$table_name` where `package_value` = '$pg' and `brewer_value` = 'ABI';");
	 	$package_sold_array = mysqli_fetch_array($package_sold_code);

	 	$package_str .= " '$pg' , ";
	 	$package_sold_str .= $package_sold_array['sales'] . " , ";
	 	}

}

//removing last comma for brand data
$brand_str = rtrim($brand_str , ",");
$brand_sold_str = rtrim($brand_sold_str , " , ");

//removing last comma for package data
$package_str = rtrim($package_str , ",");
$package_sold_str = rtrim($package_sold_str , ",");



/********************************************************
This area is to calculate deduction
*********************************************************/


function round_arr($arr){

	for($l = 0; $l < count($arr) ; $l++){
		$arr[$l] = round($arr[$l]);
	}

	return $arr;
}

function get_month($no){

		$month = "";

		switch ($no) {
			case '0':
				$month = "January";
			break;
			case '1':
				$month = "February";
			break;
			case '2':
				$month = "March";
			break;
			case '3':
				$month = "April";
			break;
			case '4':
				$month = "May";
			break;
			case '5':
				$month = "June";
			break;
			case '6':
				$month = "July";
			break;
			case '7':
				$month = "August";
			break;
			case '8':
				$month = "September";
			break;
			case '9':
				$month = "October";
			break;
			case '10':
				$month = "November";
			break;
			case '11':
				$month = "December";
			break;
		}

		return $month;

}



//deduction for sales

//deduction one is to find out month best for promotions 
//deduction two is to find out month for offers

	//getting sales info for 2016
	$string_2016_sales = rtrim($javascript_str_set1[0] , ",");
	//create array from sales info
	$arr = explode("," , $string_2016_sales);
	//delete last element of array
	unset($arr[12]);
	//round all the number in array
	$arr = round_arr($arr);


	//find the minimum number in array
	$min =  min($arr);
	//find the maximum number in array
	$max =  max($arr);

	//now we need to get the number of month in which 
	//respective max and min occur
	$ad_no = array_search($min , $arr);
	$of_no = array_search($max, $arr);

	//this is going to be our advertising month
	$ad_month = get_month($ad_no);
	//this is going to be our offer month
	$of_month = get_month($of_no);
    


//deduction for brands and package 

//find the most selling brand an appreciate it
//find the least selling brand an help it out

	//getting brand names from 
	$brand_sale_arr = explode(",", $brand_sold_str);
	//this is to round all the data of array
	$brand_sale_arr = round_arr($brand_sale_arr);


	//find the  minimum brand demand
	$br_min = min($brand_sale_arr);
	//find the maximum brand demand
	$br_max = max($brand_sale_arr);

	//this is to get index of max and min demand
	$br_min_no = array_search($br_min, $brand_sale_arr);
	$br_max_no = array_search($br_max , $brand_sale_arr);

	//this is to create the array of brand names
	$brand_arr = explode("," , $brand_str);

	//this is to get name of max and min brand demand
	$min_brand = $brand_arr[$br_min_no];
	$max_brand = $brand_arr[$br_max_no]; 


//find the most demanded package and ask to manufacture it more
//find the lest demanded package and ask to advertise it more

	//getting package name
	$package_sale_arr = explode(",", $package_sold_str);
	//this is to round all the data of array
	$package_sale_arr = round_arr($package_sale_arr);

	//find the minimum package demand
	$pa_min = min($package_sale_arr);
	//find the maximum package demand
	$pa_max = max($package_sale_arr);

	//this is to get index of max and min package demand
	$pa_min_no = array_search($pa_min, $package_sale_arr);
	$pa_max_no = array_search($pa_max, $package_sale_arr);

	//this is to create the array of package name
	$package_arr = explode(",", $package_str);

	//this is  to get name of max and min package demand
	$min_package = $package_arr[$pa_min_no];
	$max_package = $package_arr[$pa_max_no];



?>



<style type="text/css">
				
				html{background-color:#ddf2eb;
				}

			</style>

		<script type="text/javascript" src="assets/script/chart.js"></script>

<div class="optimus_in_app">
	<img src="assets/image/18134461ca57c4513277c0a134274dae.jpg">
</div>		

<div class="welcome_heading effect_top_1">
Analysis
</div>
<div class="welcome_body effect_top_1">
Hey, Look how good you are doing!<br>
But if you wanna grow more faster use my deductions.
</div>

<div class="analysis_container">
			
	<div class='analysis_heading'>
					Overall Sales<sub>($)</sub> (last 4 years) 
	</div>
	<div class="analysis_body">




			<div class='box'>
					<div class='box_heading'>
								<div class='graph_indicator'>
									Lines
								</div>
								Overall Sales in 2016
					</div>

					<div class='box_body'>

						<canvas id="chart_1"></canvas>

					</div>
			</div>

			<div class='box'>
					<div class='box_heading'>
								<div class='graph_indicator'>
									Lines
								</div>
								Overall Sales in 2015
					</div>

					<div class='box_body'>

						<canvas id="chart_2"></canvas>

					</div>
			</div>
			

			<div class='box'>
					<div class='box_heading'>
								<div class='graph_indicator'>
									Lines
								</div>
								Overall Sales in 2014
					</div>

					<div class='box_body'>

						<canvas id="chart_3"></canvas>

					</div>
			</div>

			<div class='box'>
					<div class='box_heading'>
								<div class='graph_indicator'>
									Lines
								</div>
								Overall Sales in 2013
					</div>

					<div class='box_body'>

						<canvas id="chart_4"></canvas>

					</div>
			</div>

			<div class="deduction_box">
						<div class="deduction_title">
									Insights for Sales
						</div>
						<div class="deduction_body">
								1) You should consider doing more <b>advertisement</b> in <b><?php echo $ad_month; ?></b>. (Get attention at right time)<br>
								2) <b><?php echo $of_month; ?></b> is best month to give <b>offers</b> to people to make them loyal to your brand.
								
						</div>
			</div>
			

	</div>

	<div class='analysis_heading'>
					Brand & Package Demand (last 4 years)
	</div>
	<div class="analysis_body">




			<div class='big_box'>
					<div class='box_heading'>
								<div class='graph_indicator'>
									Pie
								</div>
								Brand Demand
					</div>

					<div class='box_body'>

						<canvas id="chart_5"></canvas>
					</div>
			</div>

			<div class='big_box'>
					<div class='box_heading'>
								<div class='graph_indicator'>
									Pie
								</div>
								Package Demand
					</div>

					<div class='box_body'>

						<canvas id="chart_6"></canvas>

					</div>
			</div>

			<div class="deduction_box">
						<div class="deduction_title">
									Insights for Brands and Packages
						</div>
						<div class="deduction_body">

									
									1) <b><?php echo $max_brand; ?></b> is most demanded brand do appreciate it. <br>
									2) You should put your focus on <b><?php echo $min_brand; ?></b>, it need a little push and a bit extra attention.<br>
									3) It's time to increase production of <b><?php echo $max_package; ?></b>.<br>
									<?php /*4) You should add a offer with <b><?php echo $min_package; ?></b> or do more advertisement for it.*/ ?>
						</div>

			</div>


	</div>


</div>




<script type="text/javascript">

	//global configuration


//for font
Chart.defaults.global.defaultFontColor = "#ADADAD";
Chart.defaults.global.defaultFontFamily = "text-normal";
Chart.defaults.global.defaultFontSize = 13;
Chart.defaults.global.defaultFontStyle = "normal";

//for chart
Chart.defaults.global.responsive = true;
Chart.defaults.global.responsiveAnimationDuration = 500;
Chart.defaults.global.maintainAspectRatio = true;
Chart.defaults.global.events = ["mousemove", "mouseout", "click", "touchstart", "touchmove", "touchend"];
Chart.defaults.global.onClick = null;
Chart.defaults.global.legendCallback = null;
Chart.defaults.global.onResize = null;

//for element configuration
Chart.defaults.global.elements.arc.backgroundColor = 'rgba(123,154,231,1)';
Chart.defaults.global.elements.arc.borderColor = "#fff";
Chart.defaults.global.elements.arc.borderWidth = 5;


//.other_options will come infront of below global
//these are same as options used below
//Chart.defaults.global.tooltips
//Chart.defaults.global.hover
//Chart.defaults.global.animation



/****************
#all animations 

'linear', 'easeInQuad', 'easeOutQuad', 'easeInOutQuad', 
'easeInCubic', 'easeOutCubic', 'easeInOutCubic', 'easeInQuart', 
'easeOutQuart', 'easeInOutQuart', 'easeInQuint', 'easeOutQuint', 
'easeInOutQuint', 'easeInSine', 'easeOutSine', 'easeInOutSine', 
'easeInExpo', 'easeOutExpo', 'easeInOutExpo', 'easeInCirc', 
'easeOutCirc', 'easeInOutCirc', 'easeInElastic', 'easeOutElastic', 
'easeInOutElastic', 'easeInBack','easeOutBack', 'easeInOutBack', 
'easeInBounce', 'easeOutBounce', 'easeInOutBounce'

#all modes

point , nearest , index , dataset , x , y

#point style

 'circle', 'triangle', 'rect', 'rectRot', 'cross', 'crossRot', 'star', 'line', and 'dash'.

*********************/




</script>

<?php
		

		//this is comman chart javascript code for 
		//sales chart
		$comman_sales_chart_info = "options: {
    		    	animation: {
    			duration: 1500,
    			easing: 'easeInOutExpo',
    			onProgress: null ,//function
    			onComplete: null //function 
    	},
    	tooltips:{
    		enabled: true,
    		mode: 'nearest',
    		intersect: true,
    		position: 'average', //nearest or average
    		backgroundColor: '#000',
    		titleFontFamily: 'text-thin',
    		titleFontSize: 12,
    		titleFontStyle: 'bold',
    		titleFontColor: '#fff',
    		titleSpacing: 0,
    		titleMarginBottom: 5,
    		bodyFontFamily: 'text-normal',
    		bodyFontSize: 13,
    		bodyFontStyle: 'normal',
    		bodyFontColor: '#f4f4f4',
    		bodySpacing: 0,
    		/*footerFontFamily: 'text-heading',
    		footerFontSize
			footerFontStyle
			footerFontColor
			footerSpacing
			footerMarginTop
    		*/
    		xPadding:20,
    		yPadding:10,
    		caretSize: 6,
    		cornerRadius: 6,
    		//multiKeyBackground: '#fff',
    		displayColors: false
    	},

    	legend: {
    		display: false,
    		position: 'top',
    		fullWidth: false,
    		//onClick: null,
    		//onHover: null,
    		labels: {
    				boxWidth: 10,
    				fontSize: 13,
    				fontStyle: 'normal',
    				fontColor: '#96897B',
    				fontFamily: 'text-menu',
    				padding: 20,
    			},
    		reverse: false
    	},

    	layout:{
    			padding:0
    	},

        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },

        title: {
            display: false,
            position: 'top',
            fullWidth: true,
            fontSize: 14,
            fontFamily: 'text-thin',
            fontColor: '#000000',
            fontStyle: 'bold',
            padding: 20,
            text: 'Custom Chart Title',
        }
    }";

?>


<script type="text/javascript">

	//this is to print char 1
	
	var chart_box_1 = document.getElementById("chart_1");

	var chart_1 = new Chart(chart_box_1,{
    type: 'line',
    data: {
        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
        datasets: [{
         
            label: "Sales",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,1)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 3,
            pointHitRadius: 10,
            data: [ <?php echo $javascript_str_set1[0]; ?>  ],
            spanGaps: false,
            pointStyle: "circle",
            showLine: true,
            steppedLine: false,

        }] 
    },

    <?php echo $comman_sales_chart_info; ?>
    
});
</script>

<script type="text/javascript">

	//this is to print char 1
	
	var chart_box_2 = document.getElementById("chart_2");

	var chart_2 = new Chart(chart_box_2,{
    type: 'line',
    data: {
        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
        datasets: [{
         
            label: "Sales",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,1)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 3,
            pointHitRadius: 10,
            data: [ <?php echo $javascript_str_set1[1]; ?> ],
            spanGaps: false,
            pointStyle: "circle",
            showLine: true,
            steppedLine: false,

        }] 
    },

    <?php echo $comman_sales_chart_info; ?>
    
});
</script>

<script type="text/javascript">

	//this is to print char 1
	
	var chart_box_3 = document.getElementById("chart_3");

	var chart_3 = new Chart(chart_box_3,{
    type: 'line',
    data: {
        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
        datasets: [{
         
            label: "Sales",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,1)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 3,
            pointHitRadius: 10,
            data: [ <?php echo $javascript_str_set1[2]; ?>],
            spanGaps: false,
            pointStyle: "circle",
            showLine: true,
            steppedLine: false,

        }] 
    },

    <?php echo $comman_sales_chart_info; ?>
    
});
</script>

<script type="text/javascript">

	//this is to print char 1
	
	var chart_box_4 = document.getElementById("chart_4");

	var chart_4 = new Chart(chart_box_4,{
    type: 'line',
    data: {
        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
        datasets: [{
         
            label: "Sales",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,1)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 3,
            pointHitRadius: 10,
            data: [ <?php echo $javascript_str_set1[3]; ?>],
            spanGaps: false,
            pointStyle: "circle",
            showLine: true,
            steppedLine: false,

        }] 
    },

    <?php echo $comman_sales_chart_info; ?>
    
});
</script>

<?php 


$comman_sales_chart_info_2 = " options: {

    	tooltips:{
    		enabled: true,
    		mode: 'nearest',
    		intersect: true,
    		position: 'average', //nearest or average
    		backgroundColor: '#000',
    		titleFontFamily: 'text-thin',
    		titleFontSize: 12,
    		titleFontStyle: 'bold',
    		titleFontColor: '#fff',
    		titleSpacing: 0,
    		titleMarginBottom: 5,
    		bodyFontFamily: 'text-normal',
    		bodyFontSize: 13,
    		bodyFontStyle: 'normal',
    		bodyFontColor: '#f4f4f4',
    		bodySpacing: 0,
    		/*footerFontFamily: 'text-heading',
    		footerFontSize
			footerFontStyle
			footerFontColor
			footerSpacing
			footerMarginTop
    		*/
    		xPadding:20,
    		yPadding:10,
    		caretSize: 6,
    		cornerRadius: 6,
    		//multiKeyBackground: '#fff',
    		displayColors: false
    	},

    	legend: {
    		display: true,
    		position: 'top',
    		fullWidth: true,
    		//onClick: null,
    		//onHover: null,
    		labels: {
    				boxWidth: 10,
    				fontSize: 13,
    				fontStyle: 'normal',
    				fontColor: '#96897B',
    				fontFamily: 'text-normal',
    				padding: 20,
    			},
    		reverse: false
    	},

    	layout:{
    			padding:00
    	},

        title: {
            display: false,
            position: 'top',
            fullWidth: true,
            fontSize: 14,
            fontFamily: 'text-thin',
            fontColor: '#000000',
            fontStyle: 'bold',
            padding: 20,
            text: 'Custom Chart Title',
        }
    }";

    $set2_colors = "  '#FF4D80',
                '#FF3E41',
                '#DF367C',
                '#883955',
                '#2f2504',
                '#594e36',
                '#542344',
                '#524948',
                '#57467b',
                '#cafe48',
                '#4c5b5c',
                '#e3655b',
                '#fde74c',
                '#03440c',
                '#5f0f40',
                '#9a031e',
                '#fb8b24',
                '#7f7f7f',
                '#d90368',
                '#0d1b2a',
                '#058ed9',
                '#157f1f',
                '#57467b',
                '#cafe48',
                '#4c5b5c',
                '#e3655b',
                '#4f3130',
                '#cafe48',
                '#4c5b5c',
                '#e3655b',
                '#fde74c',
                '#03440c',
                '#5f0f40',
                '#058ed9',
                '#157f1f',
                '#4f3130',
                '#cafe48',
                '#4c5b5c',
                '#e3655b',
                 '#4c5b5c',
                '#e3655b',
                '#4f3130',
                '#cafe48',
                '#4c5b5c',
                '#e3655b',
                 '#cafe48',
                '#4c5b5c',
                '#e3655b',
                 '#4c5b5c',
                '#e3655b',
                '#4f3130',";

?>

<script type="text/javascript">
	
 var chart_box_5 = document.getElementById("chart_5");

 var chart_5 = new Chart( chart_box_5 , {	
 		type: 'doughnut',
 		data: {
        labels: [ <?php echo $brand_str; ?> ],
        datasets: [{
            label: 'Brand',
            data: [ <?php echo $brand_sold_str; ?> ],
            backgroundColor: [
              <?php echo $set2_colors; ?>
            ],
            borderColor: [
                'rgb(255,255,255)',
            ],
            borderWidth: 0,
            hoverBorderWidth: 2
        }]
    },
   
   <?php 
   			echo $comman_sales_chart_info_2;
   ?>

 });

</script>

<script type="text/javascript">
	
 var chart_box_6 = document.getElementById("chart_6");

 var chart_6 = new Chart( chart_box_6 , {	
 		type: 'pie',
 		data: {
        labels: [ <?php echo $package_str; ?>],
        datasets: [{
            label: 'Package',
            data: [ <?php echo $package_sold_str; ?> ],
            backgroundColor: [
               <?php echo $set2_colors; ?>
            ],
            borderColor: [
                'rgb(255,255,255)',
            ],
            borderWidth: 0,
            hoverBorderWidth: 2
        }]
    },
   
   <?php 
   			echo $comman_sales_chart_info_2;
   ?>

 });

</script>

