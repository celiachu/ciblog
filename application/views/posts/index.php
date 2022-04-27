<h2><?= $title ?></h2>
<?php foreach($posts as $post) : ?>
	<h3><?php echo $post['title']; ?></h3>
	<div class="row">
		<div class="col-md-3" style = "width:50px;height:50px">
			<img class="post-thumb" src="<?php echo site_url(); ?>assets/images/posts/<?php echo $post['post_image']; ?>">
		</div>
		<div class="col-md-9">
			<small class="post-date">发布于: <?php echo $post['created_at']; ?> 通过 <strong><?php echo $post['name']; ?></strong></small>
		<?php echo word_limiter($post['body'], 60); ?>
		<p><a class="btn btn-default" href="<?php $slug =urlencode($post['slug']);echo site_url('/posts/'.$slug); ?>">阅读全文</a></p>
		</div>
	</div>
<?php endforeach; ?>
<div class="pagination-links">
		<?php echo $this->pagination->create_links(); ?>
</div>