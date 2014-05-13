<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			
			load_admin_users();
		});

		function load_admin_users() {
			var admins = $('#system_all_admin_table_body');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllAdminUsers",
			    data:{},
			    success:function(json){
			    	admins.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				admins.append('<tr id="user_id_'+ reply[key].user_id +'">' + '<th>' + reply[key].username + '</th>' + '<th>' + reply[key].email + '</th>' + '<th>' + reply[key].name + '</th>' + '<th>' + reply[key].role + '</th>' + '<th>' + reply[key].status + '</th>' + '</tr>');
			    			}
			    		}
			        }else{
			        	alert("fail to load braches");
			        }
			    },
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<div id="system_all_admin">
		<table class="table table-striped">
	      <thead>
	        <tr>
	          <th>Username</th>
	          <th>Email</th>
	          <th>branch</th>
	          <th>Role</th>
	          <th>Status</th>
	        </tr>
	      </thead>
	      <tbody id="system_all_admin_table_body"></tbody>
	    </table>
	</div>
</div>