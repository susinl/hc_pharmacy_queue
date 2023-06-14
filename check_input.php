<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>pre_id_input</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<!-- -->
<body>
	<?php
		require('header.html');
	?>
	<div class="w3-container">
		<div class="w3-card-2 w3-section" style="width:75%; margin:auto">
			<div class="w3-container w3-border-bottom">
				<h1 class="w3-center">
					ตรวจสอบสถานะใบยา
				</h1>
			</div>
			<div class="w3-container">
				<?php
					require('source/warning_pre_id.php');
				?>
				<form class="w3-container" method="get" action="check_report.php">

					<h3>รหัสใบยา</h3>
					<input class="w3-input w3-large" type="text" name="pre_id" placeholder="Scan the barcode" id="pre_id" required>

					<p><input class="w3-button w3-blue w3-xlarge" type="submit" value="Submit">
					<input class="w3-button w3-xlarge" type="reset" value="Clear"></p>
				</form>
			</div>
		</div>
	</div>
</body>
<!--set focus on the input-->
<script>
  document.getElementById('pre_id').focus();
</script>

</html>