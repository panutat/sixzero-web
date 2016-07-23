<?php echo $this->Session->flash(); ?>
<div class="login-container login">
	<?php echo $this->Html->image('logo.png', array('class' => 'logo', 'width' => 235)); ?>
    <?php echo $this->Form->create('User'); ?>
	<div class="upper clearfix">
		<?php echo $this->Form->label('User.email_address'); ?>
        <?php echo $this->Form->text('email_addr', array('tabindex' => 1)); ?>
        <?php echo $this->Form->label('User.password'); ?>
        <?php echo $this->Form->password('password', array('tabindex' => 2)); ?>
        <input type="submit" value="Login" class="button small right radius success">
        <?php echo $this->Form->input('keep_me_logged_in', array('type' => 'checkbox', 'tabindex' => 3)); ?>
        <br />
    </div>
    <div class="lower clearfix">
		<label>Don't have an login? Click below to register.</label>
    	<?php echo $this->Facebook->login(array('perms' => 'email,publish_stream,user_likes,user_interests', 'width' => '150', 'custom' => true, 'img' => 'register-facebook.png', 'redirect' => $this->Html->url(array('action' => 'register'))), 'Register With Facebook'); ?>
    </div>
    <?php echo $this->Form->end(); ?>
    <div class="copyright">
    	Copyright &copy; SixZero.com 2014<br />
	    All Rights Reserved
	</div>
</div>