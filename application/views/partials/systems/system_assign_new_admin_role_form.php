<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			load_users();
			load_roles();
			load_branches();

			$('#system_admin_role_assign_btn').on('click', function() {
				event.preventDefault();
				var user = $('option:selected', '#input_system_unassigned_role_users').attr('id').split('_');
				var user_id = user[2];
				var role = $('option:selected', '#input_system_assigned_role').attr('id').split('_');
				var role_id = role[2];
				var branch = $('option:selected', '#input_system_assigned_branch').attr('id').split('_');
				var branch_id = branch[2];
				var status_id = 1; // activate
				// toastr.error(user_id + " " + roel_id + " " + branch_id + " " + status_id);
				$.ajax({
					type:"post",
				    url:window.api_url + "createNewAdmin",
				    data:{user_id:user_id,role_id:role_id,branch_id:branch_id,status_id:status_id},
				    success:function(json){
				    	if(json != null) {
					    	var reply = $.parseJSON(json);
					    	// toastr.error(reply);
					    	if(reply == '1') {
					    		load_users();
					        }else{
					        	toastr.error("fail to call sql query");
					        }
					    }
					    else {
					    	toastr.error("fail to call insert user api");
					    }
					    load_admin_users();
				    },
				});//End ajax
			});
		});

		function load_users() {
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
			        	toastr.error("fail to load users");
			        }
			    },
			});//End ajax
		}

		function load_roles() {
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
			    				roles.append('<option id="admin_role_'+ reply[key].id +'">' + reply[key].role + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("fail to load roles");
			        }
			    },
			});//End ajax
		}

		function load_branches() {
			var branches = $('#input_system_assigned_branch');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllBranches",
			    data:{},
			    success:function(json){
			    	branches.children().remove();
			    	if(json != null) {
			    		var reply = $.parseJSON(json);
			    		for (var key in reply) {
			    			if (reply.hasOwnProperty(key)) {
			    				branches.append('<option id="admin_branch_'+ reply[key].id +'">' + reply[key].name + '</option>');
			    			}
			    		}
			        }else{
			        	toastr.error("fail to load braches");
			        }
			    },
			});//End ajax
		}
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
				<div class="col-xs-2">
					<label for="input_system_assigned_role">权限分配</label>
					<select class="form-control" id="input_system_assigned_role"></select>
				</div>
				<div class="col-xs-3">
					<label for="input_system_assigned_branch">分部</label>
					<select class="form-control" id="input_system_assigned_branch"></select>
				</div>
			</div>
		</form>
		<div class="col-xs-1">
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="system_admin_role_assign_btn">Assign</a>
		</div>
	</div>
</div>