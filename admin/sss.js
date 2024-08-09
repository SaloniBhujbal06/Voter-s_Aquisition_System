function delete_cat(cid = null) {
	if(cid) {
		var r = confirm("Are You Sure To Delete Catagory?");
		if(r==true){
			$.ajax({
				url: './delete_cat.php',
				type: 'post',
				data: {cid : cid},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {
						 location.reload();
						 alert("Catagory Deleted Successfully!");
						 $("#mes").html("ookkk");
					} else {
					} // /else
				} // /success
			});  // /ajax function to remove the order
	} else{
		location.reload();
	}
	}
	else {
		alert('error! refresh the page again');
	}	
}
function delete_post(pid = null) {
	if(pid) {
		var r = confirm("Are You Sure To Delete Post?");
		if(r==true){
			$.ajax({
				url: './delete_post.php',
				type: 'post',
				data: {pid : pid},
				dataType: 'json',
				success:function(response) {
					if(response.success == true) {
						 location.reload();
						 alert("Post Deleted Successfully!");
						 $("#mes").html("ookkk");
					} else {
					} // /else
				} // /success
			});  // /ajax function to remove the order
	} else{
		location.reload();
	}
	}
	else {
		alert('error! refresh the page again');
	}	
}