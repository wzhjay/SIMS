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
			    				admins.append('<tr id="user_id_'+ reply[key].user_id +'">' + '<th>' + reply[key].username + '</th>' + '<th>' + reply[key].email + '</th>' + '<th>' + reply[key].name + '</th>' + '<th>' + reply[key].role + '</th>' + '<th>' + reply[key].status + '</th>' + '<th><a class="button glow button-rounded button-flat admin-edit" id="admin_edit_' + reply[key].user_id + '" data-toggle="modal" data-target="#admin-edit-model">Edit</a></th>' + '<th><a class="button glow button-rounded button-flat admin-delete" id="admin_delete_' + reply[key].user_id + '" data-toggle="modal" data-target="#admin-del-model">Del</a></th>' + '</tr>');
			    			}
			    		}
			    		edit_click_setting();
			    		del_click_setting();
						
			        }else{
			        	alert("fail to load braches");
			        }
			    },
			});//End ajax
		}

		function edit_click_setting() {
			$.each($('.admin-edit'), function(i, v) {
				$(v).on('click', function() {
					var unsername = $(this).closest('tr').find('th').first().text();
					var el_id = $(this).attr('id').split('_');
					var user_id = el_id[2];
					// alert(user_id);
					var modalBody = $('#adminEdit').closest('.modal-content').find('.modal-body');
					modalBody.children().remove();
					modalBody.append(
						'<div class="row">' + 
							'<div class="col-xs-4">'+ 
								'<label>用户名</label>' +
								'<div>' + unsername + '</div>' +
							'</div>' + 
							'<div class="col-xs-4">' + 
								'<label for="input_system_assigned_role_edit">权限分配</label>' + 
								'<select class="form-control" id="input_system_assigned_role_edit"></select>' + 
							'</div>' +
							'<div class="col-xs-4">' +
								'<label for="input_system_assigned_branch_edit">分部</label>' +
								'<select class="form-control" id="input_system_assigned_branch_edit"></select>' + 
							'</div>' +
						'</div>');
					load_roles_edit();
					load_branches_edit();
				});
			});
		}

		function del_click_setting() {
			$.each($('.admin-delete'), function(i, v) {
				$(v).on('click', function() {
				var unsername = $(this).closest('tr').find('th').first().text();
				var el_id = $(this).attr('id').split('_');
				var user_id = el_id[2];
				// alert(user_id);
				var modalBody = $('#adminDel').closest('.modal-content').find('.modal-body');
				modalBody.children().remove();
				modalBody.append(
					'<div class="row">' + 
						'<div class="col-xs-4">'+
							'<label>用户名</label>' +
							'<div>' + unsername + '</div>' +
						'</div>' + 
					'</div>');
					});
				});
		}

		function load_roles_edit() {
			var roles = $('#input_system_assigned_role_edit');
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
			    				roles.append('<option id="admin_role_'+ reply[key].id +'_edit">' + reply[key].role + '</option>');
			    			}
			    		}
			        }else{
			        	alert("fail to load roles");
			        }
			    },
			});//End ajax
		}

		function load_branches_edit() {
			var branches = $('#input_system_assigned_branch_edit');
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
			    				branches.append('<option id="admin_branch_'+ reply[key].id +'_edit">' + reply[key].name + '</option>');
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

<!-- Edit Modal -->
<div class="modal fade" id="admin-edit-model" tabindex="-1" role="dialog" aria-labelledby="adminEdit" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="adminEdit">Edit</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- Del Modal -->
<div class="modal fade" id="admin-del-model" tabindex="-1" role="dialog" aria-labelledby="adminDel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="adminDel">Delete this admin user?</h4>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>