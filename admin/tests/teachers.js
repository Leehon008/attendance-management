$( document ) .ready( function () {
	
	get_teachers();
	
	function get_teachers () {
		$.ajax({
			url 		: 'entry.php',
			method		: 'GET',
			dataType 	: 'json',
			success 	: function ( data ) {
				let element = $( '#teachers' );
				
				element.DataTable().clear();
				
				element.DataTable({
					"data"		: data,
					"destroy"	: true,
					columns 	: [
						{ title 	: "Name" },
						{ title 	: "Email" },
						{ title 	: "Update" },
						{ title 	: "Delete" }	
					], columns 	: [
						{ "data"	: "teacher_name" },
						{ "data"	: "teacher_email" },
						{
							"mRender": function( data, type, row ) {
								return 'button type="button" id="' + row.teacher_id +
								 '" class="btn btn-warning btn-xs update">Update</button>';
                            }
						},
						{
							"mRender": function( data, type, row ) {
								return 'button type="button" id="' + row.teacher_id + 
								'" class="btn btn-danger btn-xs delete">Delete</button>';
                            }
						}
						
					]
				});
			},error 	: function ( xhr, type ) {
				console.log( xhr, type );
			}
		});
	}
});
