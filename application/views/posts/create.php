<h2><?= $title; ?></h2>

<?php echo validation_errors(); ?>

<?php echo form_open_multipart('posts/create'); ?>
  <div class="form-group">
    <label>标题</label>
    <input type="text" class="form-control" name="title" placeholder="输入标题">
  </div>
  <div class="form-group">
    <label>内容</label>
    <textarea id="editor1" class="form-control" name="body" placeholder="Add Body"></textarea>
  </div>
  <div class="form-group">
	  <label>选择分类</label>
	  <select name="category_id" class="form-control">
		  <?php foreach($categories as $category): ?>
		  	<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
		  <?php endforeach; ?>
	  </select>
  </div>
  <div class="form-group">
	  <label>上传图片</label>
	  <input type="file" name="userfile" size="20">
  </div>
  <button type="submit" class="btn btn-default">提交</button>
</form>