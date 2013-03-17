(function() {

	$(document).ready(function(){

		var editname = $('#edit-name'),
			editdescription = $('#edit-description');


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
			expandOnHover: 700
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
	    					("<li id=\"list_"+dataSplit[1]+"\"><div><span class=\"disclose\"><span></span></span>"
	    					  +"<span class=\"object-name\">"+NAME+"</span><span style=\"float:right\">"+dataSplit[2]+"</span></div>");
		
	    		}
	    	});

	    	$('#myModal').modal('toggle')
	    	$(':input', '#new-object').removeAttr('checked').removeAttr('selected')
	    							.not(':button, :submit, :reset, :hidden, :radio, :checkbox')
	    								.val('');

	    	return false;
	    });

	    $(document).keydown(function(event) {

		    //19 for Mac Command+S
		    if (!( String.fromCharCode(event.which).toLowerCase() == 's' && event.ctrlKey) && !(event.which == 19)) 
		    			return true;

		    submitChanges();

		    event.preventDefault();
		    return false;
		});

		$('a[href="#editModal"]').on('click', function(e) {
			e.preventDefault();

			var id = this.id.split(":")[1];
			var ob = $('#editModal'),
				form = $('#edit-object');


			request = ob.attr('data-remote') + "/" + id;


			$.ajax({
				type: "POST",
				url: request,
				data: "gimme, gimme",
				success: function(data) {
					if(data != "fail")
					{
						var dataSplit = data.split("{{;}}");

						editname.val(dataSplit[0]);
						editdescription .val(dataSplit[1]);
						form.attr("action", function(i, val) {
							// console.log(val.length);
							var useVal = "";
							for(i=val.length; i>0;i--)
							{
								if(val[i] == '/')
								{
									useVal = val.substring(0,i);
									break;
								}
							}
							return useVal + "/" + id;
						});

						ob.modal({
							backdrop: true,
							keyboard: true,
							show: true,
							remote: false
						});
					}
					else
					{
						$('#status').text("Query failed. Please try again another time.");
					}
				}
			})

			return false;
		});

		$('.delete-button').on('click', function(e) {
			e.preventDefault();


			var id = this.id.split(":")[1];

			$.ajax({
				type: "POST",
				url: this.href,
				data: id,
				success: function(data) {
					$('#status').text(data);
				}
			})

			return false;
		});

	    $('#submit-edit').on('click', function(e) {
	    	e.preventDefault()
	    	$('#status').text('Updating.....');
	    	var form = $('#edit-object')
	    			$('#editModal').modal("toggle");

	    	$.ajax({
	    		type: "POST",
	    		url: form.attr("action"),
	    		data: form.serializeArray(),
	    		success: function(data) {
	    			var dataSplit = data.split(";");
	    			$('#status').text(dataSplit[0]);

	    			$('#list_'+dataSplit[1]+' .object-name').text(dataSplit[2]);
	    		}
	    	});

	    	return false;
	    });

	    $('#test').on('click', function(e) {
	    	e.preventDefault();

	    	$('#test').popover({
	    		//title: "Are you sure?",
	    		content: '<a href="#del-yes" role="button" class="btn btn-danger delete-yes">Yes</a><a href="#del-no" role="button" class="btn delete-no">No</a>',
	    		html: "html"
	    	});

	    	return false;
	    });

	    $('#delete-yes').on('click', function(e) {
	    	e.preventDefault();

	    	// $.ajax({
	    	// 	type: "POST",
	    	// 	url: 
	    	// });

	    	return false;
	    });
	    $('#del-no').on('click', function(e) {
	    	e.preventDefault();

	    	$('#text').popover("toggle");

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
        formUrl = form.attr('action');

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

