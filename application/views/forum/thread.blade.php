<div id="breadcrumbs">
	{{ $breadcrumb }}
</div>
<table border="1" cellspacing="5" cellpadding="5">
	<tr>
		<th>Poster</th>
		<th>Content</th>
		<th>ID</th>
	</tr>

	<?php //dd($thread->id); ?>
	
	@foreach ($posts as $post)
			
		<tr>
			<td>
				<?php echo $post->user->name; ?>
			</td>
			<td><?php echo $post->content; ?></td>
			<td>{{ $post->id }}</td>
		</tr>
		
	@endforeach
</table>
<?php if(Auth::user()->has_role('admin','moderator')) { ?>
	<br />
	Moderation Tools:
	<?php if(Authority::can('lock','Thread'))echo HTML::link_to_route('forum.thread.lock','Toggle Lock',array($thread->id)); ?>
<?php } ?>
<br />
<form action="{{ URL::to_route('forum.thread.reply',array($thread->id)); }}" method="post" accept-charset="utf-8">
	
	<label for="content">Reply Content</label><br />
	<textarea rows="20" cols="40" name="content" value="" id="content"/></textarea><br />
	
	<p><input type="submit" value="Post Reply"/></p>
</form>
