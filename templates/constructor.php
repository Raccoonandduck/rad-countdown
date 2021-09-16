<form method="POST">

<input type="hidden" name="action" value="create-rad-countdown">

<br><br>

<span class='sub-title'>Choose timer date end.</span>
<input type="date" name="date-end" value="<?=explode(' ',$countdown_data['end'])[0];?>">

<br><br>

<span class='sub-title'>Choose timer time end.</span>
<input type="time" name="time-end" value="<?=explode(' ',$countdown_data['end'])[1];?>">

<br><br>

<button type='submit'>
	Submit
</button>

</form>





<style>
	input{
		display: block;
	}
</style>