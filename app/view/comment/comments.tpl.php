<article class='article2'>
	<?php if (is_array($comments)) : ?>
    <a href="<?=$this->url->create("comments/empty/{$pageId}")?>">Ta bort alla</a>
	<div class='comments'>
		<?php foreach ($comments as $comment) : ?>
		<div class='comment'>
			<div class='comment_id'><a href='<?=$this->url->create("comments/edit/{$comment->page}/{$comment->id}")?>'>(#<?=$comment->id?>)</a></div>
			<div class='comment_body'>
				<p><span class='name'><?=$comment->name?></p>
				<p><span class='content'><?=$comment->data?></p>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</article>