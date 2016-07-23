<?php
	if (!isset($channel)) {
		$channel = '';
	}
	
	function checkChannel($value = NULL, $key = NULL) {
		if ($value == $key) {
			return ' class="active"';
		}
	}
?>
<dl class="sub-nav show-for-medium-up">
	<dd<?php echo checkChannel($channel, 'newest'); ?>><?php echo $this->Html->link('Newest', array('controller' => 'videos', 'action' => 'newest')); ?></dd>
	<!--
	<dd<?php echo checkChannel($channel, 'popular'); ?>><a href="#">Popular</a></dd>
	<dd<?php echo checkChannel($channel, 'favorites'); ?>><a href="#">Favorites</a></dd>
	-->
	<dd>|</dd>
	<dd<?php echo checkChannel($channel, 'myposts'); ?>><?php echo $this->Html->link('My Posts', array('controller' => 'videos', 'action' => 'me')); ?></dd>
	<dd>|</dd>
	<dd<?php echo checkChannel($channel, 'people'); ?>><?php echo $this->Html->link('People', array('controller' => 'users', 'action' => 'people')); ?></dd>
	<dd>|</dd>
	<?php foreach ($admin_channels as $admin_channel) { ?>
		<dd<?php echo checkChannel($channel, $admin_channel['Channel']['id']); ?>><?php echo $this->Html->link($admin_channel['Channel']['name'], array('controller' => 'videos', 'action' => 'channel', $admin_channel['Channel']['id'])); ?></dd>
	<?php } ?>
</dl>
<div class="show-for-small-only">
	<?php
		$option_urls = array(
			'newest' => $this->Html->url(array('controller' => 'videos', 'action' => 'newest')),
			'myposts' => $this->Html->url(array('controller' => 'videos', 'action' => 'me')),
			'people' => $this->Html->url(array('controller' => 'users', 'action' => 'people')),
		);
		$options = array(
			'newest' => 'Newest',
			'myposts' => 'My Posts',
			'people' => 'People'
		);
		foreach ($admin_channels as $admin_channel) {
			$options[$admin_channel['Channel']['id']] = $admin_channel['Channel']['name'];
			$option_urls[$admin_channel['Channel']['id']] = $this->Html->url(array('controller' => 'videos', 'action' => 'channel', $admin_channel['Channel']['id']));
		}
	?>
	<?php echo $this->Form->select('channel_nav', $options, array('value' => $channel, 'empty' => 'Select A Channel..')); ?>
</div>
<script type="text/javascript">
	var option_urls = new Object();
	<?php foreach ($option_urls as $id => $url) { ?>
		option_urls['<?php echo $id; ?>'] = '<?php echo $url; ?>';
	<?php } ?>
	$(document).ready(function() {
		$('#channel_nav').change(function() {
            if ($('#channel_nav').val() != '') {
			    window.location.href = option_urls[$('#channel_nav').val()];
            }
		});
	});
</script>