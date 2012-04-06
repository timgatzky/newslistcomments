
<div class="layout_latest layout_newslistcomments block<?php echo $this->class; ?>">

<?php if ($this->hasMetaFields): ?>
<p class="info"><?php echo $this->date; ?> <?php echo $this->author; ?> <?php echo $this->commentCount; ?></p>
<?php endif; ?>

<?php if ($this->addImage): ?>
<div class="image_container<?php echo $this->floatClass; ?>"<?php if ($this->margin || $this->float): ?> style="<?php echo trim($this->margin . $this->float); ?>"<?php endif; ?>>
<?php if ($this->href): ?>
<a href="<?php echo $this->href; ?>"<?php echo $this->attributes; ?> title="<?php echo $this->alt; ?>">
<?php endif; ?>
<img src="<?php echo $this->src; ?>"<?php echo $this->imgSize; ?> alt="<?php echo $this->alt; ?>" />
<?php if ($this->href): ?>
</a>
<?php endif; ?>
<?php if ($this->caption): ?>
<div class="caption"><?php echo $this->caption; ?></div>
<?php endif; ?>
</div>
<?php endif; ?>

<h2><?php echo $this->text ? $this->linkHeadline : $this->newsHeadline; ?></h2>
<p class="teaser"><?php echo $this->teaser; ?></p>

<?php if ($this->text): ?>
<p class="more"><?php echo $this->more; ?></p>
<?php endif; ?>

<!-- comments block // start -->
<?php if($this->limit == 0) $this->limit = $this->total; ?>
<?php if($this->comments): ?>
<div class="commentslist block" id="commentslist<?php echo $this->id; ?>">
<div class="commentshead"><span class="new_comment" style="cursor:pointer;" onclick="">Kommentieren</span></div>
<?php for($i = 0; $i < $this->limit; $i++): ?>
<?php $comment = $this->comments[$i]; if(!$comment) continue; ?>
<div class="comment <?php echo $class; ?> item<?php echo $i+1; ?>">
	<div class="info">
		<span class="name"><?php echo $comment['name']; ?></span>
		<?php if($comment['website']): ?><a href="<?php echo $comment['website']; ?>" class="website"><?php echo $comment['website']; ?></a><?php endif; ?>
	</div>
	<div class="text"><?php echo $comment['comment']; ?></div>
	<div class="timestamp"><span class="time"><?php echo $comment['time']; ?></span>&nbsp;&middot;&nbsp;<span class="time"><?php echo $comment['time_elapsed']; ?></span></div>
	<?php if($comment['remove_link']): ?><div class="remove"><a href="<?php echo $comment['remove_link']; ?>"><?php echo $GLOBALS['TL_LANG']['newslistcomments']['delete']; ?></a><span class="time_remaining">(<?php echo $comment['time_remaining']; ?>)</span></div><?php endif; ?>
</div>
<?php endfor; ?>

<?php if($this->limit != 0 && $this->limit < $this->total): ?>
<!-- comments accordion // start -->
<div class="ce_accordion ce_newscomments_accordion">
<div class="newscomments_toggler" style="cursor:pointer;">Alle <?php echo $this->total; ?> Kommentare anzeigen</div>
<div class="newscomments_accordion">
	<?php for($i = $this->limit; $i <= $this->total; $i++): ?>
	<?php $comment = $this->comments[$i]; if(!$comment) continue; ?>
	<div class="comment <?php echo $class; ?> item<?php echo $i+1; ?>">
		<div class="info">
			<span class="name"><?php echo $comment['name']; ?></span>
			<?php if($comment['website']): ?><a href="<?php echo $comment['website']; ?>" class="website"><?php echo $comment['website']; ?></a><?php endif; ?>
		</div>
		<div class="text"><?php echo $comment['comment']; ?></div>
		<div class="timestamp"><span class="time"><?php echo $comment['time']; ?></span>&nbsp;&middot;&nbsp;<span class="time"><?php echo $comment['time_elapsed']; ?></span></div>
		<?php if($comment['remove_link']): ?><div class="remove"><a href="<?php echo $comment['remove_link']; ?>"><?php echo $GLOBALS['TL_LANG']['newslistcomments']['delete']; ?></a><span class="time_remaining">(<?php echo $comment['time_remaining']; ?>)</span></div><?php endif; ?>
	</div>
	<?php endfor; ?>
</div>
</div>
<!-- comments accordion // end -->
<?php endif; ?>
<!-- comments block // end -->
<?php endif; ?>

<?php if( ($this->allowComments && $this->loggedIn) || $this->allowAll ): ?>
<!-- comments form // start -->
<!-- indexer::stop -->
<div class="form form_newscomments">
<form action="<?php echo $this->Environment->request; ?>" id="<?php echo 'com_form_newscomment' . $this->id; ?>" name="<?php echo 'com_form_newscomment' . $this->id; ?>" method="post">
<div class="formbody">
<input type="hidden" name="FORM_SUBMIT" value="<?php echo 'com_form_newscomment' . $this->id; ?>" />
<span class="widget">
	<input type="text" class="text" value="<?php echo $GLOBALS['TL_LANG']['newslistcomments']['comment_default']; ?>" name="NEW_COMMENT" />
</span>
<span class="submit_container">
  <input type="submit" onclick="" class="submit" name="<?php echo $GLOBALS['TL_LANG']['newslistcomments']['submit']; ?>" value="<?php echo $GLOBALS['TL_LANG']['newslistcomments']['submit']; ?>" />
</span>
</div>
</form>
</div>
<!-- indexer::continue -->
<!-- comments form // end -->
<?php endif;?>

</div><!-- comments blocks // end -->

</div>
