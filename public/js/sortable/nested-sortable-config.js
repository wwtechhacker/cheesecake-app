(function() {

	$(document).ready(function(){


		$('ol.sortable').nestedSortable({
			forcePlaceholderSize: true,
			handle: 'div',
			helper:	'clone',
			items: 'li',
			opacity: .6,
			placeholder: 'placeholder',
			revert: 250,
			tabSize: 25,
			tolerance: 'pointer',
			toleranceElement: '> div',
			maxLevels: 2,

			isTree: true,
			expandOnHover: 700,
			startCollapsed: true
		});

		$('.disclose').on('click', function() {
			$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		})

		$('#submit-changes').submit(function(e){
			e.preventDefault();
			submitChanges();
	    })

	    $('#submit-new').on('click', function(e) {
	    	e.preventDefault();
	    	$('#status').text('Creating.....');
	    	var form = $('#new-object'),
	    		formUrl = form.attr('action'),
	    		NAME = $('#name').val();

	    	$.ajax({
	    		type: "POST",
	    		url: formUrl,
	    		data: form.serializeArray(),
	    		success: function(data) {
	    			var dataSplit = data.split(";");
	    			$('#status').text(dataSplit[0]);

	    			$('#object-list')
	    				.prepend
	    					("<li id=\"list_"+dataSplit[1]+"\"><div style=\"width:200px\"><span class=\"disclose\"><span></span></span>"
	    					  +NAME+"<span style=\"float:right\">"+dataSplit[2]+"</span></div>")
	    		}
	    	});

	    	$('#myModal').modal('toggle')
	    	$(':input', '#new-object').removeAttr('checked').removeAttr('selected')
	    							.not(':button, :submit, :reset, :hidden, :radio, :checkbox')
	    								.val('');
	    });

	    $(document).keydown(function(event) {

		    //19 for Mac Command+S
		    if (!( String.fromCharCode(event.which).toLowerCase() == 's' && event.ctrlKey) && !(event.which == 19)) 
		    			return true;

		    submitChanges();

		    event.preventDefault();
		    return false;
		});

	});

})();

function submitChanges()
{
	$('#status').text("Updating.....");
    //setup variables 
    var form = $('#submit-changes'),  
        formData = $('ol.sortable').nestedSortable('serialize'),  
        formUrl = form.attr('action'),  
        formMethod = form.attr('method');

    $.ajax({
    	type: "POST",
    	url: formUrl,
    	data: formData,
    	success: function(data) {
    			$('#status').text(data);
    		}
    	//dataType: dataType
    });
}

function runSuccess(data)
{
	$('#status').text(data);
}