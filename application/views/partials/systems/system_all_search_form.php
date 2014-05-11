<head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			var target = $('#system_admin_search_results');
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "getAllAdminUsers",
			    data:{},
			    success:function(json){
			    target.children().remove();
			    	if(json != null) {
			        	var reply = $.parseJSON(json);
			            // alert(JSON.stringify(reply));
			            target.append('<p>' + reply.username + '</p>');
			            target.append('<p>' + reply.email + '</p>');
			        }else{
			        //alert(message);
			        }
			    },
			});//End ajax

			$('#system_admin_search_submit').on('click', function() {
				target.append('<div class="loading"></div>');
				// $.ajax({
			 //    	type:"post",
			 //        url:window.api_url + "getAllAdminUsers",
			 //        data:{},
			 //        success:function(json){
			 //        	target.children().remove();
			 //            if(json != null) {
			 //            	var reply = $.parseJSON(json);
			 //            	// alert(JSON.stringify(reply));
			 //            	target.append('<p>' + reply.username + '</p>');
			 //            	target.append('<p>' + reply.email + '</p>');
			 //            }else{
			 //            	//alert(message);
			 //            }
			 //        },
			        
			 //    });//End ajax
			});

			$('#system_admin_search_all').on('click', function() {
				target.append('<div class="loading"></div>');
				$.ajax({
			    	type:"post",
			        url:window.api_url + "getAllAdminUsers",
			        data:{},
			        success:function(json){
			        	target.children().remove();
			            if(json != null) {
			            	var reply = $.parseJSON(json);
			            	// alert(JSON.stringify(reply));
			            	target.append('<p>' + JSON.stringify(reply) + '</p>');
			            }else{
			            	//alert(message);
			            }
			        },
			        
			    });//End ajax
			})
		});
	</script>
</head>
<div class="highlight">
	<div class="row">
		<form role="form">
			<div id="system_admin_search">
				<div class="col-xs-3">
					<label for="input_system_admin_search_username">请输入管理员用户名/邮件：</label>
				</div>
				<div class="col-xs-4">
					<input class="form-control" id="input_system_admin_search_username" placeholder="username/email">
				</div>
				<div class="col-xs-1"></div>
			</div>
		</form>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="system_admin_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="system_admin_search_all">View All</a>
		</div>
	</div>
	<div id="system_admin_search_results"></div>
</div>