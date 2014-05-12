<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			var users = $('#input_system_unassigned_role_users');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllUnassignedRoleUsers",
			    data:{},
			    success:function(json){
			    	users.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			            		users.append('<option id="new_user_'+ reply[key].id +'">' + reply[key].username + ' (' +  reply[key].email + ')</option>');
			            	}
			            }
			        }else{
			        //alert(message);
			        }
			    },
			});//End ajax

			var roles = $('#input_system_assigned_role');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllAdminRoles",
			    data:{},
			    success:function(json){
			    	roles.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				roles.append('<option id="admin_role'+ reply[key].id +'">' + reply[key].role + '</option>');
			    			}
			    		}
			        }else{
			        //alert(message);
			        }
			    },
			});//End ajax
		});
	</script>
</head>
<div class="highlight">
	<div class="row">
		<form role="form">
			<div id="system_admin_search">
				<div class="col-xs-4">
					<label for="input_system_unassigned_role_users">新注册未分配权限的管理员</label>
					<select class="form-control" id="input_system_unassigned_role_users"></select>
				</div>
				<div class="col-xs-4">
					<label for="input_system_assigned_role">权限分配</label>
					<select class="form-control" id="input_system_assigned_role"></select>
				</div>
			</div>
		</form>
		<div class="col-xs-2">
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="system_admin_role_assign_btn">Assign</a>
		</div>
	</div>
</div>