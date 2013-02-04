<h1>Formulario Inscripción</h1>
<?php echo form_open(current_url());?>
	<label>Nombre</label>
    <input type="text" name="nombre" /><?php if (form_error('nombre')) echo '<span class="help-inline">'. form_error('nombre') .'</span>'; ?><br>
    
    
    <label>Mail</label>
    <input type="text" name="mail" /><?php if (form_error('mail')) echo '<span class="help-inline">'. form_error('mail') .'</span>'; ?><br>
    
    
    <input type="submit" name="submit" value="Enviar" />

<?php echo form_close();?>