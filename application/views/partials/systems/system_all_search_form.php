<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			var target = $('#system_admin_search_results');
			$('#system_admin_search_submit').on('click', function() {
				var key_word = $('#input_system_admin_search_username').val();
				target.children().remove();
				target.append('<div class="loading"></div>');
				$.ajax({
			    	type:"post",
			        url:window.api_url + "searchAdminUser",
			        data:{key_word:key_word},
			        success:function(json){
			        	target.children().remove();
			        	target.append('<p>No user found</p>');
			            if(json != null) {
			            	var reply = $.parseJSON(json);
			            	if(reply.length > 0 ) {
			            		target.children().remove();
				            	target.append('<table class="table table-striped"><thead><tr><th>Username</th><th>Email</th><th>branch</th><th>Role</th><th>Status</th></tr></thead><tbody id="system_search_admin_table_body"></tbody></table>');
				            	var table_body = $('#system_search_admin_table_body');
				            	for (var key in reply) {
					    			if (reply.hasOwnProperty(key)) {
					            		table_body.append('<tr id="user_id_'+ reply[key].user_id +'">' + '<th>' + reply[key].username + '</th>' + '<th>' + reply[key].email + '</th>' + '<th>' + reply[key].name + '</th>' + '<th>' + reply[key].role + '</th>' + '<th>' + reply[key].status + '</th>' + '</tr>');
					            	}
					            }
				        	}
			            }else {
			            	alert("fail to call search api");
			            }
			        }
			    });//End ajax
			});	// end of click event
		});
	</script>
</head>
<div class="highlight">
	<div class="row">
		<form role="form">
			<div id="system_admin_search">
				<div class="col-xs-4">
					<label for="input_system_admin_search_username">请输入管理员用户名/邮件关键字：</label>
				</div>
				<div class="col-xs-4">
					<input class="form-control" id="input_system_admin_search_username" placeholder="keyworkd in username/email">
				</div>
			</div>
		</form>
		<div class="col-xs-2">
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="system_admin_search_submit">Search</a>
		</div>
	</div>
	<div id="system_admin_search_results"></div>
</div>