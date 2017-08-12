<div class="menu">
		<a href="index.php">
		<div class='logo'>
				Optimus
		</div>
		</a>

		<div class="options_holder">
				<a href="app?page=dashboard" class='options_a'>
					<div class='option <?php if($page == "dashboard"){echo "selected_option";} ?>'>
							<div class='option_img'>
								<img src="assets/image/dashboard(2).png">
							</div>
							Dashboard
					</div>
				</a>

				<a href="app?page=analysis" class='options_a'>
					<div class='option <?php if($page == "analysis"){echo "selected_option";} ?>'>
							<div class='option_img'>
								<img src="assets/image/analytics.png">
							</div>
							Analysis
					</div>
				</a>

				<a href="app?page=data_upload" class='options_a'>
					<div class='option <?php if($page == "data_upload"){echo "selected_option";} ?>'>
							<div class='option_img'>
								<img src="assets/image/outbox.png">
							</div>
							Data Upload
					</div>
				</a>

				<a href="app?page=image_upload" class='options_a'>
					<div class='option <?php if($page == "image_upload"){echo "selected_option";} ?>'>
							<div class='option_img'>
								<img src="assets/image/image(1).png">
							</div>
							SKU Upload
					</div>
				</a>
		</div>
</div>

