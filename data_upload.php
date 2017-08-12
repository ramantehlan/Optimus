<script type="text/javascript" src="assets/script/data_upload.js"></script>

<style type="text/css">
				
				html{background-color:#0161A0;
					 color:#ffffff;
				}

			</style>

			<div class="optimus_in_app">
					<img src="assets/image/18134461ca57c4513277c0a134274dae.jpg">
			</div>	

<div class="welcome_heading effect_top_1">
Data Upload
</div>
<div class="welcome_body effect_top_1" style="border-bottom:0px;">
Let me talk to Data and I can even know <br>if you have introduced a new product.
</div>

<div class="upload_box">
		<div id="progress_bar">
				<div class="progress-label">0% uploaded</div>
		</div>

		<div class="upload_box_heading">
				Upload upto 128Mb CSV file!
		</div>
		<div class="upload_box_body">

				<form method="post" enctype="multipart/form-data" action="data_upload.action.php" id="submit_data_form">

						<input type="retailer_id" name="retailer_id" id="retailer_id" class="input" placeholder="Retailer Id">

						<input type="file" name="data_file" id="data_file" class="input">

						<input type="submit" class="submit_button" id="submit_data" value="SUBMIT">

			</form>
		

		</div>
</div>

<div class="error_box">
		ERROR
	</div>

<div class="success_box">
	Successfully uploaded
</div>