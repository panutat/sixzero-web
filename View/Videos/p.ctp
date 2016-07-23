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
        <?php if ($post['User']['id'] != Configure::read('Admin.user_id')) { ?>
            <a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $post['User']['id'])); ?>">
                <?php echo $this->Html->image('http://graph.facebook.com/' . $post['User']['facebook_id'] . '/picture?width=100&height=100', array('style' => 'height:100px;width:100px;margin-bottom:20px;-moz-border-radius:50px;border-radius:50px;border:1px solid #eeeeee;')); ?>
            </a>
        <?php } else { ?>
            <?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:100px;width:100px;margin-bottom:20px;-moz-border-radius:50px;border-radius:50px;border:1px solid #eeeeee;')); ?>
        <?php } ?>
        <h6>Author</h6>
        <p><?php echo $post['Post']['channel_title']; ?></p>
        <h6>Published</h6>
        <p><?php echo date('m/d/Y', strtotime($post['Post']['published_ts'])); ?></p>
        <h6>Site Channel</h6>
        <p><?php if (isset($post['SiteChannel']['name'])) { echo $post['SiteChannel']['name']; } else { echo 'N/A'; } ?></p>
        <h6>User Channel</h6>
        <p><?php if (isset($post['UserChannel']['name'])) { echo $post['UserChannel']['name']; } else { echo 'N/A'; } ?></p>
        <h6>Tags</h6>
        <?php if ($post['User']['id'] == $user['User']['id']) { ?>
            <input type="text" name="tags" placeholder="Add new tag..." class="tm-input" />
        <?php } else { ?>
            <?php
            if (!empty($tags)) {
                $tag_arr = explode(',', $tags);
                foreach ($tag_arr as $tag) {
                    echo '<span class="tm-tag">' . $tag . '</span>';
                }
            } else {
                echo 'N/A<br />';
            }
            ?>
        <?php } ?>
    </div>
    <div class="small-12 large-7 columns">
        <div class="youtube-wrapper">
            <iframe src="//www.youtube.com/embed/<?php echo $post['Post']['video_id']; ?>?rel=0" width="560" height="315" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
        </div>
        <h4>Description</h4>
        <?php if (!empty($post['Post']['description'])) { ?>
            <p id="readmore-medium" class="show-for-medium-up"><?php echo $post['Post']['description']; ?></p>
            <p id="readmore-small" class="show-for-small-only"><small><?php echo $post['Post']['description']; ?></small></p>
        <?php } else { ?>
            <p class="show-for-medium-up">N/A</p>
            <p class="show-for-small-only"><small>N/A</small></p>
        <?php } ?>
        <h4>Comments</h4>
        <div class="panel radius">
            <p>No comments.</p>
        </div>
    </div>
    <div class="small-12 large-7 columns hide-for-large-up">
        <h6>Posted By</h6>
        <?php if ($post['User']['facebook_id'] != Configure::read('Admin.facebook_id')) { ?>
            <a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'user', $post['User']['id'])); ?>">
                <?php echo $this->Html->image('http://graph.facebook.com/' . $post['User']['facebook_id'] . '/picture?width=100&height=100', array('style' => 'height:80px;width:80px;margin-bottom:20px;-moz-border-radius:40px;border-radius:40px;border:1px solid #eeeeee;')); ?>
            </a>
        <?php } else { ?>
            <?php echo $this->Html->image('mascot-small.jpg', array('style' => 'height:80px;width:80px;margin-bottom:20px;-moz-border-radius:40px;border-radius:40px;border:1px solid #eeeeee;')); ?>
        <?php } ?>
        <h6>Author</h6>
        <p><?php echo $post['Post']['channel_title']; ?></p>
        <h6>Published</h6>
        <p><?php echo date('m/d/Y', strtotime($post['Post']['published_ts'])); ?></p>
        <h6>Site Channel</h6>
        <p><?php if (isset($post['SiteChannel']['name'])) { echo $post['SiteChannel']['name']; } else { echo 'N/A'; } ?></p>
        <h6>User Channel</h6>
        <p><?php if (isset($post['UserChannel']['name'])) { echo $post['UserChannel']['name']; } else { echo 'N/A'; } ?></p>
        <h6>Tags</h6>
        <?php if ($post['User']['id'] == $user['User']['id']) { ?>
            <input type="text" name="tags" placeholder="Add new tag..." class="tm-input" />
        <?php } else { ?>
            <?php
            if (!empty($tags)) {
                $tag_arr = explode(',', $tags);
                foreach ($tag_arr as $tag) {
                    echo '<span class="tm-tag">' . $tag . '</span>';
                }
            } else {
                echo 'N/A<br />';
            }
            ?>
        <?php } ?>
        <br /><br />
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
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
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
            },
            isDisabled: true
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
        var description = '<?php echo addslashes(substr($description, 0 , 250)); ?>...';
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
    });
</script>