<?php echo form_open(current_url());?>
<div class="admin-box" style="max-height:500px">

    <table class="table table-stripped">
    <tr>
    <?php
	$i = 0;
    foreach($import[0] as $fields)
    {
		echo '<th>'.$fields;
				?>
                <select name="<?php echo 'column'.$i;?>">
                	<option value="0">No importar</option>
                    <option value="1">Importar como 'Email'</option>
                    <option value="2">Importar como 'Nombre'</option>
                </select>
                <?php
				echo '</th>';
			$i++;
			
	}?>
    </tr>
    <?php
	foreach($import[1] as $ids)
	{
		echo '<tr>';
		foreach($ids as $id => $value)
		{
			echo '<td>'.$value.'</td>';
		}
		echo '</tr>';
	}    
    ?>
    </table>
    </div>
    <div class="admin-box form-actions" style="min-height:0px !important">
    <input type="hidden" name="column_num" value="<?php echo $i - 1;?>" />
    <input type="hidden" name="importFile" value="<?php echo $file;?>" />
    <input type="submit" name="import_list" value="Continuar" class="btn btn-primary" />
    </div>
    <?php echo form_close();?>
