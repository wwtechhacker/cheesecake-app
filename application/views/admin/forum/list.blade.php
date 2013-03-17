
<div id="list">
	<ol class="sortable object-list">
 	@foreach($categories as $cat)
 		<?php $boards = $cat->forums; ?>
		<li id="list_{{ $cat->id }}">
      <div>
        <span class="disclose">
          <span></span>
        </span>
        <span class="object-name">{{ $cat->name }}</span>
        <a href="#editModal" role="button" class="btn-mini" id="id:{{ $cat->id }}">[Edit]</a>
        <a href="{{URL::to_route('admin.forum.delete',array($cat->id))}}" role="button" class="btn-mini delete-button" id="id:{{ $cat->id }}">[Delete]</a>
      </div>
  		<ol class="object-list">

   		@foreach($boards as $board)
   			<li id="list_{{ $board->id }}">
            <div>
            <span class="disclose"><span></span></span>
            <span class="object-name">{{ $board->name }}</span>
            <a href="#editModal" role="button" class="btn-mini" id="id:{{ $board->id }}">[Edit]</a> 
            <a href="{{URL::to_route('admin.forum.delete',array($board->id))}}" role="button delete-button" class="btn-mini" id="id:{{ $board->id }}">[Delete]</a>
          </div>
        </li>
   		@endforeach
   		</ol>
   	@endforeach
    </li>
	</ol>
</div>

<br />
<a href="#myModal" role="button" class="btn" data-toggle="modal">New Forum</a>
<br />
<form id="submit-changes" action="" method="POST" accept-charset="utf-8">
	<p><input type="submit" value="Submit Changes"/></p>
</form>
<a href="#lol" id="test" role="button" class="btn">Testing...</a>

<br />
<div id="status">
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

<div id="editModal" class="modal hide fade" tabindex="-1" data-remote="{{ URL::to_route('admin.forum.edit.request') }}" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="editModalLabel">Edit Object</h3>
  </div>
  <div class="modal-body">
	<form id="edit-object" action="{{ URL::to_route('admin.forum.edit') }}/" method="POST" accept-charset="utf-8">

		<label for="name">Name</label>
		<input type="text" id="edit-name" name="name" />
		<label for="description">Description</label>
		<input type="text" id="edit-description" name="description"/>

  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="submit-edit">Submit</button>
	</form>
  </div>
</div>

{{ HTML::script('js/sortable/jquery-ui-1.10.0.custom.min.js') }}
{{ HTML::script('js/sortable/nested-sortable.js') }}
{{ HTML::script('js/sortable/forum/edit-config.js') }}