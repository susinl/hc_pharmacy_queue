<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>edit_prediction</title>
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
					<i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;ปรับเปลี่ยนสมการ (修改时间方程)
				</h1>
			</div>
		<div class="w3-container">
			<?php
				//require('source/warning_pre_id.php');
				require('source/warning_login.php');
			?>
		
			<form class="w3-container" method="get" action="edit_prediction_handler.php">
				<h3>ID</h3>
			 	<input class="w3-input w3-large" type="text" name="Username" required placeholder="Username" id="Username" require>
				<h3>password</h3>
				<input class="w3-input w3-large" type="text" name="Password" required placeholder="Password" id="Password" require>
			 	<p><input class="w3-button w3-green w3-xlarge" type="submit" value="Submit (提交)">
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