<?php echo $this->element('topbar', array()); ?>
<div style="min-height:700px;padding:15px;">
	<div class="show-for-medium-only">&nbsp;</div>
	<?php echo $this->element('channel', array('channel' => 'people')); ?>
    <div class="clearfix">
        <div style="float:left;margin-right:20px;">
            <?php echo $this->Html->image('http://graph.facebook.com/' . $post_user['User']['facebook_id'] . '/picture?width=200&height=200', array('class' => 'radius', 'style' => 'height:100px;')); ?>
        </div>
        <div style="float:left;">
            <h2><?php echo $post_user['User']['first_name'] . ' ' . $post_user['User']['last_name']; ?></h2>
            <?php if ($follow) { ?>
                <a href="#" class="button tiny radius small-12 medium-6 large-6 alert" data-reveal-id="UnfollowUserModal">Unfollow</a>
            <?php } elseif ($user['User']['id'] != $post_user['User']['id'] && $post_user['User']['id'] != Configure::read('Admin.user_id')) { ?>
                <a href="#" class="button tiny radius small-12 medium-6 large-6" data-reveal-id="FollowUserModal">Follow</a>
            <?php } ?>
        </div>
    </div>
	<h3>Posts</h3>
	<?php if (count($posts) == 0) { ?>
		<div data-alert class="alert-box secondary radius">
			No posts found.
			<a href="#" class="close">&times;</a>
		</div>
	<?php } ?>
	<div id="posts">
	<?php foreach ($posts as $post) { ?>
		<div class="small-3 left show-for-large-up">
			<div class="summary">
				<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'detail', $post['Post']['id'])); ?>">
					<img src="<?php echo $post['Post']['thumbnail_url']; ?>" class="small-12" />
				</a>
				<div class="info clear">
					<h6><?php echo substr($post['Post']['title'], 0, 50); ?>...</h6>
					<p><?php echo substr($post['Post']['description'], 0, 100); ?>...</p>
				</div>
			</div>
		</div>
		<div class="small-6 left show-for-medium-only">
			<div class="summary">
				<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'detail', $post['Post']['id'])); ?>">
					<img src="<?php echo $post['Post']['thumbnail_url']; ?>" class="small-12" />
				</a>
				<div class="info clear">
					<h6><?php echo substr($post['Post']['title'], 0, 50); ?>...</h6>
					<p><?php echo substr($post['Post']['description'], 0, 100); ?>...</p>
				</div>
			</div>
		</div>
		<div class="small-12 left show-for-small-only">
			<div class="summary">
				<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'detail', $post['Post']['id'])); ?>">
					<img src="<?php echo $post['Post']['thumbnail_url']; ?>" class="small-12" />
				</a>
				<div class="info clear">
					<h6><?php echo substr($post['Post']['title'], 0, 50); ?>...</h6>
					<p class="hide-for-small-only"><?php echo substr($post['Post']['description'], 0, 100); ?>...</p>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
</div>
<div id="FollowUserModal" class="reveal-modal small" data-reveal>
	<h2><?php echo $post_user['User']['first_name'] . ' ' . $post_user['User']['last_name']; ?></h2>
	<p>Are you sure you want to follow this user?</p>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<a href="#" class="button radius warning small-12" onclick="$('#FollowUserModal').foundation('reveal', 'close');">Cancel</a>
		</div>
		<div class="small-12 medium-6 columns">
			<?php echo $this->Html->link('Confirm', array('controller' => 'users', 'action' => 'follow', $post_user['User']['id']), array('class' => 'button radius success small-12', 'id' => 'confirm-follow-user-button')); ?>
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
</div>
<div id="UnfollowUserModal" class="reveal-modal small" data-reveal>
	<h2><?php echo $post_user['User']['first_name'] . ' ' . $post_user['User']['last_name']; ?></h2>
	<p>Are you sure you want to unfollow this user?</p>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<a href="#" class="button radius warning small-12" onclick="$('#UnfollowUserModal').foundation('reveal', 'close');">Cancel</a>
		</div>
		<div class="small-12 medium-6 columns">
			<?php echo $this->Html->link('Confirm', array('controller' => 'users', 'action' => 'unfollow', $post_user['User']['id']), array('class' => 'button radius success small-12', 'id' => 'confirm-unfollow-user-button')); ?>
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$(document).on('opened', '[data-reveal]', function () {
		var modal = $(this);
		if (modal.attr('id') == 'FollowUserModal') {
			$('#confirm-follow-user-button').focus();
		} else if (modal.attr('id') == 'UnfollowUserModal') {
			$('#confirm-unfollow-user-button').focus();
		}
	});
});
</script>