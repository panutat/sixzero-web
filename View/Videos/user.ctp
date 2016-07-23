<?php echo $this->element('topbar', array()); ?>
<div style="min-height:700px;padding:15px;">
    <div class="show-for-medium-only">&nbsp;</div>
    <?php echo $this->element('channel', array('channel' => 'people')); ?>
    <div class="clearfix">
        <div style="float:left;margin-right:20px;">
            <?php echo $this->Html->image('http://graph.facebook.com/' . $post_user['User']['facebook_id'] . '/picture?width=200&height=200', array('class' => 'radius', 'style' => 'height:100px;width:100px;-moz-border-radius:50px;border-radius:50px;border:1px solid #eeeeee;')); ?>
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
    <div class="large-2 medium-3 columns">
        <h3>My Channels</h3>
        <dl class="sub-nav">
            <?php
            $channel_id = 0;
            if (isset($channel)) {
                $channel_id = $channel['Channel']['id'];
            }
            ?>
            <dd <?php if ($channel_id == 0) { echo 'class="active"'; } ?>><?php echo $this->Html->link('All Posts', array('action' => 'user', $post_user['User']['id'])); ?></dd>
            <?php foreach ($channels as $channel_menu) { ?>
                <dd <?php if ($channel_id == $channel_menu['Channel']['id']) { echo 'class="active"'; } ?>><?php echo $this->Html->link($channel_menu['Channel']['name'], array('action' => 'user', $post_user['User']['id'], '?' => array('channel_id' => $channel_menu['Channel']['id']))); ?></dd>
            <?php } ?>
        </dl>
    </div>
    <div class="large-10 medium-9 columns">
        <?php if (isset($channel)) { ?>
            <h3><?php echo $channel['Channel']['name']; ?></h3>
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
    var limit = 16;
    var page = 1;
    var channel_id = <?php if (isset($channel)) { echo $channel['Channel']['id']; } else { echo 0; } ?>;
    var loaded = 0;
    $(document).ready(function() {
        $('#show-more-button').click(function() {
            var request = $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'userAjax')); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'user_id' : <?php echo $post_user['User']['id']; ?>,
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
            if (modal.attr('id') == 'FollowUserModal') {
                $('#confirm-follow-user-button').focus();
            } else if (modal.attr('id') == 'UnfollowUserModal') {
                $('#confirm-unfollow-user-button').focus();
            }
        });
    });
</script>