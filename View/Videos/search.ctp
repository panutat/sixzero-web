<?php echo $this->element('topbar', array('results_container_id' => 'search-results')); ?>
<div style="min-height:700px;padding:15px;">
	<div id="search-results"></div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	<?php if (!empty($query)) { ?>
	$('#SearchSearchTerms').val('<?php echo $query; ?>');
	$('#SearchSmallSearchTerms').val('<?php echo $query; ?>');
	var query = $('#SearchSearchTerms').val();
	search(query);
	<?php } ?>
});
</script>