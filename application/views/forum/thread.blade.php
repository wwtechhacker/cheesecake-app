<div id="breadcrumbs">
	{{ $breadcrumb }}
</div>
<table id="forum" border="1" cellspacing="5" cellpadding="5">
	<tr>
		<th>Poster</th>
		<th>Content</th>
	</tr>

	<?php //dd($thread->id); ?>
	
	@foreach ($posts as $post)
			
		<tr>
			<td>
				<?php echo $post->user->name; ?>
			</td>
			<td><?php echo $post->content; ?></td>
		</tr>
		
	@endforeach
</table>
@if(Auth::user()->has_any_role('admin','moderator'))
	<br />
	Moderation Tools:
	@if(Authority::can('lock','Thread'))
		{{ HTML::link_to_route('forum.thread.lock','Toggle Lock',array($thread->id)) }}
	@endif
@endif
<br />
<form action="{{ URL::to_route('forum.thread.reply',array($thread->id)); }}" method="post" accept-charset="utf-8">
	
	<label for="content">Reply Content</label><br />
	<textarea rows="10" cols="48" name="content" value="" id="content"/></textarea><br />
	
	<p><input type="submit" value="Post Reply"/></p>
</form>
