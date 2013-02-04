<div class="admin-box">
<h3>Template Mail</h3>
<?php echo form_open(current_url());?>
<table class="table table-stripped">
	<tr>
    	<th class="column-check"><input class="check-all" type="checkbox" /></th>
    	<th>Nombre</th>
        <th>Descripcion</th>
        <th>Estado</th>
        <th>Creado en</th>
        <th>por</th>
        <th>Modificado en</th>
        <th>por</th>
        <th></th>
    </tr>
    <?php
	foreach($templates as $template)
	{
		$id = crypt_encode($template->mail_template_id);
		echo '<tr><td><input type="checkbox" name="checked[]" value="'.$id.'" /></td>';
		echo '<td>'.anchor(SITE_AREA.'/content/mail/template/edit/'.$id,$template->name).'</td>';
		echo '<td>'.$template->description.'</td>';
		echo '<td>';
		if($template->active == 1) echo anchor(SITE_AREA.'/content/mail/template/deactivate/'.$id,'Activo','class="label label-success"'); else echo anchor(SITE_AREA.'/content/mail/template/activate/'.$id,'Inactivo','class="label label-warning"');
		echo '</td>';
		echo '<td>'.$template->created_on.'</td>';
		$user = $this->user_model->find($template->user);
		echo '<td>'.$user->username.'</td>';
		
		if($template->user_modify != null && $template->modified_on != null) {
			$user_modify = $this->user_model->find($template->user_modify);
			$by = $user_modify->username;
			$on = $template->modified_on;
		} else {
			$on = '-';
			$by = '-';
		}
		
		echo '<td>'.$on.'</td>';
		echo '<td>'.$by.'</td>';
		echo '<td>'.anchor(SITE_AREA.'/content/mail/template/stats/'.$id,'Estadísticas').'</td>';
		echo'</tr>';
	}
	?>
</table>
<div class="form-actions">
	<input class="btn btn-danger" type="submit" name="delete" value="Borrar" onclick="return confirm('¿Estas seguro?')" />
</div>
<?php echo form_close();?>
</div>