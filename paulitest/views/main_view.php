<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Pauli Test (Boongan)</title>

		<link rel="stylesheet" media="all" href="<?php echo base_url()?>paulitest/views/styles/style.css" type="text/css" />
		<script type="text/javascript" src="<?php echo base_url()?>paulitest/views/scripts/jquery-1.4.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>paulitest/views/scripts/general-script.js">
		</script>
		
    </head>
    <body>
		<div class="intro" >
			Penting! Sila baca <a href="http://sangprabo.blogspot.com/2011/02/pauli-test-boongan.html" target="_blank">petunjuk</a> dulu!<br />
			<button id="buttonStart">Saya ingin langsung mulai</button><br />
		</div>
		<div id="popup-background" ></div>
		<div class="container" >
			<div class="header" >
				<h1>Pauli Test Boongan</h1>
				<!-- why does this not work in Chrome?? -->
				<noscript style="margin: 0 auto;display:block;font-size:30px;">Hidupkan javascript</noscript>
			</div>

			<div class="clear">
			</div>

			<div class="statusbar" >
				Sisa waktu : <span id="timeIndicator" ></span> detik
			</div>
			
			<div class="numbers" >
				<form action="<?php echo site_url().'/main/result'?>" method="POST" id="form">
					<input type="hidden" name="numberAnsweredPerInterval" id="numberAnsweredPerInterval" value="" />
					<input type="hidden" name="questionId" value="<?php echo $questionId?>" />
				<?php
				
				$questions = '';

				for ($i=0;$i<$max_cols;$i++):?>
				<div class="questions" >
					<?php
					for ($j=0;$j<$max_rows;$j++){
						$number = rand(0, 9);
						echo $number;
						$questions .= $number;
						echo "<br />";
					}
					?>
				</div><!-- end of class questions -->
				<div class="answers">
					<?php
					for ($j=0;$j<$max_rows-1;$j++){
						echo '<input type="text" id="answers" name="answers[]" maxlength="1" disabled />';
						echo "<br />";
					}
					?>
				</div><!-- end of class answers -->
				<?php endfor;?>

				<?php $this->session->set_userdata('questions', $questions);?>
				<div class="clear" ></div>
				</form>
			</div><!-- end of class numbers -->
			
		</div>
		
    </body>
</html>
