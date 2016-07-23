<?php echo $this->element('topbar', array()); ?>
<div style="min-height:700px;padding:15px;">
	<div class="show-for-medium-only">&nbsp;</div>
	<?php echo $this->element('channel', array()); ?>
	<div class="small-12 columns">
		<h3 class="show-for-large-up"><?php echo $video['items'][0]['snippet']['title']; ?></h3>
		<h4 class="show-for-medium-only"><?php echo $video['items'][0]['snippet']['title']; ?></h4>
		<h5 class="show-for-small-only"><?php echo $video['items'][0]['snippet']['title']; ?></h5>
	</div>
	<div class="small-12 large-2 columns show-for-large-up">
		<h6>Author</h6>
		<p><?php echo $video['items'][0]['snippet']['channelTitle']; ?></p>
		<h6>Published</h6>
		<p><?php echo date("m/d/Y", strtotime($video['items'][0]['snippet']['publishedAt'])); ?></p>
		<h6>Tags</h6>
		<div class="panel"></div>
	</div>
	<div class="small-12 large-7 columns">
		<div class="youtube-wrapper">
			<iframe src="//www.youtube.com/embed/<?php echo $video['items'][0]['id']; ?>?rel=0" width="560" height="315" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		</div>
		<div class="small-6 medium-3 columns"><a href="#" class="button radius small-12 tiny secondary"><i class="fi-like fi-small"></i><br />Like</a></div>
		<div class="small-6 medium-3 columns"><a href="#" class="button radius small-12 tiny secondary"><i class="fi-page-add fi-small"></i><br />Save</a></div>
		<div class="small-6 medium-3 columns"><a href="#" class="button radius small-12 tiny secondary"><i class="fi-share fi-small"></i><br />Share</a></div>
		<div class="small-6 medium-3 columns"><a href="<?php echo $this->Html->url(array('action' => 'post', $video['items'][0]['id'])); ?>" class="button radius small-12 tiny success"><i class="fi-plus fi-small"></i><br />Post</a></div>
		<h4>Description</h4>
		<p class="show-for-medium-up"><?php echo $video['items'][0]['snippet']['description']; ?></p>
		<p class="show-for-small-only"><small><?php echo $video['items'][0]['snippet']['description']; ?></small></p>
	</div>
	<div class="small-12 large-7 columns hide-for-large-up">
		<h6>Author</h6>
		<p><?php echo $video['items'][0]['snippet']['channelTitle']; ?></p>
		<h6>Published</h6>
		<p><?php echo date("m/d/Y", strtotime($video['items'][0]['snippet']['publishedAt'])); ?></p>
		<h6>Tags</h6>
		<div class="panel"></div>
	</div>
	<div class="small-12 large-3 columns">
		<h5>Ratings</h5>
		<div class="panel"></div>
		<h5>Friends Who Watched</h5>
		<div class="panel"></div>
		<h5>Recommendations</h5>
		<div class="panel"></div>
	</div>
</div>