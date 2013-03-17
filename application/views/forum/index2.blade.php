<div id="breadcrumbs">
	{{ $breadcrumb }}
</div>
<table id="forum" border="1" cellspacing="5" cellpadding="5">
	@foreach ($categories as $cat)
		<tr><th colspan="3"><?php echo HTML::link_to_route('forum.category',$cat->name,array($cat->id)); ?></th></tr>
		<?php 
			$boards = $cat->forums; 
		?>
		
		@foreach ($boards as $board)

			<?php 
				$latest_thread = $board->latest_thread;
			 ?>
			
			<tr>
				<td colspan="2"><?php 
						echo "<h5>".HTML::link_to_route('forum.board',$board->name,array($board->id))."</h5>";
						echo $board->description 
					?>
				</td>
				<td>
				@if($latest_thread != null)
					{{ HTML::link_to_route('forum.thread',$latest_thread->title,array($latest_thread->id)) }}
					By {{ $latest_thread->latest_post->user->name }}
				@else
				N/A
				@endif
				</td>
			</tr>
		@endforeach
		
	@endforeach

</table>