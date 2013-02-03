<div id="breadcrumbs">
	{{ $breadcrumb }}
</div>
<?php echo HTML::link_to_route('forum.thread.new','New Thread',array($boardid)); ?>
<table border="1" cellspacing="5" cellpadding="5">
	<tr>
		<th>Posted By</th>
		<th>Thread Name</th>
		<th>Post Count</th>
		<th>Latest Poster</th>
	</tr>
	
	@foreach ($threads as $thread)
	
		<?php 
			$latest_username = $thread->latest_poster->name;
			$post_count = $thread->post_count;
		?>
			
		<tr <?php if($thread->stickied)echo 'class="stickied"' ?>>
			<td><?php echo $thread->poster->name; ?></td>
			<td><?php 
				echo HTML::link_to_route('forum.thread',$thread->title,
							array($thread->id)); 
			?></td>
			<td><?php echo $post_count; ?></td>
			<td><?php echo $latest_username; ?></td>
		</tr>
		
	@endforeach
</table>
<?php if(Authority::can('lock','Thread') or Authority::can('sticky','Thread')) { ?>
	<br />
	Moderation Tools:

<?php } ?>