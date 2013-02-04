<div class="admin-box">
	<h3><?php echo $title;?></h3>
    <?php echo form_open(current_url(),'class="form-horizontal"');?>
    <div class="control-group">
    	<label>Nombre del Template</label>
        <div class="controls">
        	<input type="text" name="name" class="input-xxlarge" value="<?php echo isset($template) ? $template->name : set_value('name'); ?>" /><br>
            <?php if (form_error('name')) echo '<span class="help-inline">'. form_error('name') .'</span>'; ?>
        </div>
    </div>
    <div class="control-group">
    	<label>Descripcion</label>
        <div class="controls">
        	<input type="text" name="descr" class="input-xxlarge" value="<?php echo isset($template) ? $template->description : set_value('description') ?>" /><br>
            <?php if (form_error('descr')) echo '<span class="help-inline">'. form_error('descr') .'</span>'; ?>
        </div>
    </div>
    <div class="control-group">
    	<label>Asunto</label>
        <div class="controls">
        	<input type="text" name="subject" class="input-xxlarge" value="<?php echo isset($template) ? $template->subject : set_value('subject') ?>" /><br>
            <?php if (form_error('subject')) echo '<span class="help-inline">'. form_error('subject') .'</span>'; ?>
        </div>
    </div>
    <div class="control-group">
    	<label>Mensaje</label>
        <div class="controls">
        	<textarea name="message" class="ckeditor input-xxlarge"><?php echo isset($template) ? $template->message : set_value('message');?></textarea><br>
            <?php if (form_error('message')) echo '<span class="help-inline">'. form_error('message') .'</span>'; ?>
        </div>
    </div>
    <input type="hidden" name="user" value="<?php echo $this->auth->user_id();?>" />
    <?php if(isset($template)){?>
    <input type="hidden" name="author_user" value="<?php echo $template->user?>" />
    <?php } ?>
    <div class="form-actions">
    	<input type="submit" name="save" value="Guardar" class="btn btn-primary"/>
    </div>
    <?php echo form_close();?>
</div>