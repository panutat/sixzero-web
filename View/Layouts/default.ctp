<?php $cakeDescription = __d('cake_dev', 'SixZero - Your World In 60 Seconds'); ?>
<!DOCTYPE html>
<?php echo $this->Facebook->html(); ?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>
		<?php echo $title_for_layout; ?>
        <?php echo $cakeDescription ?>
	</title>
	<?php
		echo $this->Html->css(array('normalize'));
		echo $this->Html->css(array('foundation'));
		echo $this->Html->css(array('foundation-icons/foundation-icons'));
        echo $this->Html->css(array('jRating.jquery'));
		echo $this->Html->css(array('sixzero'));
        echo $this->Html->css(array('tagmanager'));
        echo $this->Html->css(array('nprogress'));
		
		echo $this->Html->script(array('jquery'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<?php echo $this->Session->flash(); ?>

	<div class="off-canvas-wrap">
	<div class="inner-wrap">
	<?php echo $this->fetch('content'); ?>
	</div>
	</div>
	
	<?php
		echo $this->Html->script(array('foundation.min'));
        echo $this->Html->script(array('modernizr'));
        echo $this->Html->script(array('jRating.jquery'));
        echo $this->Html->script(array('sixzero'));
        echo $this->Html->script(array('tagmanager'));
        echo $this->Html->script(array('nprogress'));
        echo $this->Html->script(array('share'));
        echo $this->Html->script(array('readmore'));
        echo $this->Html->script(array('moment.min'));
		echo $this->Facebook->init();
	?>
	<script type="text/javascript">
		$(document).foundation();

        NProgress.start();
        setTimeout(function() { NProgress.done(); $('.fade').removeClass('out'); }, 800);
	</script>
</body>
</html>