$(document).ready(function() {
	//$("tr:odd").addClass("alt");
	$("#table-1").tableDnD({
		onDragClass: "myDragClass",
		onDrop: function(table, row) {

		},
		onDragStart: function(table, row) {
			$('#debug').html("Row: "+row.id+" dragged");
		}
	});
});