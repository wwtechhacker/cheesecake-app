<table border="1" cellspacing="5" cellpadding="5">
	@foreach ($categories as $cat)
		<tr><th colspan="2"><?php echo $cat->name; ?></th></tr>
		<?php $boards = $cat->forums; ?>
		
		@foreach ($boards as $board)
			
			<tr>
				<td><?php 
					echo HTML::link_to_route('forum.board',$board->name,array($board->id)); 
				?></td>
				<td><?php echo $board->description ?></td>
			</tr>
			
		@endforeach
		
	@endforeach
</table>