<h2><?php echo $post['title']; ?></h2>
<small class="post-date">发布于: <?php echo $post['created_at']; ?></small><br>
<img src="<?php echo site_url(); ?>assets/images/posts/<?php echo $post['post_image']; ?>">
<div class="post-body">
	<?php echo $post['body']; ?>
</div>

<?php if($this->session->userdata('user')['id'] == $post['user_id']): ?>
	<hr>
	<a class="btn btn-default pull-left" href="<?php echo base_url(); ?>posts/edit/<?php echo $post['slug']; ?>">Edit</a>
	<?php echo form_open('/posts/delete/'.$post['id']); ?>
		<input type="submit" value="Delete" class="btn btn-danger">
	</form>
<?php endif; ?>
<hr>
<h3>评论</h3>
<?php if($comments) : ?>
	<?php foreach($comments as $comment) : ?>
		<div class="well">
			<h5><?php echo $comment['body']; ?> [by <strong><?php echo $comment['name']; ?></strong>]</h5>
		</div>
	<?php endforeach; ?>
<?php else : ?>
	<p>没有评论，快来发布第一条评论吧</p>
<?php endif; ?>
<hr>
<h3>添加评论</h3>
<?php echo validation_errors(); ?>
<?php if(!$this->session->userdata('user')) : ?>
    <li><a href="<?php echo base_url(); ?>users/login">登录</a></li>
    <li><a href="<?php echo base_url(); ?>users/register">注册</a></li>
<?php endif; ?>
<?php if($this->session->userdata('user')) : ?>
    <?php echo form_open('comments/create/'.$post['id']); ?>
	    <div class="form-group">
		    <label>内容</label>
		    <textarea name="body" class="form-control"></textarea>
	    </div>
	<input type="hidden" name="slug" value="<?php echo $post['slug']; ?>">
	<button class="btn btn-primary" type="submit">提交</button>
	</form>
<?php endif; ?>
