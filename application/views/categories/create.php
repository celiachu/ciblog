<h2><?= $title ;?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('categories/create'); ?>
	<div class="form-group">
		<label>名字</label>
		<input type="text" class="form-control" name="name" placeholder="Enter name">
	</div>
	<button type="submit" class="btn btn-default">提交</button>
</form>