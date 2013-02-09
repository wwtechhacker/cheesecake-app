
<div id="list">
	<ol id="object-list" class="sortable">
 	@foreach($categories as $cat)
 		<?php $boards = $cat->forums; ?>
		<li id="list_{{ $cat->id }}"><div style="width:200px"><span class="disclose"><span></span></span>{{ $cat->name }}<span style="float:right">{{ HTML::link_to_route('admin.forum.edit','[Edit]',array($cat->id)) }}</span></div>
		<ol>

 		@foreach($boards as $board)
 			<li id="list_{{ $board->id }}"><div style="width:200px"><span class="disclose"><span></span></span>{{ $board->name }}<span style="float:right">{{ HTML::link_to_route('admin.forum.edit','[Edit]',array($board->id)) }}</span></div>
 		@endforeach
 		</ol>
 	@endforeach
	</ol>
</div>

<br />
<a href="#myModal" role="button" class="btn" data-toggle="modal">New Forum</a>
<br />
<form id="submit-changes" action="" method="POST" accept-charset="utf-8">
	<p><input type="submit" value="Submit Changes"/></p>
</form>
<br />
<div id="status">
No status to report, Commander.
</div>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">New Forum</h3>
  </div>
  <div class="modal-body">
	<form id="new-object" action="{{ URL::to_route('admin.forum.add') }}" method="POST" accept-charset="utf-8">

		<label for="name">Name</label>
		<input type="text" id="name" name="name" />
		<label for="description">Description</label>
		<input type="text" id="description" name="description"/>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="submit-new">Submit</button>
	</form>
  </div>
</div>

{{ HTML::script('js/sortable/jquery-ui-1.10.0.custom.min.js') }}
{{ HTML::script('js/sortable/nested-sortable.js') }}
{{ HTML::script('js/sortable/nested-sortable-config.js') }}
{{ HTML::script('js/sortable/handling-sortable.js') }}