<?php 
/***********************************
This is a investment simulator 
and it will use data of one year ago 
to find out the best strategy to invest 

creator:- Raman Tehlan 
Date of creation:- 05/02/2017
***********************************/

//this is to connect to database
include "connect.inc.php";

$investment = $_POST['investment'];
$brand 		= $_POST['brand'];


/***********************************
end result will be 

ranking out of 100
compare things 

1) how much more or less is no from average 

2) what is it in percentage difference

3) if expect_type is more but it it less 
	then make it negative

4) same as 3 but for positive
*************************************/

function compare_rate($avg , $no2 , $expect_type){

		//to store
		$rate = 0;
		$total = 0;

		if($avg > $no2){
			$rate = $avg - $no2;
			$total = $avg + $no2;

			$rate = ($rate / $total) * 100;

			if($expect_type == "more"){
				//make this rate a negative
				$rate = 100 - $rate;
			}

		}else if($no2 > $avg){
			$rate = $no2 - $avg;
			$total = $avg + $no2;

			$rate = ($rate / $total) * 100;

			if($expect_type == "less"){
				//make this rate a negative
				$rate = 100 - $rate;
			}

		}else{
			$rate = 100;
		}

		return round($rate);
}

/*************************************
step 1) find the average of following

population 
per capita income 
state gdp
labour force
unemployment rate in city
**************************************/

echo "SELECT avg(resident_populartion_in_city) as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' and (`date` = '%%/%%/2016' or `date` = '%/%/2016') ";


 $population_average_code 			= mysqli_query($connect , "SELECT avg(resident_populartion_in_city) as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' and (`date` = '%%/%%/2016' or `date` = '%/%/2016') ");
 $per_capita_income_average_code 	= mysqli_query($connect , "SELECT avg(per_capita_personal_income_in_city) as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");
 $state_gdp_average_code			= mysqli_query($connect , "SELECT avg(per_capita_personal_income_in_city) as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");
 $labour_force_average_code 		= mysqli_query($connect , "SELECT avg(labor_force_in_city) as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");
 $unemployment_average_code 		= mysqli_query($connect , "SELECT avg(unemployment_rate_in_city) as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");

 $population_average_array 			= mysqli_fetch_array($population_average_code);
 $per_capita_income_average_array 	= mysqli_fetch_array($per_capita_income_average_code);
 $state_gdp_average_array 			= mysqli_fetch_array($state_gdp_average_code);
 $labour_force_average_array 		= mysqli_fetch_array($labour_force_average_code);
 $unemployment_average_array 		= mysqli_fetch_array($population_average_code);

 $population_average 			=  $population_average_array['total'];
 $per_capita_income_average 	=  $per_capita_income_average_array['total'];
 $state_gdp_average 			=  $state_gdp_average_array['total'];
 $labour_force_average 			=  $labour_force_average_array['total'];
 $unemployment_average 			=  $unemployment_average_array['total'];



/************************************
step 2) Find the actual value of brand
*************************************/

 $population_code 			= mysqli_query($connect , "SELECT resident_populartion_in_city as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");
 $per_capita_income_code 	= mysqli_query($connect , "SELECT per_capita_personal_income_in_city as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");
 $state_gdp_code			= mysqli_query($connect , "SELECT per_capita_personal_income_in_city as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");
 $labour_force_code 		= mysqli_query($connect , "SELECT labor_force_in_city as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");
 $unemployment_code 		= mysqli_query($connect , "SELECT unemployment_rate_in_city as 'total' FROM `$db_name`.`$table_name` WHERE `brewer_value` = 'ABI' and `brand_value` = '$brand' ");

 $population_array 			= mysqli_fetch_array($population_code);
 $per_capita_income_array 	= mysqli_fetch_array($per_capita_income_code);
 $state_gdp_array 			= mysqli_fetch_array($state_gdp_code);
 $labour_force_array 		= mysqli_fetch_array($labour_force_code);
 $unemployment_array 		= mysqli_fetch_array($population_code);

 $population 			=  $population_array['total'];
 $per_capita_income 	=  $per_capita_income_array['total'];
 $state_gdp 			=  $state_gdp_array['total'];
 $labour_force			=  $labour_force_array['total'];
 $unemployment 			=  $unemployment_array['total'];

/************************************
step 3)

this is to rates
*************************************/

$rate1 = compare_rate( $population_average ,  $population , "more");
$rate2 = compare_rate( $per_capita_income_average ,  $per_capita_income , "more");
$rate3 = compare_rate( $state_gdp_average ,  $state_gdp , "more");
$rate4 = compare_rate( $labour_force_average ,   $labour_force , "more");
$rate5 = compare_rate( $unemployment_average ,   $unemployment , "less");

$total_rate = $rate1 + $rate2 + $rate3 + $rate4 + $rate5;
$average = 100 - (($total_rate / 500) * 100);

echo "<div class='rating'>Rating: $average/100</div>";

?>