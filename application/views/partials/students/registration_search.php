 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			$('#input_reg_search_from').datepicker({
				format: 'dd/mm/yyyy'
			});
			$('#input_reg_search_to').datepicker({
				format: 'dd/mm/yyyy'
			});

			$('#reg_search_submit').on('click', function() {
				search_reg_info();
			});
		});


		function search_reg_info() {
			var from = '2000-01-01';
			var to  = '2100-01-01';
			if($('#input_reg_search_from').val().trim() != "") {
				from = moment($('#input_reg_search_from').val(), "DD/MM/YYYY").format("YYYY-MM-DD");
			}
			if($('#input_reg_search_to').val().trim() != "") {
				to = moment($('#input_reg_search_to').val(), "DD/MM/YYYY").format("YYYY-MM-DD");
			}
			var target = $('#reg_search_results');
			target.children().remove();
			target.append('<div class="loading"></div>');
			$.ajax({
				type:"post",
			    url:window.api_url + "searchRegistrationInfo",
			    data:{from:from, to:to},
			    success:function(json){
			    	target.children().remove();
			    	target.append('<p>No registration info found</p>');
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
			    			target.children().remove();
				            target.append('<table class="table table-striped"><thead><tr><th>IC</th><th>Register Date</th><th>Register Branch</th><th>Assigned Branch</th><th>Registration No.</th><th>Operator</th><th>Intend to start</th><th>Remark</th></tr></thead><tbody id="reg_search_results_table_body"></tbody></table>');
				            var table_body = $('#reg_search_results_table_body');
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				            		table_body.append('<tr id="reg_search_ic_'+ reply[key].ic + '">' + '<th>' + reply[key].ic + '</th>' + '<th>' + reply[key].reg_date + '</th>' + '<th>' + reply[key].reg_branch + '</th>' + '<th>' + reply[key].assigned_branch + '</th>' + '<th>' + reply[key].reg_no + '</th>' + '<th>' + reply[key].username + '</th>' + '<th>' + reply[key].start_date_wanted + '</th>' + '<th>' + reply[key].remark + '</th>' + '</tr>');
				            	}
				            }
			        	}
			        }
			    },
			});//End ajax
		}
	</script>
</head>
<div class="highlight">
	<div class="row">
		<form role="form">
			<div id="reg_search">
				<div class="input-daterange" id="reg_datepicker">
					<div class="col-xs-4">
						<input class="form-control" id="input_reg_search_from" placeholder="From">
					</div>
					<div class="col-xs-4">
						<input class="form-control" id="input_reg_search_to" placeholder="To">
					</div>
				</div>
			</div>
		</form>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="reg_search_submit">Search</a>
		</div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="reg_to_excel">To Excel</a>
		</div>
	</div>
	<div id="reg_search_results"></div>
</div>