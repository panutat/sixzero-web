<?php echo $this->element('topbar', array()); ?>
<div style="min-height:700px;padding:15px;">
	<div class="show-for-medium-only">&nbsp;</div>
	<?php echo $this->element('channel', array('channel' => $channel['Channel']['id'])); ?>
	<h3><?php echo $channel['Channel']['name'] ?></h3>
    <div id="posts" class="clearfix"></div>
    <div class="row" style="margin-top:20px;">
        <div class="medium-3 large-4 hide-for-small-only columns">&nbsp;</div>
        <div class="small-12 medium-6 large-4 columns">
            <?php echo $this->Form->button('Show Me More', array('id' => 'show-more-button', 'class' => 'button small small-12 radius secondary')); ?>
        </div>
        <div class="medium-3 large-4 hide-for-small-only columns">&nbsp;</div>
    </div>
</div>
<script type="text/javascript">
    var limit = 16;
    var page = 1;
    var channel_id = <?php if (isset($channel)) { echo $channel['Channel']['id']; } else { echo 0; } ?>;
    var loaded = 0;
    $(document).ready(function() {
        $('#show-more-button').click(function() {
            var request = $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'channelAjax')); ?>',
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
                    if (post.SiteChannel.id) {
                        html += '<div class="channel">' + post.SiteChannel.name + '</div>';
                    }
                    html += '<div class="duration">' + post.Post.duration.toHHMMSS() + '</div>';
                    html += '<a href="/videos/detail/' + post.Post.id + '">';
                    html += '<img src="' + post.Post.thumbnail_url + '" class="small-12" />';
                    html += '</a>';
                    html += '<div class="info clear">';
                    if (post.User.id != <?php echo Configure::read('Admin.user_id'); ?>) {
                        html += '<a href="/videos/user/' + post.User.id + '">';
                        html += '<img src="http://graph.facebook.com/' + post.User.facebook_id + '/picture?type=square" style="margin-top:5px;float:right;" class="thumb" />';
                        html += '</a>';
                    } else {
                        html += '<img src="/img/mascot-small.jpg" style="height:40px;margin-top:5px;float:right;" class="thumb" />';
                    }
                    html += '<h6>' + post.Post.title.substring(0, 50) + '</h6>';
                    html += '</div>';
                    html += '<div class="stats">';
                    html += post.Post.hit_count + ' Views &nbsp; ' + post.Post.comment_count + ' Comments';
                    html += '<div class="right">&nbsp;(' + post.Post.rating_count + ')</div><div class="basic right" data-average="' + post.Post.rating_avg + '" data-id="1"></div>';
                    html += '</div>';
                    html += '</div></div>';


                    html += '<div id="post_' + post.Post.id + '" class="small-6 left show-for-medium-only"><div class="summary">';
                    if (post.SiteChannel.id) {
                        html += '<div class="channel">' + post.SiteChannel.name + '</div>';
                    }
                    html += '<div class="duration">' + post.Post.duration.toHHMMSS() + '</div>';
                    html += '<a href="/videos/detail/' + post.Post.id + '">';
                    html += '<img src="' + post.Post.thumbnail_url + '" class="small-12" />';
                    html += '</a>';
                    html += '<div class="info clear">';
                    if (post.User.id != <?php echo Configure::read('Admin.user_id'); ?>) {
                        html += '<a href="/videos/user/' + post.User.id + '">';
                        html += '<img src="http://graph.facebook.com/' + post.User.facebook_id + '/picture?type=square" style="margin-top:5px;float:right;" class="thumb" />';
                        html += '</a>';
                    } else {
                        html += '<img src="/img/mascot-small.jpg" style="height:40px;margin-top:5px;float:right;" class="thumb" />';
                    }
                    html += '<h6>' + post.Post.title.substring(0, 50) + '</h6>';
                    html += '</div>';
                    html += '<div class="stats">';
                    html += post.Post.hit_count + ' Views &nbsp; ' + post.Post.comment_count + ' Comments';
                    html += '<div class="right">&nbsp;(' + post.Post.rating_count + ')</div><div class="basic right" data-average="' + post.Post.rating_avg + '" data-id="1"></div>';
                    html += '</div>';
                    html += '</div></div>';


                    html += '<div id="post_' + post.Post.id + '" class="small-12 left show-for-small-only"><div class="summary">';
                    if (post.SiteChannel.id) {
                        html += '<div class="channel">' + post.SiteChannel.name + '</div>';
                    }
                    html += '<div class="duration">' + post.Post.duration.toHHMMSS() + '</div>';
                    html += '<a href="/videos/detail/' + post.Post.id + '">';
                    html += '<img src="' + post.Post.thumbnail_url + '" class="small-12" />';
                    html += '</a>';
                    html += '<div class="info clear">';
                    if (post.User.id != <?php echo Configure::read('Admin.user_id'); ?>) {
                        html += '<a href="/videos/user/' + post.User.id + '">';
                        html += '<img src="http://graph.facebook.com/' + post.User.facebook_id + '/picture?type=square" style="margin-top:5px;float:right;" class="thumb" />';
                        html += '</a>';
                    } else {
                        html += '<img src="/img/mascot-small.jpg" style="height:40px;margin-top:5px;float:right;" class="thumb" />';
                    }
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
    });
</script>