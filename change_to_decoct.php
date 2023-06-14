<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Decoct self-decoct prescription</title>
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
					<i class="fa fa-thermometer-quarter w3-font-red" aria-hidden="true"></i>&nbsp;ต้มยาจัด
				</h1>
			</div>
			<div class="w3-container">
			<?php require('source/warning_pre_id.php'); ?>
			<form class="w3-container" method="get" action="change_to_decoct_handler.php">
				<h3>รหัสใบยา (处方代码)</h3>
			 	<input class="w3-input w3-large" type="text" name="pre_id" required placeholder="Scan the barcode" id="pre_id" require>
			 	<p><input class="w3-button w3-red w3-xlarge" type="submit" value="Submit (提交)">
				<input class="w3-button w3-xlarge" type="reset" value="Clear (删除)"></p>
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