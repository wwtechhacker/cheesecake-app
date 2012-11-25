<table border="1" cellspacing="5" cellpadding="5">
	<tr>
		<th>Thread Name</th>
		<th>Post Count</th>
		<th>Latest Poster</th>
	</tr>
	
	@foreach ($threads as $thread)
	
		<?php 
			$latest_username = "N/A";
			$post_count = count($thread->posts()->get());
			$latest_posts = $thread->posts()->order_by('created_at','desc')->get();
			if(count($latest_posts))
			{
				$latest_post = $latest_posts[0];
				try
				{
					$user = Sentry::user($latest_post->user_id);
					$meta = $user->get('metadata');
					$latest_username = $meta["first_name"] . " " . $meta["last_name"];
					//dd($latest_username);
				}
				catch(Sentry\SentryException $e)
				{
					$errors = $e->getMessage(); // Catch errors.
					dd($errors);
				}
			}
			else
			{
				try
				{
					$meta = Sentry::user($thread->user_id)->get('metadata');
					$latest_username = $meta["first_name"] . " " . $meta["last_name"];
				}
				catch(Sentry\SentryException $e)
				{
					$errors = $e->getMessage(); // Catch errors
					dd($errors);				// Dump & Die, bro.
				}
			}
		?>
			
		<tr>
			<td><?php 
				echo HTML::link_to_route('forum.board.thread',$thread->title,
							array($boardid,$thread->id,Str::slug($thread->title,'_'))); 
			?></td>
			<td><?php echo $post_count; ?></td>
			<td><?php echo $latest_username; ?></td>
		</tr>
		
	@endforeach
</table>