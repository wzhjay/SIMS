 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function() {
			get_user_profile();
		});

		function get_user_profile() {
			$.ajax({
				type:"post",
			    url:window.api_url + "getCurrentAdmin",
			    data:{},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				            		var Body = $('#user_profile_body');
				 					Body.empty();
				 					Body.append(
				 						'<div class="row">'+
								      		'<div class="col-xs-4">'+ 
								      			'<h2><b>' + reply[key].username + '</b></h2>' +
								      		'</div>' +
								      	'</div>' +
								      	'<hr>' +
								      	'<div class="highlight">' + 
									      	'<div class="row">'+
									      		'<div class="col-xs-4">'+ 
									      			'<label>Email</label>' +
									      			'<div>' + reply[key].email + '</div>' +
									      		'</div>' +
									      		'<div class="col-xs-4">'+ 
									      			'<label>Role</label>' +
									      			'<div>' + reply[key].role + '</div>' +
									      		'</div>' +
									      		'<div class="col-xs-4">'+ 
									      			'<label>Branch</label>' +
									      			'<div>' + reply[key].name + '</div>' +
									      		'</div>' +
									      	'</div>' + 
									      	'<div class="row">'+
									      		'<div class="col-xs-4">'+ 
									      			'<label>Created</label>' +
									      			'<div>' + reply[key].created + '</div>' +
									      		'</div>' +
									      		'<div class="col-xs-4">'+ 
									      			'<label>Modified</label>' +
									      			'<div>' + reply[key].modified + '</div>' +
									      		'</div>' +
									      	'</div>' +
									      	'<div class="row">'+
									      		'<div class="col-xs-4">'+ 
									      			'<label>Role Description</label>' +
									      			'<div>' + reply[key].remark + '</div>' +
									      		'</div>' +
									      	'</div>' +
									    '</div>'
								    );
				            	}
				            }
			        	}
			        }
			    },
			});//End ajax
		}
	</script>
</head>
<?php $this->load->view('partials/systems/system_banner'); ?>
<div class="container">
	<div id="user_profile_body"></div>
</div>