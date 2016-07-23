<?php echo $this->Session->flash(); ?>
<div class="login-container register">
	<?php echo $this->Html->image('logo.png', array('class' => 'logo', 'width' => 235)); ?>
	<div class="th thumbnail" style="background-image:url(<?php echo $profile_image; ?>);"></div>
    <?php echo $this->Form->create('User'); ?>
	<div class="upper clearfix">
		<h4>User Registration</h4>
		<?php echo $this->Form->label('User.name'); ?>
		<?php echo $this->Form->text('name', array('disabled' => 'disabled')); ?>
		<?php echo $this->Form->label('User.email_address'); ?>
        <?php echo $this->Form->text('email_addr', array('disabled' => 'disabled')); ?>
        <?php echo $this->Form->label('User.password'); ?>
        <?php echo $this->Form->password('password', array('placeholder' => 'Choose a password')); ?>
        <?php echo $this->Form->password('confirm', array('placeholder' => 'Confirm password')); ?>
        <br />
        <input type="submit" value="Register" class="button small radius success right">
        <?php echo $this->Html->link('Cancel', array('action' => 'login'), array('class' => 'button small radius left')); ?>
    </div>
    <?php echo $this->Form->end(); ?>
    <div class="copyright">
    	Copyright &copy; SixZero.com 2014<br />
        All Rights Reserved
    </div>
</div>