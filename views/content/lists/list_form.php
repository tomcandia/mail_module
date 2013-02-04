<div class="admin-box">
	<h3><?php echo $title;?></h3>
    <?php echo form_open(current_url(),'class="form-horizontal"');?>
    <div class="control-group">
    	<label>Nombre de la lista</label>
        <div class="controls">
        	<input type="text" name="name" class="input-xxlarge" id="name" value="<?php echo isset($list) ? $list->name : set_value('name'); ?>" />
        </div>
    </div>
    <div class="control-group">
    	<label>Descripcion</label>
        <div class="controls">
        	<input type="text" name="descr" class="input-xxlarge" value="<?php echo isset($list) ? $list->description : set_value('descr');?>" />
        </div>
    </div>
    <input type="hidden" name="user" value="<?php echo $this->auth->user_id();?>" />
    <?php if(isset($list)){?>
    <input type="hidden" name="author_user" value="<?php echo $list->user?>" />
    <?php } ?>
    <div class="form-actions">
    	<input type="submit" name="save" value="Guardar" class="btn btn-primary"/>
    </div>
    <?php echo form_close();?>
</div>