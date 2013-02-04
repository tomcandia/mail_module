<div class="admin-box">
	<h3>Listas</h3>
    <?php echo form_open(current_url());?>
	<table class="table table-stripped">
    	<tr>
        	<th class="column-check"><input class="check-all" type="checkbox" /></th>
        	<th>Nombre</th>
            <th>Descripcion</th>
            <th>Creado en</th>
            <th>por</th>
            <th>Modificado en</th>
            <th>por</th>
            <th>Inscritos</th>
            <th></th>
        </tr>
        <?php
		if($lists !== false) {
			foreach($lists as $list){
				
				$user = $this->user_model->find($list->user);
				$suscribed = $this->tx_model->where(array('taxonomy' => 'list','term_id' => $list->list_id))->count_all();
				if($list->user_modify != null) $user_modify = $this->user_model->find($list->user_modify);
				$by = isset($user_modify) ? $user_modify->username : '-';
				$on = isset($user_modify) ? $list->modified_on : '-';
				$id = crypt_encode($list->list_id);
				
				echo '<tr><td><input type="checkbox" name="checked[]" value="'.$id.'" /></td>
					<td>'.anchor(SITE_AREA.'/content/mail/lists/edit/'.$id,$list->name).'</td>
					<td>'.$list->description.'</td>
					<td>'.$list->created_on.'</td>
					<td>'.$user->username.'</td>
					<td>'.$on.'</td>
					<td>'.$by.'
					<td>'.$suscribed.'</td>
					<td>'.anchor(SITE_AREA.'/content/mail/lists/view/'.$id,'Ver Lista').'</td>';
			}
		}
		?>
    </table>
    <div class="form-actions">
    	<input class="btn btn-danger" type="submit" name="delete" value="Borrar" onclick="return confirm('¿Estas seguro?')" />
		<input class="btn btn-primary" type="submit" name="send" value="Enviar Mail" />
	</div>
    <?php echo form_close();?>
</div>