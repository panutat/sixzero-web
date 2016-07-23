<?php echo $this->element('topbar', array()); ?>
<div style="min-height:700px;padding:15px;">
	<div class="show-for-medium-only">&nbsp;</div>
	<?php echo $this->element('channel', array()); ?>
	<div class="small-12 columns">
		<h3 class="show-for-large-up"><?php echo $post['Post']['title']; ?></h3>
		<h4 class="show-for-medium-only"><?php echo $post['Post']['title']; ?></h4>
		<h5 class="show-for-small-only"><?php echo $post['Post']['title']; ?></h5>
	</div>
	<hr />
	<div class="small-12 large-2 columns show-for-large-up">
		<h6>Posted By</h6>
		<?php if ($post['User']['id'] != Configure::read('Admin.user_id')) {
    ?>
		<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $post['User']['id']));
    ?>">
			<?php echo $this->Html->image('http://graph.facebook.com/'.$post['User']['facebook_id'].'/picture?width=100&height=100', array('style' => 'height:100px;width:100px;margin-bottom:20px;-moz-border-radius:50px;border-radius:50px;border:1px solid #eeeeee;'));
    ?>
		</a>
		<?php
} else {
    ?>
			<?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:100px;width:100px;margin-bottom:20px;-moz-border-radius:50px;border-radius:50px;border:1px solid #eeeeee;'));
    ?>
		<?php
} ?>
		<br />
		<?php if ($follow) {
    ?>
			<a href="#" class="button tiny radius small-12 alert" data-reveal-id="UnfollowUserModal">Unfollow</a>
		<?php
} elseif ($user['User']['id'] != $post['User']['id'] && $post['User']['facebook_id'] != Configure::read('Admin.facebook_id')) {
    ?>
			<a href="#" class="button tiny radius small-12" data-reveal-id="FollowUserModal">Follow</a>
		<?php
} ?>
		<h6>Author</h6>
		<p><?php echo $post['Post']['channel_title']; ?></p>
		<h6>Published</h6>
		<p><?php echo date('m/d/Y', strtotime($post['Post']['published_ts'])); ?></p>
		<h6>Site Channel</h6>
		<?php if ($post['User']['id'] == $user['User']['id']) {
    ?>
		<?php
            $admin_channel_ids = array();
    foreach ($admin_channels as $admin_channel) {
        $admin_channel_ids[$admin_channel['Channel']['id']] = $admin_channel['Channel']['name'];
    }
    ?>
		<?php echo $this->Form->select('site_channel_id', $admin_channel_ids, array('value' => $post['Post']['site_channel_id']));
    ?>
		<?php
} else {
    ?>
		<p><?php if (isset($post['SiteChannel']['name'])) {
    echo $post['SiteChannel']['name'];
} else {
    echo 'N/A';
}
    ?></p>
		<?php
} ?>
		<h6>User Channel</h6>
		<?php if ($post['User']['id'] == $user['User']['id']) {
    ?>
		<?php
            $user_channel_ids = array();
    foreach ($user_channels as $user_channel) {
        $user_channel_ids[$user_channel['Channel']['id']] = $user_channel['Channel']['name'];
    }
    ?>
		<?php echo $this->Form->select('user_channel_id', $user_channel_ids, array('value' => $post['Post']['user_channel_id']));
    ?>
		<?php
} else {
    ?>
		<p><?php if (isset($post['UserChannel']['name'])) {
    echo $post['UserChannel']['name'];
} else {
    echo 'N/A';
}
    ?></p>
		<?php
} ?>
		<h6>Tags</h6>
        <?php if ($post['User']['id'] == $user['User']['id']) {
    ?>
        <input type="text" name="tags" placeholder="Add new tag..." class="tm-input" />
        <?php
} else {
    ?>
        <?php
            if (!empty($tags)) {
                $tag_arr = explode(',', $tags);
                foreach ($tag_arr as $tag) {
                    echo '<span class="tm-tag">'.$tag.'</span>';
                }
            } else {
                echo 'N/A<br />';
            }
    ?>
        <?php
} ?>
        <br />
        <?php if ($user['User']['id'] == $post['User']['id']) {
    ?>
            <a href="#" class="button radius small-12 tiny warning" data-reveal-id="DeletePostModal">Delete Post</a>
        <?php
} else {
    ?>
            <a href="<?php echo $this->Html->url(array('action' => 'post', $post['Post']['video_id']));
    ?>" class="button radius small-12 tiny success">Repost</a>
        <?php
} ?>
	</div>
	<div class="small-12 large-7 columns">
		<div class="youtube-wrapper">
			<iframe id="ytplayer" type="text/html" src="https://www.youtube.com/embed/<?php echo $post['Post']['video_id']; ?>?enablejsapi=1&showinfo=0&color=white&theme=light&origin=http://<?php echo Configure::read('Application.domain'); ?>" width="560" height="315" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
		</div>
		<h4>Description</h4>
        <?php if (!empty($post['Post']['description'])) {
    ?>
		<p id="readmore-medium" class="show-for-medium-up"><?php echo $post['Post']['description'];
    ?></p>
		<p id="readmore-small" class="show-for-small-only"><small><?php echo $post['Post']['description'];
    ?></small></p>
        <?php
} else {
    ?>
        <p class="show-for-medium-up">N/A</p>
        <p class="show-for-small-only"><small>N/A</small></p>
        <?php
} ?>
		<h4>Comments</h4>
		<h6>Post New Comment</h6>
		<?php echo $this->Form->create('Comment', array('id' => 'PostCommentForm')); ?>
		<div class="row collapse">
			<div class="small-12 medium-10 columns">
				<?php echo $this->Form->text('message', array('placeholder' => 'Type your comment here...')); ?>
			</div>
			<div class="small-12 medium-2 columns">
				<a href="#" id="PostCommentButton" class="button postfix radius success">Post</a>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
        <div id="comments">
            <?php if ($comments) {
    ?>
                <?php foreach ($comments as $comment) {
    ?>
                    <div class="row">
                        <div class="medium-2 columns hide-for-small-only text-right">
                            <?php if ($comment['User']['id'] != Configure::read('Admin.user_id')) {
    ?>
                                <a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $comment['User']['id']));
    ?>">
                                    <?php echo $this->Html->image('http://graph.facebook.com/'.$comment['User']['facebook_id'].'/picture?width=100&height=100', array('style' => 'height:50px;width:50px;margin:0 5px 5px 0;-moz-border-radius:25px;border-radius:25px;border:1px solid #eeeeee;'));
    ?>
                                </a>
                            <?php
} else {
    ?>
                                <?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:50px;width:50px;margin:0 5px 5px 0;-moz-border-radius:25px;border-radius:25px;border:1px solid #eeeeee;'));
    ?>
                            <?php
}
    ?>
                        </div>
                        <div class="small-3 columns show-for-small-only text-right">
                            <?php if ($comment['User']['id'] != Configure::read('Admin.user_id')) {
    ?>
                                <a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $comment['User']['id']));
    ?>">
                                    <?php echo $this->Html->image('http://graph.facebook.com/'.$comment['User']['facebook_id'].'/picture?width=60&height=60', array('style' => 'height:30px;width:30px;margin:0 5px 5px 0;-moz-border-radius:15px;border-radius:15px;border:1px solid #eeeeee;'));
    ?>
                                </a>
                            <?php
} else {
    ?>
                                <?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:30px;width:30px;margin:0 5px 5px 0;-moz-border-radius:15px;border-radius:15px;border:1px solid #eeeeee;'));
    ?>
                            <?php
}
    ?>
                        </div>
                        <div class="small-9 medium-10 columns">
                            <blockquote>
                                <small>
                                    <?php echo date('m/d/Y h:i A', strtotime($comment['Comment']['post_ts']));
    ?>
                                    <?php if ($comment['User']['id'] != Configure::read('Admin.user_id')) {
    ?>
                                        by <a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $comment['User']['id']));
    ?>"><?php echo $comment['User']['first_name'];
    ?></a>
                                    <?php
}
    ?>
                                </small>
                                <p class="hide-for-small-only"><?php echo $comment['Comment']['message'];
    ?></p>
                                <p class="show-for-small-only"><small><?php echo $comment['Comment']['message'];
    ?></small></p>
                            </blockquote>
                        </div>
                    </div>
                <?php
}
    ?>
            <?php
} else {
    ?>
            <div id="nocomments" class="panel radius">
                <p>No comments.</p>
            </div>
            <?php
} ?>
        </div>
	</div>
	<div class="small-12 large-7 columns hide-for-large-up">
		<h6>Posted By</h6>
		<?php if ($post['User']['facebook_id'] != Configure::read('Admin.facebook_id')) {
    ?>
		<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $post['User']['id']));
    ?>">
			<?php echo $this->Html->image('http://graph.facebook.com/'.$post['User']['facebook_id'].'/picture?width=100&height=100', array('style' => 'height:80px;width:80px;margin-bottom:20px;-moz-border-radius:40px;border-radius:40px;border:1px solid #eeeeee;'));
    ?>
		</a>
		<?php
} else {
    ?>
			<?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:80px;width:80px;margin-bottom:20px;-moz-border-radius:40px;border-radius:40px;border:1px solid #eeeeee;'));
    ?>
		<?php
} ?>
		<br />
		<?php if ($follow) {
    ?>
			<a href="#" class="button tiny radius small-12 alert" data-reveal-id="FollowUserModal">Unfollow</a>
		<?php
} elseif ($user['User']['id'] != $post['User']['id'] && $post['User']['facebook_id'] != Configure::read('Admin.facebook_id')) {
    ?>
			<a href="#" class="button tiny radius small-12" data-reveal-id="FollowUserModal">Follow</a>
		<?php
} ?>
		<h6>Author</h6>
		<p><?php echo $post['Post']['channel_title']; ?></p>
		<h6>Published</h6>
		<p><?php echo date('m/d/Y', strtotime($post['Post']['published_ts'])); ?></p>
		<h6>Site Channel</h6>
		<?php if ($post['User']['id'] == $user['User']['id']) {
    ?>
		<?php
            $admin_channel_ids = array();
    foreach ($admin_channels as $admin_channel) {
        $admin_channel_ids[$admin_channel['Channel']['id']] = $admin_channel['Channel']['name'];
    }
    ?>
		<?php echo $this->Form->select('site_channel_id2', $admin_channel_ids, array('value' => $post['Post']['site_channel_id']));
    ?>
		<?php
} else {
    ?>
		<p><?php if (isset($post['SiteChannel']['name'])) {
    echo $post['SiteChannel']['name'];
} else {
    echo 'N/A';
}
    ?></p>
		<?php
} ?>
		<h6>User Channel</h6>
		<?php if ($post['User']['id'] == $user['User']['id']) {
    ?>
		<?php
            $user_channel_ids = array();
    foreach ($user_channels as $user_channel) {
        $user_channel_ids[$user_channel['Channel']['id']] = $user_channel['Channel']['name'];
    }
    ?>
		<?php echo $this->Form->select('user_channel_id2', $user_channel_ids, array('value' => $post['Post']['user_channel_id']));
    ?>
		<?php
} else {
    ?>
		<p><?php if (isset($post['UserChannel']['name'])) {
    echo $post['UserChannel']['name'];
} else {
    echo 'N/A';
}
    ?></p>
		<?php
} ?>
		<h6>Tags</h6>
        <?php if ($post['User']['id'] == $user['User']['id']) {
    ?>
            <input type="text" name="tags" placeholder="Add new tag..." class="tm-input" />
        <?php
} else {
    ?>
        <?php
            if (!empty($tags)) {
                $tag_arr = explode(',', $tags);
                foreach ($tag_arr as $tag) {
                    echo '<span class="tm-tag">'.$tag.'</span>';
                }
            } else {
                echo 'N/A<br />';
            }
    ?>
        <?php
} ?>
        <br />
        <?php if ($user['User']['id'] == $post['User']['id']) {
    ?>
            <a href="#" class="button radius small-12 tiny warning" data-reveal-id="DeletePostModal">Delete Post</a>
        <?php
} else {
    ?>
            <a href="<?php echo $this->Html->url(array('action' => 'post', $post['Post']['video_id']));
    ?>" class="button radius small-12 tiny success">Repost</a>
        <?php
} ?>
	</div>
	<div class="small-12 large-3 columns">
        <div class="share-button"></div>
        <br />
		<h5>Ratings</h5>
        <?php
            $average = 0;
            if ($rating[0]['votes'] > 0) {
                $average = $rating[0]['total'] / $rating[0]['votes'];
            }
        ?>
        <div class="basic" data-average="<?php echo $average; ?>" data-id="1"></div>
        <small style="margin-left:5px;">(<?php echo $rating[0]['votes']; ?> votes)</small><br /><br />
		<h5>Friends Who Watched</h5>
        <?php if (count($viewers) > 0) {
    ?>
            <div class="row">
            <?php foreach ($viewers as $viewer) {
    ?>
                <?php if ($viewer['User']['id'] != Configure::read('Admin.user_id')) {
    ?>
                    <a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $viewer['User']['id']));
    ?>">
                        <?php echo $this->Html->image('http://graph.facebook.com/'.$viewer['User']['facebook_id'].'/picture?width=100&height=100', array('style' => 'height:50px;width:50px;margin:0 5px 5px 0;-moz-border-radius:25px;border-radius:25px;border:1px solid #eeeeee;'));
    ?>
                    </a>
                <?php
} else {
    ?>
                    <?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:50px;width:50px;margin:0 5px 5px 0;-moz-border-radius:25px;border-radius:25px;border:1px solid #eeeeee;'));
    ?>
                <?php
}
    ?>
            <?php
}
    ?>
            </div>
        <?php
} else {
    ?>
            N/A<br /><br />
        <?php
} ?>
		<h5>Recommendations</h5>
		<div class="panel"></div>
	</div>
</div>
<div id="DeletePostModal" class="reveal-modal small" data-reveal>
	<h2>Delete Post</h2>
	<p>Are you sure you want to delete this post?</p>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<a href="#" class="button radius warning small-12" onclick="$('#DeletePostModal').foundation('reveal', 'close');">Cancel</a>
		</div>
		<div class="small-12 medium-6 columns">
			<?php echo $this->Html->link('Confirm', array('controller' => 'videos', 'action' => 'delete', $post['Post']['id']), array('class' => 'button radius success small-12', 'id' => 'confirm-delete-post-button')); ?>
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
</div>
<div id="FollowUserModal" class="reveal-modal small" data-reveal>
	<h2><?php echo $post['User']['first_name'].' '.$post['User']['last_name']; ?></h2>
	<p>Are you sure you want to follow this user?</p>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<a href="#" class="button radius warning small-12" onclick="$('#FollowUserModal').foundation('reveal', 'close');">Cancel</a>
		</div>
		<div class="small-12 medium-6 columns">
			<?php echo $this->Html->link('Confirm', array('controller' => 'users', 'action' => 'follow', $post['User']['id']), array('class' => 'button radius success small-12', 'id' => 'confirm-follow-user-button')); ?>
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
</div>
<div id="UnfollowUserModal" class="reveal-modal small" data-reveal>
	<h2><?php echo $post['User']['first_name'].' '.$post['User']['last_name']; ?></h2>
	<p>Are you sure you want to unfollow this user?</p>
	<div class="row">
		<div class="small-12 medium-6 columns">
			<a href="#" class="button radius warning small-12" onclick="$('#UnfollowUserModal').foundation('reveal', 'close');">Cancel</a>
		</div>
		<div class="small-12 medium-6 columns">
			<?php echo $this->Html->link('Confirm', array('controller' => 'users', 'action' => 'unfollow', $post['User']['id']), array('class' => 'button radius success small-12', 'id' => 'confirm-unfollow-user-button')); ?>
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
</div>
<script type="text/javascript">
var player;

$(document).ready(function() {
	$(document).on('opened', '[data-reveal]', function () {
		var modal = $(this);
		if (modal.attr('id') == 'DeletePostModal') {
			$('#confirm-delete-post-button').focus();
		} else if (modal.attr('id') == 'FollowUserModal') {
			$('#confirm-follow-user-button').focus();
		} else if (modal.attr('id') == 'UnfollowUserModal') {
			$('#confirm-unfollow-user-button').focus();
		}
	});

	$('#site_channel_id').change(function() {
		updateSiteChannel($('#site_channel_id').val());
	});

	$('#user_channel_id').change(function() {
		updateUserChannel($('#user_channel_id').val());
	});

	$('#site_channel_id2').change(function() {
		updateSiteChannel($('#site_channel_id2').val());
	});

	$('#user_channel_id2').change(function() {
		updateUserChannel($('#user_channel_id2').val());
	});

    // simple jRating call
    $(".basic").jRating({
        onClick : function(element,rate) {
            var request = $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'rate')); ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    'post_id' : <?php echo $post['Post']['id']; ?>,
                    'rating' : rate
                }
            });
            request.done(function(response) {
                if (!response.success) {
                    alert('Rating could not be saved.');
                }
            });
            request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        }
    });

    $('.tm-input').tagsManager({
        prefilled: '<?php echo $tags; ?>',
        AjaxPush: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'updateTagAjax')); ?>',
        AjaxPushAllTags: true,
        AjaxPushParameters: {
            'post_id': <?php echo $post['Post']['id']; ?>
        },
        maxTags: 10
    });

    <?php
        $output = str_replace(array("\r\n", "\r"), "\n", $post['Post']['description']);
        $lines = explode("\n", $output);
        $new_lines = array();
        foreach ($lines as $i => $line) {
            if (!empty($line)) {
                $new_lines[] = trim($line);
            }
        }
        $description = implode($new_lines);
    ?>
    var title = '<?php echo addslashes($post['Post']['title']); ?>';
    var description = '<?php echo addslashes(substr($description, 0, 250)); ?>...';
    var share = $('.share-button').share({
        app_id: '<?php echo Configure::read('Facebook.appId'); ?>',
        facebook: {
            title: title,
            link: 'http://<?php echo Configure::read('Application.domain'); ?>/videos/p/<?php echo $post['Post']['id']; ?>',
            image: '<?php echo $post['Post']['thumbnail_url']; ?>',
            caption: 'Your World in 60 Seconds',
            text: description
        },
        twitter: {
            text: title,
            link: 'http://<?php echo Configure::read('Application.domain'); ?>/videos/p/<?php echo $post['Post']['id']; ?>'
        },
        gplus: {
            link: 'http://<?php echo Configure::read('Application.domain'); ?>/videos/p/<?php echo $post['Post']['id']; ?>'
        }
    });

    $('#readmore-medium').readmore({
        speed: 200,
        maxHeight: 150,
        moreLink: '<a href="#" class="button small-12 secondary small radius">Read More</a>',
        lessLink: '<a href="#" class="button small-12 secondary small radius">Close</a>',
        embedCSS: true,
        sectionCSS: 'margin-bottom:20px;'
    });

    $('#readmore-small').readmore({
        speed: 200,
        maxHeight: 150,
        moreLink: '<a href="#" class="button small-12 secondary small radius">Read More</a>',
        lessLink: '<a href="#" class="button small-12 secondary small radius">Close</a>',
        embedCSS: true,
        sectionCSS: 'margin-bottom:10px;'
    });

    $('#PostCommentButton').click(function() {
        var message = $('#CommentMessage').val();
        postComment(message);
    });
    $('#PostCommentForm').submit(function() {
        var message = $('#CommentMessage').val();
        postComment(message);
        return false;
    });
});

function postComment(message) {
    if (message.trim()) {
        var request = $.ajax({
            url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'addComment')); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                'post_id' : <?php echo $post['Post']['id']; ?>,
                'message' : message.trim()
            }
        });
        request.done(function(comment) {
            if (comment.Comment) {
                $('#CommentMessage').val('');
                $('#nocomments').remove();

                var html = '<div class="row"><div class="medium-2 columns hide-for-small-only text-right">';
                if (comment.User.id != <?php echo Configure::read('Admin.user_id'); ?>) {
                    html += '<a href="/videos/user/' + comment.User.id + '">';
                    html += '<img src="http://graph.facebook.com/' + comment.User.facebook_id + '/picture?width=100&amp;height=100" style="height:50px;width:50px;margin:0 5px 5px 0;-moz-border-radius:25px;border-radius:25px;border:1px solid #eeeeee;" alt="">';
                    html += '</a>';
                } else {
                    html += '<?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:50px;width:50px;margin:0 5px 5px 0;-moz-border-radius:25px;border-radius:25px;border:1px solid #eeeeee;')); ?>';
                }
                html += '</div>';
                html += '<div class="small-3 medium-2 columns show-for-small-only text-right">';
                if (comment.User.id != <?php echo Configure::read('Admin.user_id'); ?>) {
                    html += '<a href="/videos/user/' + comment.User.id + '">';
                    html += '<img src="http://graph.facebook.com/' + comment.User.facebook_id + '/picture?width=60&amp;height=60" style="height:30px;width:30px;margin:0 5px 5px 0;-moz-border-radius:15px;border-radius:15px;border:1px solid #eeeeee;" alt="">';
                    html += '</a>';
                } else {
                    html += '<?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:30px;width:30px;margin:0 5px 5px 0;-moz-border-radius:15px;border-radius:15px;border:1px solid #eeeeee;')); ?>';
                }
                html += '</div>';
                html += '<div class="small-9 medium-10 columns"><blockquote>';
                var post_ts = moment(comment.Comment.post_ts);
                html += '<small>' + post_ts.format('MM/DD/YYYY hh:mm A') + '</small>';
                html += '<p class="hide-for-small-only">' + comment.Comment.message + '</p>';
                html += '<p class="show-for-small-only"><small>' + comment.Comment.message + '</small></p>';
                html += '</blockquote></div>';
                html += '</div>';
                $('#comments').prepend(html)
            }
        });
        request.fail(function(jqXHR, textStatus) {
            alert("Request failed: " + textStatus);
        });
    }
}

function onYouTubeIframeAPIReady() {
    player = new YT.Player('ytplayer', {
        events: {
            'onStateChange': onPlayerStateChange
        }
    });
}

function onPlayerStateChange() {
    if (player.getPlayerState() == 1) {
        var request = $.ajax({
            url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'addUserHit')); ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                'post_id' : <?php echo $post['Post']['id']; ?>
            }
        });
        request.done(function(response) {

        });
        request.fail(function(jqXHR, textStatus) {

        });
    }
}

function updateSiteChannel(site_channel_id) {
	var request = $.ajax({
		url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'updateSiteChannelId')); ?>',
		type: 'POST',
		dataType: 'json',
		data: {
			'post_id' : <?php echo $post['Post']['id']; ?>,
			'site_channel_id' : site_channel_id
		}
	});
	request.done(function(response) {
		if (response.success) {
            clearAlert();
            showAlert('success', 'Site channel updated.');
		}
	});
	request.fail(function(jqXHR, textStatus) {
		alert("Request failed: " + textStatus);
	});
}

function updateUserChannel(user_channel_id) {
	var request = $.ajax({
		url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'updateUserChannelId')); ?>',
		type: 'POST',
		dataType: 'json',
		data: {
			'post_id' : <?php echo $post['Post']['id']; ?>,
			'user_channel_id' : user_channel_id
		}
	});
	request.done(function(response) {
		if (response.success) {
            clearAlert();
            showAlert('success', 'User channel updated.');
		}
	});
	request.fail(function(jqXHR, textStatus) {
		alert("Request failed: " + textStatus);
	});
}
</script>
