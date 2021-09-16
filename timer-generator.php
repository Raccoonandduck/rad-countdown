<?php

$time_left = strtotime($countdown_params['end']) - time();



// $days = intdiv($time_left,3600*24);
// $hours = intdiv($time_left%(3600*24))


$seconds = $time_left%60;
$minutes = intdiv($time_left, 60) % 60;
$hours = intdiv($time_left, 3600) % 24;
$days = intdiv($time_left, 3600*24);
;?>

<?=strtotime($countdown_params['end']);?>

<div data-end="<?=strtotime($countdown_params['end']);?>" class='rad-countdown'>
	<span class='days'><?=$days;?></span>
	<span class='hours'><?=$hours;?></span>
	<span class='minutes'><?=$minutes;?></span>
	<span class='seconds'><?=$seconds;?></span>
</div>






<script>
//!DSGN! неплохо было бы отказаться от jquery
(function($){
	let $countdown = $('.rad-countdown');


	setInterval(countdown_work,1000);
	


	function countdown_work(){
		$countdown.each(function(){
			let end = $(this).data('end');
			let time_left = end - Math.floor((new Date())/1000);

			let seconds = time_left%60;
			let minutes = Math.floor(time_left / 60) % 60;
			let hours = Math.floor(time_left / 3600) % 24;
			let days = Math.floor(time_left / 86400);

			$(this).find('.days').html(String(days).padStart(2,0));
			$(this).find('.hours').html(String(hours).padStart(2,0));
			$(this).find('.minutes').html(String(minutes).padStart(2,0));
			$(this).find('.seconds').html(String(seconds).padStart(2,0));
		})
	}





	countdown_work();
})(jQuery);
</script>