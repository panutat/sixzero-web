<?php $cakeDescription = __d('cake_dev', 'SixZero - Your World In 60 Seconds'); ?>
<!DOCTYPE html>
<?php echo $this->Facebook->html(); ?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->css(array('normalize'));
		echo $this->Html->css(array('foundation'));
		echo $this->Html->css(array('login'));
		
		echo $this->Html->script(array('modernizr'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
	
	<?php
		echo $this->Html->script(array('vendor/jquery'));
		echo $this->Html->script(array('foundation.min'));
	?>
	<script>
		$(document).foundation();
	</script>
</body>
<?php echo $this->Facebook->init(); ?>
</html>