<?php echo $this->element('topbar', array()); ?>
<div style="min-height:700px;padding:15px;">
    <div class="show-for-medium-only">&nbsp;</div>
    <?php echo $this->element('channel', array()); ?>
    <h3>Password</h3>
    <div class="large-2 medium-3 columns">
        <?php echo $this->Html->image('http://graph.facebook.com/' . $user['User']['facebook_id'] . '/picture?width=200&height=200', array('style' => 'height:150px;width:150px;-moz-border-radius:75px;border-radius:75px;border:1px solid #eeeeee;')); ?>
        <br /><br />
    </div>
    <div class="large-10 medium-9 columns">
        <?php echo $this->Form->create('User', array('action' => 'password')); ?>
        <div class="small-12 medium-6 large-3">
            <?php echo $this->Form->label('User.old_password'); ?>
            <?php echo $this->Form->password('old_password', array('autocomplete' => 'off')); ?>
        </div>
        <div class="small-12 medium-6 large-3">
            <?php echo $this->Form->label('User.password', 'New Password'); ?>
            <?php echo $this->Form->password('password', array('autocomplete' => 'off')); ?>
        </div>
        <div class="small-12 medium-6 large-3">
            <?php echo $this->Form->label('User.confirm', 'Confirm Password'); ?>
            <?php echo $this->Form->password('confirm', array('autocomplete' => 'off')); ?>
        </div>
        <div class="small-12 medium-6 large-3">
            <?php echo $this->Form->submit('Update', array('class' => 'button radius small-12 small success')); ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>