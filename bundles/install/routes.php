<?php 

Route::get('(:bundle)/run', function()
{
	if(!Config::get('site.installed'))
	{
		// Create group rules
		$rules = array(
				//
				//	ADMINISTRATIVE STUFF
				//
					// Root User, hidden access to everything
					'root.access' => 'Hidden root access.',
					// User Admin
					'admin.user' => 'Able to view/edit/delete users.',
					// Group Admin
					'admin.group' => 'Able to view/create/edit/delete groups.',
					// Forum/Category Admin
					'admin.board' => 'Able to create/edit/delete boards.',
					// Thread Admin
					'admin.thread.sticky' => 'Able to sticky a thread.',
					'admin.thread.announce' => 'Able to announce a thread accross all boards',
					'admin.thread.delete' => 'The ability to delete a thread.',
					// Post Admin
					'admin.post' => 'Able to edit and delete the posts of others.',
				//
				//	END ADMINISTRATIVE STUFF
				//
				//	NORMAL STUFF
				//
					'messaging.send' => 'Able to send messages to other users.',
					'thread.post' => 'Able to start new threads.',
					'thread.reply' => 'Able to post replies to threads',
					'normal' => 'Normal abilities. View forum, etc.',
				//
				//	END NORMAL STUFF
				//
				);
		foreach($rules as $key => $value)
		{
			DB::table('rules')->insert(array('rule' => $key,'description' => $value));
		}
		
		try
		{
			// Create groups
			Sentry::group()->create(array('name' => 'member'));
			$group = Sentry::group('member');
			$edit  = $group->update(array(
						'weight' => 2,
						'permissions' => array(
								'messaging.send' => 1,
								'thread.post' => 1,
								'thread.reply' => 1,
								'normal' => 1,
								)
						));
			$group = null;
			Sentry::group()->create(array('name' => 'mod'));
			$group = Sentry::group('mod');
			$edit = $group->update(array(
						'weight' => 1,
						'permissions' => array(
								'admin.thread.sticky' => 1,
								'admin.thread.announce' => 1,
								'admin.thread.delete' => 1,
								'admin.post' => 1,
								'messaging.send' => 1,
								'thread.post' => 1,
								'thread.reply' => 1,
								'normal' => 1,
								)
						));
			$group = null;
			Sentry::group()->create(array('name' => 'admin'));
			$group = Sentry::group('admin');
			$edit = $group->update(array(
						'weight' => 0,
						'permissions' => array(
								'admin.user' => 1,
								'admin.group' => 1,
								'admin.board' => 1,
								'admin.thread.sticky' => 1,
								'admin.thread.announce' => 1,
								'admin.thread.delete' => 1,
								'admin.post' => 1,
								'messaging.send' => 1,
								'thread.post' => 1,
								'thread.reply' => 1,
								'normal' => 1,
								)
						));
			$group = null;
			
			// Create root user
			$vars = array(
				'email'    => 'root@new.co',
				'username' => 'root',
				'password' => 'root',
				'metadata' => array(
					'first_name' => 'Super',
					'last_name'  => 'Admin',
		        ),
				'permissions' => array(
					'root.access' => 1
				)
		    );
			Sentry::logout();
			$user_id = Sentry::user()->create($vars);
			$user = Sentry::user($user_id);
			$user->add_to_group(3);
			return Redirect::home();
		}
		catch(Sentry\SentryException $e)
		{
			$errors = $e->getMessage();		// Catch errors.
			return "Failure";
		}

		Config::set('site.installed','apc');
	}
	return Redirect::home();
});