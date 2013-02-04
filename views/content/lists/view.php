<h1>Lista <a><?php echo $list->name?></a></h1>
<div class="admin-box" style="max-height:600px">
	<?php echo form_open(current_url());?>
    <table class="table table-stripped">
    	<tr>
        	<th class="column-check"><input type="checkbox" class="check-all" /></th>
        	<th>Nombre</th>
            <th>Email</th>
            <th>Inscripción</th> 
        </tr>
        <?php
		foreach($txs as $tx)
		{
			$mail = $this->mail_model->find($tx->object_id);
			$id = crypt_encode($mail->mail_id);
			echo 	'<tr><td><input type="checkbox" name="checked[]" value="'.$id.'" /></td>
					<td>'.$mail->nombre.'</td>
					<td>'.$mail->email.'</td>
					<td>'.$mail->created_on.'</td></tr>';
		}
		?>
	</table>
    <div class="form-actions">
    	<input type="submit" name="deleteFromList" class="btn btn-danger" value="Borrar de la Lista" />
    </div>
    <?php echo form_close();?>	
</div>