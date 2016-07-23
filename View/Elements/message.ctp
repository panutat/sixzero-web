<div data-alert class="alert-box <?php echo $class; ?>">
	<?php echo h($message); ?>
	<?php
		if (isset($errors)) {
			echo '<ul class="circle" style="font-size:12px;">';
			foreach ($errors as $field => $messages) {
				foreach ($messages as $error) {
					echo '<li>' . $error . '</li>';
				}
			}
			echo '</ul>';
		}
	?>
	<a href="#" class="close">&times;</a>
</div>