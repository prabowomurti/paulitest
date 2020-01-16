$(document).ready(function () {
	/*
	 * Munculkan pop up
	 */

	//var margintopintro = $(window).height()/2 - $('.intro').height()/2;
	var marginleftintro = $(window).width()/2 - $('.intro').width()/2;

	$('.intro').css({
		//'top' : margintopintro,
		'top' : '200px',
		'left' : marginleftintro
	}).show();

	/*
	 * Menghilangkan popup dan popup-background, memunculkan numbers, memulai timer
	 */
	$('#buttonStart').click(function () {
		$('.intro').hide();
		$('#popup-background').hide();
		$('.statusbar').show();
		$('.numbers').show();

		$('#form #answers').attr("disabled"); //agar menjawab secara urut
		$('#form #answers').eq(0).removeAttr("disabled").focus();
		timeStart();
	})

	/*
	 * Memindahkan focus cursor secara otomatis ke next input text setiap pengguna memasukkan 1 angka
	 */

	//apakah mungkin mengerjakan 720 isian dalam waktu 240 detik?
	var maxIndexOfAnswers = $('#form #answers').length -1;
	$('#form #answers').each(function (index) {
		$(this).keypress(function (e) {
			
			//taken from jquery Cookbook page 247
			// we want to ignore the following keys:
			// 9 Tab, 16 Shift, 17 Ctrl, 18 Alt, 19 Pause Break, 20 Caps Lock
			// 27 Esc, 33 Page Up, 34 Page Down, 35 End, 36 Home
			// 37 Left Arrow, 39 Right Arrow,
			// 45 Insert, 46 Forward Delete, 144 Num Lock, 145 Scroll Lock
			var ignoreKeyCodes = ',9,16,17,18,19,20,27,33,34,35,36,37,39,45,144,145,';

			if ( ignoreKeyCodes.indexOf(',' + e.keyCode + ',') > -1 ) {
				//do nothing
			}else if (e.keyCode >= 48 && e.keyCode <= 57) {
				if (index == maxIndexOfAnswers){
					//Mungkinkah selesai sampai di sini?
					alert("Entah Anda orang yang terlalu jenius ataukah terlalu curang");
					timePause();
					$(window).open('http://www.google.co.id/search?q=cara+menjadi+orang+jujur');
				}else {
					//go to the next input text
					$('#form #answers').eq(index+1).removeAttr("disabled").focus();
					//agar pengguna tidak dapat mengedit jawaban sebelumnya (?)
					$('#form #answers').eq(index).attr("readonly");

				}
			}
		})
	})

	/*
	 * Hanya mengizinkan numbers di input text
	 */
	$("#form #answers").bind('keypress', function (event){
		var keyCode = event.which;

		var numbers = ',0,1,2,3,4,5,6,7,8,9,';
		if (numbers.indexOf(',' + String.fromCharCode(keyCode) + ',') > -1) {
			return true;
		}else {
			return false;
		}
	})

	/*
	 * setting untuk simulasi test
	 */
	var time = 240;//4 menit
	var markTime = 40;//garis setiap 40 detik sekali

	var numberAnsweredPerInterval = 0;
	var lastPos = 0;
	var timeElapsed = 0;

	var myInterval;
	$('#timeIndicator').text(time);

	function timeStart() {
		myInterval = setInterval(function updateTimer() {
			//bikin lambat
			//$('#timeIndicator').text(time -1).animate({opacity : 1}).animate({opacity : 0.5});
			$('#timeIndicator').text(time -1);
			timeElapsed ++;
			time --;
			if (timeElapsed == markTime ){
				numberAnsweredPerInterval = $('#form #answers').filter('[value]').length - lastPos;
				lastPos = $('#form #answers').filter('[value]').length;

				$('#numberAnsweredPerInterval').attr('value', $('#numberAnsweredPerInterval').val() + numberAnsweredPerInterval + ',');
				timeElapsed = 0;
				
			}

			if (time == 0) {
				timeStop();
			}
		}, 1000);//update timer every 1 second

	}

	//dev purpose only
	function timePause() {
		clearInterval(myInterval);
	}

	function timeStop() {
		//stop updateTimer dan mengirim data
		clearInterval(myInterval);
		$('#form').submit();
	}



})