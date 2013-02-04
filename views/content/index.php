<div class="admin-box" style="max-height:600px">
<h3>Mails Inscritos</h3>
<?php echo form_open(current_url());?>
<table class="table table-stripped">
	<tr>
    	<th class="column-check"><input class="check-all" type="checkbox" /></th>
    	<th>Nombre</th>
        <th>Email</th>
        <th>Inscripcion</th>
        <th>Listas</th>
    </tr>
    <?php
	foreach($mails as $mail)
	{
		echo '<tr><td><input type="checkbox" name="checked[]" value="'.$mail->mail_id.'" /></td>';
		echo '<td>'.$mail->nombre.'</td>';
		echo '<td>'.$mail->email.'</td>';
		echo '<td>'.$mail->created_on.'</td>';
		echo '<td>';
		$txs = $this->tx_model->where(array('taxonomy' => 'list', 'object_id' => $mail->mail_id))->find_all();
		if($txs !== false){
			$term_id = null;
			foreach($txs as $tx)
			{
				if($term_id !== $tx->term_id)
				{
					$term = $this->list_model->find($tx->term_id);
					echo $term->name;
				}
				$term_id = $tx->term_id;
			}
		} else {
			echo '-';
		}
		echo '<td></tr>';
	}
	?>
</table>
<div class="form-actions">
<input class="btn btn-danger" type="submit" name="delete" onclick="return confirm('Estas seguro')" value="Borrar">
<input class="btn btn-primary" type="submit" name="send" value="Enviar Mail" />
<label>Agregar a la Lista:</label>
<select name="addToList"
<?php if($lists !== false){ ?>
 onchange="this.form.submit();">
	<option value="none">Seleccionar Lista</option>
    <?php
	foreach($lists as $list){
		echo '<option value="'.$list->list_id.'">'.$list->name.'</option>';
	}
	?>
<?php } else { ?>
disabled ="disabled">
<option>No hay listas disponibles</option>
</select>
<?php } ?>
</div>
<?php echo form_close(); ?>
</div>
<div class="admin-box">
<?php echo form_open_multipart(current_url(),'class="form-horizontal"');?>
<h3>Importar inscritos desde archivo</h3>
<div class="form-actions">
<div class="controls"><input type="file" name="import" /></div>

<input type="submit" name="import" value="Importar" class="btn btn-primary" />
</div>
<?php echo form_close();?>
</div>