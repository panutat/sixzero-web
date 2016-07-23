<?php echo $this->element('topbar', array('channel' => 'people')); ?>
<div style="min-height:700px;padding:15px;">
	<div class="show-for-medium-only">&nbsp;</div>
	<?php echo $this->element('channel', array('channel' => 'people')); ?>
	<h3>People</h3>
	<div id="people">
	<?php foreach ($users as $user) { ?>
		<div class="small-2 left show-for-large-up">
			<div class="summary">
				<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $user['User']['id'])); ?>">
					<?php echo $this->Html->image('http://graph.facebook.com/' . $user['User']['facebook_id'] . '/picture?width=200&height=200', array('class' => 'small-12 thumb')); ?>
				</a>
				<div class="info clear">
					<h5><?php echo $user['User']['first_name']; ?></h5>
				</div>
			</div>
		</div>
		<div class="small-3 left show-for-medium-only">
			<div class="summary">
				<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $user['User']['id'])); ?>">
					<?php echo $this->Html->image('http://graph.facebook.com/' . $user['User']['facebook_id'] . '/picture?width=200&height=200', array('class' => 'small-12 thumb')); ?>
				</a>
				<div class="info clear">
					<h5><?php echo $user['User']['first_name']; ?></h5>
				</div>
			</div>
		</div>
		<div class="small-6 left show-for-small-only">
			<div class="summary">
				<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $user['User']['id'])); ?>">
					<?php echo $this->Html->image('http://graph.facebook.com/' . $user['User']['facebook_id'] . '/picture?width=200&height=200', array('class' => 'small-12 thumb')); ?>
				</a>
				<div class="info clear">
					<h5><?php echo $user['User']['first_name']; ?></h5>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
</div>