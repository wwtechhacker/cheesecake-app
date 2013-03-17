<div class="forum">
	<div id="breadcrumbs">
		{{ $breadcrumb }}
	</div>
	@foreach ($categories as $cat)
		<?php 
			$boards = $cat->forums; 
		?>
		<fieldset>

		<legend>
			{{ HTML::link_to_route('forum.category',$cat->name,array($cat->id)) }}
		</legend>
		<table class="forum-table">
			@foreach ($boards as $board)

				<?php 
					$latest_thread = $board->latest_thread;
				 ?>
				
				<tr>
					<td class="forum-table-title">
						<h5>{{ HTML::link_to_route('forum.board',$board->name,array($board->id)) }}</h5>
						{{ $board->description }}
					</td>
					<td class="forum-table-info">
					@if($latest_thread != null)
						<h6>{{ HTML::link_to_route('forum.thread',$latest_thread->title,array($latest_thread->id)) }}</h6>
						By {{ $latest_thread->latest_post->user->name }}
					@else
						N/A
					@endif
					</td>
				</tr>
			@endforeach
		</table>
		</fieldset>
	@endforeach
</div>