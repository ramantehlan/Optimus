<?php 
/***************************************************
This script is to upload data from a csv file to 
mysql database

creator:- Raman Tehlan
date of creation:- 04/02/2017
****************************************************/

				//this is to connect to database
				//we include it
				include "connect.inc.php";

// check if all post are set
if(isset($_POST['retailer_id']) && isset($_FILES['data_file'])){
	//check if file temp_name is there
	if($_FILES['data_file']['tmp_name']){
		
		$retailer_id	= $_POST['retailer_id'];
		$file_tmp_name = $_FILES['data_file']['tmp_name'];


		//this is main details of data
		$main_code = "INSERT INTO `$db_name`.`$table_name` (
									`Id`, 
									`retailer_id`, 
									`product`, 
									`brewer_value`, 
									`brand_value`,
									`package_value`, 
									`segment_value`, 
									`ab_segment_value`, 
									`ab_subsegment_value`, 
									`ab_magasegmen_value`, 
									`date`, 
									`display_count`, 
									`display_share`, 
									`distribution`, 
									`feature_count`,
									`feature_share`, 
									`price_per_unit`, 
									`price_per_volume`, 
									`unit_sales`, 
									`volume_sales`, 
									`volume_share_of_category`, 
									`average_of_max_temperature`, 
									`average_of_mean_temperature`, 
									`average_of_min_temperature`, 
									`average_of_dew_point`, 
									`average_of_mean_dew_point`, 
									`average_of_min_dewpoint`, 
									`average_of_max_humidity`, 
									`average_of_mean_humidity`, 
									`average_of_min_humidity`, 
									`average_of_max_sea_level_pressure`, 
									`average_of_mean_sea_level_pressure`, 
									`average_of_min_sea_level_pressure`, 
									`average_of_max_visibility`, 
									`average_of_mean_visibility`, 
									`average_of_min_visibility`, 
									`average_of_max_wind_speed`, 
									`average_of_mean_wind_speed`,
									`average_of_max_gust_speed`, 
									`average_of_precipitation`, 
									`average_of_cloud_cover`, 
									`average_of_wind_dir_degrees`, 
									`state_gdp`, 
									`alcohol_retail_trade_employees`, 
									`state_personal_income`, 
									`resident_populartion_in_city`, 
									`per_capita_personal_income_in_city`, 
									`occupancy`, 
									`labor_force_in_city`, 
									`employment_in_city`, 
									`unemployment_in_city`, 
									`unemployment_rate_in_city`, 
									`consumer_price_index_melt_beverages`, 
									`consumer_price_index_wine`, 
									`producer_price_index_by_industry` ,
									`date_of_upload`
				) VALUES ( NULL , '$retailer_id', ";
		
				//this 
				$code	= "";



						//to count the row
						$row = 1;
						if( ($handle = fopen($file_tmp_name , "r")) != FALSE){

							while( ($info = fgetcsv($handle , 100000 , ",")) != FALSE ) {
										
									
							  //skip this for first row
							  if($row != 1){
							  		//count number of coloums are there
									$num_c = count($info);
									//store values in an order or row
									$mini_code = "";

										for($c = 0; $c < $num_c; $c++){
											$mini_code .= "'" . $info[$c] . "' ,";
										}

									$code = $main_code . $mini_code . " CURRENT_TIMESTAMP );";


									mysqli_query($connect , $code);

								}
								$row++;
							}

						}


				//to remove comma from string end
				//$code = rtrim($code , ",") . ";";



			echo "Successfully uploaded";
	

	}
	else{
		echo "ERROR- No File Exist";
	}

}
else{
// if a post is not set then send error that work not done
echo "ERROR- Broken information";
}

?>
