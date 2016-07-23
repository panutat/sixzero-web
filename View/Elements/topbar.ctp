<?php
	if (!isset($results_container_id)) {
		$results_container_id = '';
	}
?>
<nav class="top-bar docs-bar hide-for-small" data-topbar>
    <ul class="title-area">
        <li class="name">
            <h1><a href="http://<?php echo Configure::read('Application.domain'); ?>" style="font-weight:bolder;font-size:30px;"><?php echo $this->Html->image('mascot-logo.png'); ?><font style="color:#3d97c5;">SIX</font><font style="color:#fc942d;">ZERO</font></a></h1>
        </li>
    </ul>
    <section class="top-bar-section">
        <ul class="right">
            <?php if ($user) { ?>
                <li>
                    <?php echo $this->Form->create('Search', array('id' => 'SearchForm')); ?>
                    <div class="row collapse">
                        <div class="small-1 columns">&nbsp;</div>
                        <div class="small-9 columns">
                            <?php echo $this->Form->text('search_terms', array('class' => 'search', 'placeholder' => 'What are you looking for?')); ?>
                        </div>
                        <div class="small-2 columns">
                            <a href="#" id="SearchButton" class="button postfix radius" style="height:30px;padding:0px 10px;width:45px;line-height:30px;">Go</a>
                        </div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </li>
                <li class="has-form">
                    <a href="#" data-reveal-id="PostModal" class="button tiny radius success" style="padding:7px 20px;">Post</a>
                </li>
            <?php } else { ?>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')); ?>" class="button tiny radius success" style="padding:7px 20px;">Login</a>
                </li>
                <li class="has-form">
                    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'register')); ?>" class="button tiny radius warning" style="padding:7px 20px;">Register</a>
                </li>
            <?php } ?>
            <li>
                <a href="http://<?php echo Configure::read('Application.domain'); ?>" class="">Home</a>
            </li>
            <li class="has-dropdown">
                <a href="#" class="">Channels</a>
                <ul class="dropdown">
					<li><?php echo $this->Html->link('My Posts', array('controller' => 'videos', 'action' => 'me')); ?></li>
					<li><?php echo $this->Html->link('Newest', array('controller' => 'home', 'action' => 'index')); ?></li>
                    <li><a href="#">Popular</a></li>
					<li><a href="#">Favorites</a></li>
                    <li><?php echo $this->Html->link('People', array('controller' => 'users', 'action' => 'people')); ?></li>
                </ul>
            </li>
            <?php if ($user) { ?>
                <li class="has-dropdown">
                    <a href="#" class=""><?php echo $this->Html->image('http://graph.facebook.com/' . $user['User']['facebook_id'] . '/picture?type=square', array('style' => 'height:30px;margin-right:5px;-moz-border-radius: 50px;
        border-radius: 50px;')); ?>Settings</a>
                    <ul class="dropdown">
                        <li><?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'profile')); ?></li>
                        <li><?php echo $this->Html->link('Password', array('controller' => 'users', 'action' => 'password')); ?></li>
                        <li><a href="#">Preferences</a></li>
                        <li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </section>
</nav>
<nav class="tab-bar show-for-small">
	<nav class="tab-bar">
		<section class="left-small">
			<a class="left-off-canvas-toggle menu-icon" ><span></span></a>
		</section>
		<section class="right tab-bar-section">
			<span style="font-weight:bolder;font-size:25px;"><?php echo $this->Html->image('mascot-logo.png', array('style' => 'height:35px;')); ?><font style="color:#3d97c5;">SIX</font><font style="color:#fc942d;">ZERO</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
		</section>
	</nav>
</nav>
<aside class="left-off-canvas-menu">
	<ul class="off-canvas-list">
		<li><label class="first">Navigation</label></li>
		<li><a href="http://<?php echo Configure::read('Application.domain'); ?>">Home</a></li>
        <?php if ($user) { ?>
		    <li><a href="#" data-reveal-id="PostModal">Post Video</a></li>
        <?php } else { ?>
            <li style="background-color:#43ac6a;"><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'login')); ?>">Login</a></li>
            <li style="background-color:#ff953f;"><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'register')); ?>">Register</a></li>
        <?php } ?>
		<li><label>Channels</label></li>
		<li><?php echo $this->Html->link('Newest', array('controller' => 'home', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('My Posts', array('controller' => 'videos', 'action' => 'me')); ?></li>
		<!--
		<li><a href="#">Popular</a></li>
		<li><a href="#">Favorites</a></li>
		-->
		<li><?php echo $this->Html->link('People', array('controller' => 'users', 'action' => 'people')); ?></li>
        <?php if ($user) { ?>
		<li><label>Settings</label></li>
        <li><?php echo $this->Html->link('Profile', array('controller' => 'users', 'action' => 'profile')); ?></li>
        <li><?php echo $this->Html->link('Password', array('controller' => 'users', 'action' => 'password')); ?></li>
		<li><a href="#">Preferences</a></li>
		<li style="background-color:#f04124;"><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?></li>
        <?php } ?>
	</ul>
</aside>
<a class="exit-off-canvas"></a>
<div class="show-for-small">
	<?php echo $this->Form->create('SearchSmall', array('id' => 'SearchFormSmall', 'style' => 'margin-bottom:0px;')); ?>
	<div class="row collapse">
		<div class="small-10 columns">
			<?php echo $this->Form->text('search_terms', array('placeholder' => 'What are you looking for?', 'style' => 'margin-bottom:0px;')); ?>
		</div>
		<div class="small-2 columns">
			<a href="#" id="SearchSmallButton" class="button postfix" style="margin-bottom:0px;">Go</a>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<div id="PostModal" class="reveal-modal small" data-reveal>
	<h2>Post New Video</h2>
	<p>Enter YouTube URL below</p>
	<?php echo $this->Form->create('Post', array('id' => 'PostForm')); ?>
	<div class="row collapse">
		<div class="small-12 columns">
			<?php echo $this->Form->text('url', array('placeholder' => 'http://youtu.be/XXXXXXXXXXX')); ?>
		</div>
		<div class="medium-12 large-6 columns">
			<?php
				$channel_ids = array();
				foreach ($admin_channels as $admin_channel) {
					$channel_ids[$admin_channel['Channel']['id']] = $admin_channel['Channel']['name'];
				}
			?>
			<?php echo $this->Form->select('site_channel_id', $channel_ids, array('empty' => 'Select a site channel')); ?>
		</div>
		<div class="medium-12 large-6 columns">
			<?php
				$channel_ids = array();
				foreach ($user_channels as $user_channel) {
					$channel_ids[$user_channel['Channel']['id']] = $user_channel['Channel']['name'];
				}
			?>
			<?php echo $this->Form->select('user_channel_id', $channel_ids, array('empty' => 'Select a user channel')); ?>
		</div>
		<div class="small-12 columns">
			<a href="#" id="PostButton" class="button small-12 radius success">Post</a>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
		<!--
    <div class="show-for-large-only">
        <p>Or Upload a New Video to YouTube</p>
        <div class="youtube-wrapper">
            <div id="widget"></div>
            <div id="player"></div>
        </div>
        <script>
            // 2. Asynchronously load the Upload Widget and Player API code.
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            // 3. Define global variables for the widget and the player.
            //    The function loads the widget after the JavaScript code
            //    has downloaded and defines event handlers for callback
            //    notifications related to the widget.
            var widget;
            var player;
            function onYouTubeIframeAPIReady() {
                widget = new YT.UploadWidget('widget', {
                    width: 500,
                    events: {
                        'onUploadSuccess': onUploadSuccess,
                        'onProcessingComplete': onProcessingComplete
                    }
                });
            }

            // 4. This function is called when a video has been successfully uploaded.
            function onUploadSuccess(event) {
                $('#PostUrl').val('http://youtu.be/' + event.data.videoId);
            }

            // 5. This function is called when a video has been successfully
            //    processed.
            function onProcessingComplete(event) {
                player = new YT.Player('player', {
                    height: 390,
                    width: 640,
                    videoId: event.data.videoId,
                    events: {}
                });
            }
        </script>
    </div>
	-->
	<a class="close-reveal-modal">&#215;</a>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#SearchButton').click(function() {
		var query = $('#SearchSearchTerms').val();
		$('#SearchSmallSearchTerms').val(query);
		document.activeElement.blur();
		$("input").blur();
		search(query, 'SearchSearchTerms');
	});
	$('#SearchForm').submit(function() {
		var query = $('#SearchSearchTerms').val();
		$('#SearchSmallSearchTerms').val(query);
		document.activeElement.blur();
		$("input").blur();
		search(query, 'SearchSearchTerms');
		return false;
	});
	$('#SearchSmallButton').click(function() {
		var query = $('#SearchSmallSearchTerms').val();
		$('#SearchSearchTerms').val(query);
		document.activeElement.blur();
		$("input").blur();
		search(query, 'SearchSmallSearchTerms');
	});
	$('#SearchFormSmall').submit(function() {
		var query = $('#SearchSmallSearchTerms').val();
		$('#SearchSearchTerms').val(query);
		document.activeElement.blur();
		$("input").blur();
		search(query, 'SearchSmallSearchTerms');
		return false;
	});
	$(document).on('opened', '[data-reveal]', function () {
		var modal = $(this);
		if (modal.attr('id') == 'PostModal') {
			$('#PostUrl').focus();
		}
	});
	$('#PostButton').click(function() {
		var url = $('#PostUrl').val();
		var site_channel_id = $('#PostSiteChannelId').val();
		var user_channel_id = $('#PostUserChannelId').val();
		post(url, site_channel_id, user_channel_id);
	});
	$('#PostForm').submit(function() {
		var url = $('#PostUrl').val();
		var site_channel_id = $('#PostSiteChannelId').val();
		var user_channel_id = $('#PostUserChannelId').val();
		post(url, site_channel_id, user_channel_id);
		return false;
	});
});
function post(url, site_channel_id, user_channel_id) {
	var request = $.ajax({
		url: '<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'post')); ?>',
		type: 'POST',
		dataType: 'json',
		data: {
			'url' : url,
			'site_channel_id' : site_channel_id,
			'user_channel_id' : user_channel_id
		}
	});
	request.done(function(response) {
		if (response.success) {
			$('#PostUrl').val('');
			$('#PostModal').foundation('reveal', 'close');
			window.location.href = "<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'me')); ?>";
		}
	});
	request.fail(function(jqXHR, textStatus) {
		alert("Request failed: " + textStatus);
	});
}
function search(query, field_id) {
	<?php if (!empty($results_container_id)) { ?>
		var request = $.ajax({
			url: '<?php echo $this->Html->url(array('controller' => 'search', 'action' => 'index')); ?>',
			type: 'POST',
			dataType: 'json',
			data: {
				'query' : query
			}
		});
		request.done(function(response) {
			renderSearchResults(response);
		});
		request.fail(function(jqXHR, textStatus) {
			alert("Request failed: " + textStatus);
		});
	<?php } else { ?>
		window.location.href = "<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'search')); ?>/" + encodeURIComponent($('#' + field_id).val());
	<?php } ?>
}
function renderSearchResults(response) {
	$('#<?php echo $results_container_id; ?>').html('<h3>Search Results</h3>');
	if (response.items.length) {
		$.each(response.items, function(index, video) {
			$('#<?php echo $results_container_id; ?>').append(buildSearchResultListItem(video));
		});
	} else {
		$('#<?php echo $results_container_id; ?>').html('<div data-alert class="alert-box warning radius">No results were found.</div>');
	}
}
function buildSearchResultListItem(video) {
	var html = '<div class="small-3 left show-for-large-up">';
	html += '<div class="summary">';
	html += '<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'yt')); ?>/' + video.id.videoId + '">';
	html += '<img src="' + video.snippet.thumbnails.medium.url + '" class="small-12" />';
	html += '</a>';
	html += '<div class="info clear">';
	html += '<h6>' + video.snippet.title.substring(0, 50) + '</h6>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	html += '<div class="small-4 left show-for-medium-only">';
	html += '<div class="summary">';
	html += '<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'yt')); ?>/' + video.id.videoId + '">';
	html += '<img src="' + video.snippet.thumbnails.medium.url + '" class="small-12" />';
	html += '</a>';
	html += '<div class="info clear">';
	html += '<h6>' + video.snippet.title.substring(0, 50) + '</h6>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	html += '<div class="small-12 left show-for-small-only">';
	html += '<div class="summary">';
	html += '<a href="<?php echo $this->Html->url(array('controller' => 'videos', 'action' => 'yt')); ?>/' + video.id.videoId + '">';
	html += '<img src="' + video.snippet.thumbnails.medium.url + '" class="small-12" />';
	html += '</a>';
	html += '<div class="info clear">';
	html += '<h6>' + video.snippet.title.substring(0, 50) + '</h6>';
	html += '</div>';
	html += '</div>';
	html += '</div>';
	return html;
}
</script>
