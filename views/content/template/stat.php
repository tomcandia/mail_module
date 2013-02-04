<?php
$mail = NULL;
$track_unique = 0;
$track_all = 0;
foreach($tracks as $track)
{
	if($mail != $track->mail_id)
	{
		$track_unique++;
		$mail = $track->mail_id;
	}
	$track_all++;
	$last = $track->timestamp;
}
?>
<h1>Estadísticas para <a><?php echo $template->name?></a></h1>
<div class="form-horizontal">
    <div class="admin-box">
        <div class="control-group">
            <label>Total Enviados</label>
            <div class="controls">
            	<h1><?php echo $send->object_id ?></h1>
            </div>
        </div>
        <div class="control-group">
        	<label>Aperturas Únicas</label>
            <div class="controls">
            	<h1><?php echo $track_unique ?></h1>
            </div>
        </div>
        <div class="control-group">
        	<label>Aperturas Totales</label>
            <div class="controls">
            	<h1><?php echo $track_all ?></h1>
            </div>
        </div>
        <div class="control-group">
        	<div class="controls">
            	<span>Ultima Apertura: <?php echo $last?> (GMT + 0:00)</span>
            </div>
        </div>
    </div>
</div>