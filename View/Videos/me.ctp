<?php echo $this->element('topbar', array()); ?>
<div style="min-height:700px;padding:15px;">
	<div class="show-for-medium-only">&nbsp;</div>
	<?php echo $this->element('channel', array('channel' => 'myposts')); ?>
	<div class="large-2 medium-3 columns">
		<h3>My Channels</h3>
		<dl class="sub-nav">
			<?php
				$channel_id = 0;
				if (isset($channel)) {
					$channel_id = $channel['Channel']['id'];
				}
			?>
			<dd <?php if ($channel_id == 0) { echo 'class="active"'; } ?>><?php echo $this->Html->link('All Posts', array('action' => 'me')); ?></dd>
			<?php foreach ($channels as $channel_menu) { ?>
				<dd <?php if ($channel_id == $channel_menu['Channel']['id']) { echo 'class="active"'; } ?>><?php echo $this->Html->link($channel_menu['Channel']['name'], array('action' => 'me', '?' => array('channel_id' => $channel_menu['Channel']['id']))); ?></dd>
			<?php } ?>
		</dl>
		<a href="#" class="button small radius success small-12" data-reveal-id="AddChannelModal">Add Channel</a>
	</div>
	<div class="large-10 medium-9 columns">
		<?php if (isset($channel)) { ?>
            <div class="clearfix">
                <h3 class="left"><?php echo $channel['Channel']['name']; ?></h3>
                <div style="padding:13px;float:left;">
                    <?php echo $this->Html->link('Rename', array('action' => 'renameChannel'), array('class' => 'label secondary radius')); ?>
                    <?php echo $this->Html->link('Clear', array('action' => 'clearChannel'), array('class' => 'label secondary radius')); ?>
                    <?php echo $this->Html->link('Delete', array('action' => 'deleteChannel'), array('class' => 'label secondary radius')); ?>
                </div>
            </div>
		<?php } else { ?>
		    <h3>All Posts</h3>
		<?php } ?>
        <div id="posts" class="clearfix"></div>
        <div class="row" style="margin-top:20px;">
            <div class="medium-3 large-4 hide-for-small-only columns">&nbsp;</div>
            <div class="small-12 medium-6 large-4 columns">
                <?php echo $this->Form->button('Show Me More', array('id' => 'show-more-button', 'class' => 'button small small-12 radius secondary')); ?>
            </div>
            <div class="medium-3 large-4 hide-for-small-only columns">&nbsp;</div>
        </div>
	</div>
</div>
<div id="AddChannelModal" class="reveal-modal tiny" data-reveal>
	<h2>Add Channel</h2>
	<p>Enter a name for the channel below:</p>
	<?php echo $this->Form->create('AddChannel', array('id' => 'AddChannelForm')); ?>
	<div class="row collapse">
		<div class="small-12 medium-9 columns">
			<?php echo $this->Form->text('name'); ?>
		</div>
		<div class="small-12 medium-3 columns">
			<a href="#" id="AddChannelButton" class="button postfix radius success">Create</a>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
	<a class="close-reveal-modal">&#215;</a>
</div>
<script type="text/javascript">
    var limit = 16;
    var page = 1;
    var channel_id = <?php if (isset($channel)) { echo $channel['Channel']['id']; } else { echo 0; } ?>;
    var loaded = 0;
    $(document).ready(function() {
        $('#show-more-button').click(function() {
            var request = $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'meAjax')); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'channel_id' : channel_id,
                    'limit' : limit,
                    'page' : page
                }
            });
            request.done(function(response) {
                var first_id = 0;
                var html = '';
                $.each(response, function(key, post) {
                    if (first_id == 0) {
                        first_id = post.Post.id;
                    }
                    html += '<div id="post_' + post.Post.id + '" class="small-3 left show-for-large-up"><div class="summary">';
                    if (post.UserChannel.id) {
                        html += '<div class="channel">' + post.UserChannel.name + '</div>';
                    }
                    html += '<div class="duration">' + post.Post.duration.toHHMMSS() + '</div>';
                    html += '<a href="/videos/detail/' + post.Post.id + '">';
                    html += '<img src="' + post.Post.thumbnail_url + '" class="small-12" />';
                    html += '</a>';
                    html += '<div class="info clear small">';
                    html += '<h6>' + post.Post.title.substring(0, 50) + '</h6>';
                    html += '</div>';
                    html += '<div class="stats">';
                    html += post.Post.hit_count + ' Views &nbsp; ' + post.Post.comment_count + ' Comments';
                    html += '<div class="right">&nbsp;(' + post.Post.rating_count + ')</div><div class="basic right" data-average="' + post.Post.rating_avg + '" data-id="1"></div>';
                    html += '</div>';
                    html += '</div></div>';


                    html += '<div id="post_' + post.Post.id + '" class="small-6 left show-for-medium-only"><div class="summary">';
                    if (post.UserChannel.id) {
                        html += '<div class="channel">' + post.UserChannel.name + '</div>';
                    }
                    html += '<div class="duration">' + post.Post.duration.toHHMMSS() + '</div>';
                    html += '<a href="/videos/detail/' + post.Post.id + '">';
                    html += '<img src="' + post.Post.thumbnail_url + '" class="small-12" />';
                    html += '</a>';
                    html += '<div class="info clear small">';
                    html += '<h6>' + post.Post.title.substring(0, 50) + '</h6>';
                    html += '</div>';
                    html += '<div class="stats">';
                    html += post.Post.hit_count + ' Views &nbsp; ' + post.Post.comment_count + ' Comments';
                    html += '<div class="right">&nbsp;(' + post.Post.rating_count + ')</div><div class="basic right" data-average="' + post.Post.rating_avg + '" data-id="1"></div>';
                    html += '</div>';
                    html += '</div></div>';


                    html += '<div id="post_' + post.Post.id + '" class="small-12 left show-for-small-only"><div class="summary">';
                    if (post.UserChannel.id) {
                        html += '<div class="channel">' + post.UserChannel.name + '</div>';
                    }
                    html += '<div class="duration">' + post.Post.duration.toHHMMSS() + '</div>';
                    html += '<a href="/videos/detail/' + post.Post.id + '">';
                    html += '<img src="' + post.Post.thumbnail_url + '" class="small-12" />';
                    html += '</a>';
                    html += '<div class="info clear small">';
                    html += '<h6>' + post.Post.title.substring(0, 50) + '</h6>';
                    html += '</div>';
                    html += '<div class="stats">';
                    html += post.Post.hit_count + ' Views &nbsp; ' + post.Post.comment_count + ' Comments';
                    html += '<div class="right">&nbsp;(' + post.Post.rating_count + ')</div><div class="basic right" data-average="' + post.Post.rating_avg + '" data-id="1"></div>';
                    html += '</div>';
                    html += '</div></div>';
                });
                $('#posts').append($(html).hide().fadeIn(500));
                if (loaded > 0 && $("#post_" + first_id).offset()) {
                    $('html,body').animate({scrollTop: $("#post_" + first_id).offset().top}, 'slow');
                }
                loaded++;
                page++;

                $('.basic').jRating({type: 'small', isDisabled : true});
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });
        $('#show-more-button').click();

        $(document).on('opened', '[data-reveal]', function () {
            var modal = $(this);
            if (modal.attr('id') == 'AddChannelModal') {
                $('#AddChannelName').focus();
            }
        });
        $('#AddChannelButton').click(function() {
            var channel_name = $('#AddChannelName').val();
            addChannel(channel_name);
        });
        $('#AddChannelForm').submit(function() {
            var channel_name = $('#AddChannelName').val();
            addChannel(channel_name);
            return false;
        });
    });
    function addChannel(name) {
        var request = $.ajax({
            url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'addChannel')); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                'name' : name
            }
        });
        request.done(function(response) {
            if (response.success) {
                $('#AddChannelName').val('');
                $('#AddChannelModal').foundation('reveal', 'close');
                window.location.href = "<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'me')); ?>";
            }
        });
        request.fail(function(jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    }
</script>