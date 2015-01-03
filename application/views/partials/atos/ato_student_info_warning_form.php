<head>
	<meta charset="utf-8">

	<script>
	var global_ic_selected = "";
		$(document).ready(function($) {
			$('#exam_student_new_info_form').parsley();
			$('#input_student_new_bd').datepicker({
				format: 'yyyy-mm-dd',
				todayHighlight: true
			});

			load_student_info_warning_list();

			$('#student_info_modal_confirm').on('click', function() {
		    	// 1. check student basic existed or not, create or update studnet info
		    	update_create_student_baisc_info(global_ic_selected);
		    });
		});

		function load_student_info_warning_list() {
			var results = $('#student_info_warning_list');
			results.empty();
			$.ajax({
				type:"post",
			    url:window.api_url + "getStudentInfoWarningList",
			    data:{},
			    success:function(json){
			    	if(json.trim() != "") {
			    		var reply = $.parseJSON(json);
			    		if(reply.length > 0) {
				    		for (var key in reply) {
				    			if (reply.hasOwnProperty(key)) {
				 					results.append(
				 						'<div class="row">'+
								      		'<div class="col-xs-4">'+ 
												'<a id="student_info_warning_'+reply[key].ic+'">IC: ' + reply[key].ic + '</a>' +
											'</div>' + 
								      	'</div>'
								    );
				            	}
				            }
			        	}
			        }

			        $('#student_info_warning_list a').on('click', function() {
				    	var ic = $(this).attr('id').split("_")[3];
				    	global_ic_selected = ic;
				    	loading_student_basic_info();
				    });
			    }
			});//End ajax
		}

		function loading_student_basic_info() {
			ic = global_ic_selected;
			$.ajax({
				type:"post",
			    url:window.api_url + "getStudentByIC",
			    data:{ic:ic},
			    success:function(json){
			    	var modalBody = $('#student_info_modal_label').closest('.modal-content').find('.modal-body');
			    	if(json.trim() != "") {
			    		$('#student-info-modal').modal('show');
			    		var reply = $.parseJSON(json);
				    	for (var key in reply) {
					    	if (reply.hasOwnProperty(key)) {
								$('#input_student_new_source').val(reply[key].source);
								(reply[key].gov_letter == "YES") ? $('#input_student_new_gov_letter').prop('checked', true) : $('#input_student_new_gov_letter').prop('checked', false);
								$('#input_student_new_ic').val(reply[key].ic);
								$('#input_student_new_ic_type option[value="'+reply[key].ic_type+'"]').attr('selected', 'selected');

								$('#input_student_new_fn').val(reply[key].firstname);
								$('#input_student_new_ln').val(reply[key].lastname);
								$('#input_student_new_on').val(reply[key].othername);
								$('#input_student_new_tel').val(reply[key].tel);
								$('#input_student_new_tel_home').val(reply[key].tel_home);
								$('#input_student_new_gender').val(reply[key].gender);
								$('#input_student_new_sal option[value="'+reply[key].salutation+'"]').attr('selected', 'selected');
								$('#input_student_new_bd').val(reply[key].birthday);
								$('#input_student_new_age').val(reply[key].age);
								$('#input_student_new_citizenship option[value="'+reply[key].citizenship+'"]').attr('selected', 'selected');
								$('#input_student_new_nationality option[value="'+reply[key].nationality+'"]').attr('selected', 'selected');
								$('#input_student_new_race option[value="'+reply[key].race+'"]').attr('selected', 'selected');
								$('#input_student_new_cnlevel option[value="'+reply[key].cn_level+'"]').attr('selected', 'selected');
								$('#input_student_new_edulevel option[value="'+reply[key].edu_level+'"]').attr('selected', 'selected');
								$('#input_student_new_lang option[value="'+reply[key].lang+'"]').attr('selected', 'selected');

								// address
								$('#input_student_new_blk').val(reply[key].block);
								$('#input_student_new_street').val(reply[key].street);
								$('#input_student_new_floor_unit').val(reply[key].floor_unit_no);
								$('#input_student_new_building').val(reply[key].building);
								$('#input_student_new_postcode').val(reply[key].postcode);

								// employment
								$('#input_student_new_empstatus option[value="'+reply[key].emp_status+'"]').attr('selected', 'selected');
								$('#input_student_new_comn').val(reply[key].company_name);
								$('#input_student_new_com_type option[value="'+reply[key].company_type+'"]').attr('selected', 'selected');
								$('#input_student_new_com_reg_no').val(reply[key].company_reg_no);
								$('#input_student_new_industry option[value="'+reply[key].industry+'"]').attr('selected', 'selected');
								$('#input_student_new_designation option[value="'+reply[key].designation+'"]').attr('selected', 'selected');
								$('#input_student_new_sal_range option[value="'+reply[key].salary_range+'"]').attr('selected', 'selected');

								// extra
								// $('#input_student_new_branch option[id="student_new_branch_'+reply[key].student_branch_id+'"]').attr('selected', 'selected');
								// $('#input_student_new_op option[id="student_new_user_'+reply[key].student_op_id+'"]').attr('selected', 'selected');
								$('#input_student_new_remark').val(reply[key].student_remark);
							}
				    	}
				    }
				    else {
				    	// check from registration table, insert bisic info for this new student
				    	$.ajax({
							type:"post",
						    url:window.api_url + "getRegistrationByIC",
						    data:{ic:ic},
						    success:function(json){
						    	$('#student-info-fail-modal').modal('show');
						    	var modalBody = $('#student_info_fail_modal_label').closest('.modal-content').find('.modal-body');
						    	modalBody.empty();
						    	if(json.trim() != "") {
						    		var reply = $.parseJSON(json);
							    	for (var key in reply) {
								    	if (reply.hasOwnProperty(key)) {
											modalBody.append(
												'<div class="row">' + 
													'Stundet had registered, please insert basic info!' + 
												'</div>' +
												'<div class="row">' + 
													'<div class="col-xs-4" id="student_new_ic_check_model_ic">'+ 
														'<label>IC Number Input</label>' +
														'<div class="form-control">' + ic + '</div>' +
													'</div>' + 
													'<div class="col-xs-4">' + 
														'<label for="student_new_ic_check_model_reg_date">注册日期</label>' + 
														'<div class="form-control" id="student_new_ic_check_model_reg_date">' + reply[key].reg_date + '</div>' + 
													'</div>' +
													'<div class="col-xs-4">' +
														'<label for="student_new_ic_check_model_reg_no">注册表号码</label>' +
														'<div class="form-control" id="student_new_ic_check_model_reg_no">'+ reply[key].reg_no + '</div>' + 
													'</div>' +
												'</div>' +
												'<div class="row">' +
													'<div class="col-xs-10"></div>' +
													'<div class="col-xs-2">' +
														'<a class="button glow button-rounded button-flat" id="new_student_info_btn">Add</a>' +
													'</div>' +
												'</div>'
											);
								        }
							    	}
							    	$('#new_student_info_btn').on('click', function() {
							    		$('#student-info-fail-modal').modal('hide');
							    		$('#student-info-modal').modal('show');
							    		clear_student_new_form_inputs();
							    		$('#input_student_new_ic').val(ic);
							    	})
							    }
							    else {
							    	// no result found in student and registartion table
							    	if(ic.trim() == "") {
							    		ic='NULL';
							    	};
									modalBody.append(
										'<div class="row">' + 
											'<div class="col-xs-4" id="student_new_ic_check_model_ic">'+ 
												'<label>IC Number Input</label>' +
												'<div class="form-control">' + ic + '</div>' +
											'</div>' + 
											'<div class="col-xs-8">' + 
												'<label>Sorry, no related registration info found!<br>Please input valid IC number or register fisrt.</label>' + 
											'</div>' + 
										'</div>'
									);
								}
						    }
						});//End ajax
					}
				}
			});//End ajax
		}

		function create_new_student_basic_info() {
		var source = $('#input_student_new_source').val();
		var gov_letter = $('#input_student_new_gov_letter').is(':checked') ? 'YES' : 'NO';
		var ic = $('#input_student_new_ic').val();
		var ic_type = $('#input_student_new_ic_type').val();
		var firstname = $('#input_student_new_fn').val();
		var lastname = $('#input_student_new_ln').val();
		var othername = $('#input_student_new_on').val();
		var tel = $('#input_student_new_tel').val();
		var tel_home = $('#input_student_new_tel_home').val();
		var gender = $('#input_student_new_gender').val();
		var salutation = $('#input_student_new_sal').val();
		var birthday = $('#input_student_new_bd').val();
		var age = $('#input_student_new_age').val();
		var citizenship = $('#input_student_new_citizenship').val();
		var nationality = $('#input_student_new_nationality').val();
		var race = $('#input_student_new_race').val();
		var cn_level = $('#input_student_new_cnlevel').val();
		var edu_level = $('#input_student_new_edulevel').val();
		var lang = $('#input_student_new_lang').val();

		// address
		var blk = $('#input_student_new_blk').val();
		var street = $('#input_student_new_street').val();
		var floor_unit_no = $('#input_student_new_floor_unit').val();
		var building = $('#input_student_new_building').val();
		var postcode = $('#input_student_new_postcode').val();

		// employment
		var emp_status = $('#input_student_new_empstatus').val();
		var company_name = $('#input_student_new_comn').val();
		var company_type = $('#input_student_new_com_type').val();
		var company_reg_no = $('#input_student_new_com_reg_no').val();
		var industry = $('#input_student_new_industry').val();
		var designation = $('#input_student_new_designation').val();
		var salary_range = $('#input_student_new_sal_range').val();

		// extra
		// var student_branch = $('#input_student_new_branch option:selected').attr('id').split('_');
		// var student_branch_id = student_branch[3];
		// var student_op = $('#input_student_new_op option:selected').attr('id').split('_');
		// var student_op_id = student_op[3];
		var student_remark  = $('#input_student_new_remark').val();

		$.ajax({
			type:"post",
		    url:window.api_url + "createStudentBasicInfo",
		    data:{	source:source,
		    		gov_letter:gov_letter, 
		    		ic:ic, 
		    		ic_type:ic_type, 
		    		firstname:firstname, 
		    		lastname:lastname, 
		    		othername:othername,
		    		tel:tel,
		    		tel_home:tel_home,
		    		gender:gender,
		    		salutation:salutation,
		    		birthday:birthday, 
		    		age:age,
		    		citizenship:citizenship,
		    		nationality:nationality,
		    		race:race,
		    		cn_level:cn_level,
		    		edu_level:edu_level,
		    		lang:lang,
		    		blk:blk,
		    		street:street,
		    		floor_unit_no:floor_unit_no,
		    		building:building,
		    		postcode:postcode,
		    		emp_status:emp_status,
		    		company_name:company_name,
		    		company_type:company_type,
		    		company_reg_no:company_reg_no,
		    		industry:industry,
		    		designation:designation,
		    		salary_range:salary_range,
		    		// student_branch_id:student_branch_id,
		    		// student_op_id:student_op_id,
		    		student_remark:student_remark},
		    success:function(json){
		    	if(json.trim() == '1') {
				    toastr.success("Create student basic info success!");
				    clear_student_new_form_inputs();
				    $('#student-info-modal').modal('hide');
				    load_student_info_warning_list();
				}else{
					toastr.error("Fail to create student basic info!");
				}
		    }
		});//End ajax
	}

	function update_student_basic_info(student_id) {
		var source = $('#input_student_new_source').val();
		var gov_letter = $('#input_student_new_gov_letter').is(':checked') ? 'YES' : 'NO';
		var ic = $('#input_student_new_ic').val();
		var ic_type = $('#input_student_new_ic_type').val();
		var firstname = $('#input_student_new_fn').val();
		var lastname = $('#input_student_new_ln').val();
		var othername = $('#input_student_new_on').val();
		var tel = $('#input_student_new_tel').val();
		var tel_home = $('#input_student_new_tel_home').val();
		var gender = $('#input_student_new_gender').val();
		var salutation = $('#input_student_new_sal').val();
		var birthday = $('#input_student_new_bd').val();
		var age = $('#input_student_new_age').val();
		var citizenship = $('#input_student_new_citizenship').val();
		var nationality = $('#input_student_new_nationality').val();
		var race = $('#input_student_new_race').val();
		var cn_level = $('#input_student_new_cnlevel').val();
		var edu_level = $('#input_student_new_edulevel').val();
		var lang = $('#input_student_new_lang').val();

		// address
		var blk = $('#input_student_new_blk').val();
		var street = $('#input_student_new_street').val();
		var floor_unit_no = $('#input_student_new_floor_unit').val();
		var building = $('#input_student_new_building').val();
		var postcode = $('#input_student_new_postcode').val();

		// employment
		var emp_status = $('#input_student_new_empstatus').val();
		var company_name = $('#input_student_new_comn').val();
		var company_type = $('#input_student_new_com_type').val();
		var company_reg_no = $('#input_student_new_com_reg_no').val();
		var industry = $('#input_student_new_industry').val();
		var designation = $('#input_student_new_designation').val();
		var salary_range = $('#input_student_new_sal_range').val();

		// extra
		// var student_branch = $('#input_student_new_branch option:selected').attr('id').split('_');
		// var student_branch_id = student_branch[3];
		// var student_op = $('#input_student_new_op option:selected').attr('id').split('_');
		// var student_op_id = student_op[3];
		var student_remark  = $('#input_student_new_remark').val();

		$.ajax({
			type:"post",
		    url:window.api_url + "updateStudentBasicInfo",
		    data:{	student_id:student_id,
		    		source:source,
		    		gov_letter:gov_letter, 
		    		ic:ic, 
		    		ic_type:ic_type, 
		    		firstname:firstname, 
		    		lastname:lastname, 
		    		othername:othername,
		    		tel:tel,
		    		tel_home:tel_home,
		    		gender:gender,
		    		salutation:salutation,
		    		birthday:birthday, 
		    		age:age,
		    		citizenship:citizenship,
		    		nationality:nationality,
		    		race:race,
		    		cn_level:cn_level,
		    		edu_level:edu_level,
		    		lang:lang,
		    		blk:blk,
		    		street:street,
		    		floor_unit_no:floor_unit_no,
		    		building:building,
		    		postcode:postcode,
		    		emp_status:emp_status,
		    		company_name:company_name,
		    		company_type:company_type,
		    		company_reg_no:company_reg_no,
		    		industry:industry,
		    		designation:designation,
		    		salary_range:salary_range,
		    		// student_branch_id:student_branch_id,
		    		// student_op_id:student_op_id,
		    		student_remark:student_remark},
		    success:function(json){
		    	if(json.trim() == '2') {
				    toastr.success("Update student basic info success!");
				    clear_student_new_form_inputs();
				    $('#student-info-modal').modal('hide');
				    load_student_info_warning_list();
				}else{
					toastr.error("Fail to update student basic info!");
				}
		    }
		});//End ajax
	}

	function update_create_student_baisc_info(student_ic) {
		// update or create seat booking records
		$.ajax({
			type:"post",
		    url:window.api_url + "getStudentByIC",
		    data:{ic:student_ic},
		    success:function(json){
		    	if(json.trim() != "") {
		    		var reply = $.parseJSON(json);
			    	for (var key in reply) {
				    	if (reply.hasOwnProperty(key)) {
				    		// student info in record, update
				    		update_student_basic_info(reply[key].student_id);
				    	}
				    }
				}else{
					// student not in record, create
					create_new_student_basic_info();
				}
		    }
		});//End ajax
	}

	function clear_student_new_form_inputs() {
		$('#input_student_new_gov_letter').prop('checked', false);
		$('#input_student_new_ic').val('');
		$('#input_student_new_ic_type option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_fn').val('');
		$('#input_student_new_ln').val('');
		$('#input_student_new_on').val('');
		$('#input_student_new_tel').val('');
		$('#input_student_new_tel_home').val('');
		$('#input_student_new_gender option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_sal option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_bd').val('');
		$('#input_student_new_age').val('');
		$('#input_student_new_citizenship option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_nationality option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_race option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_cnlevel option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_edulevel option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_lang option[value="NA"]').attr('selected', 'selected');

		// address
		$('#input_student_new_blk').val('');
		$('#input_student_new_street').val('');
		$('#input_student_new_floor_unit').val('');
		$('#input_student_new_building').val('');
		$('#input_student_new_postcode').val('');

		// employment
		$('#input_student_new_empstatus option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_comn').val('');
		$('#input_student_new_com_type option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_com_reg_no').val('');
		$('#input_student_new_industry option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_designation option[value="NA"]').attr('selected', 'selected');
		$('#input_student_new_sal_range option[value="NA"]').attr('selected', 'selected');

		// extra
		$('#input_student_new_remark').val('');
	}
	</script>
</head>

<div class="highlight">
	<div id="student_info_warning_list"></div>
</div>

<!-- Class delete Modal -->
<div class="modal fade" id="student-info-modal" tabindex="-1" role="dialog" aria-labelledby="student_info_modal_label" aria-hidden="true">
  <div class="modal-dialog modal-xxlg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="student_info_modal_label">Check Student Basic Information</h4>
      </div>
      <div class="modal-body">
      	<div class="highlight">
			<form role="form" id="exam_student_new_info_form">
				<h4>基本信息</h4><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_source">*学生来源</label>
						<select class="form-control" id="input_student_new_source">
			            	<option value="SSA">SSA</option>
				            <option value="Link1" selected="selected">Link1</option>
			    	        <option value="Changchun">Changchun</option>
			          	</select>
					</div>
					<div class="col-xs-4">
						<br>
						<div class="checkbox">
					    	<label for="input_student_new_gov_letter">
					    		<input type="checkbox" id="input_student_new_gov_letter"> 是否有政府信
					    	</label>
						</div>
					</div>
				</div><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_ic">*IC Number(准证号码)</label>
						<input class="form-control" id="input_student_new_ic" data-parsley-trigger="blur" required>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_ic_type">*IC Type(准证类型)</label>
					    <select class="form-control" id="input_student_new_ic_type">
					      <option value="0">请选择</option>
					      <option value="1">NRIC</option>
					      <option value="2">FIN</option>
					      <option value="3">Passport</option>
					      <option value="4">Workpermit</option>
					    </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_fn">*First Name(名)</label>
						<input class="form-control" id="input_student_new_fn" data-parsley-trigger="blur" required>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_ln">*Last Name(姓)</label>
						<input class="form-control" id="input_student_new_ln" data-parsley-trigger="blur" required>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_on">*Full Name(全名)</label>
						<input class="form-control" id="input_student_new_on">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_tel">*Tel(电话)</label>
						<input class="form-control" id="input_student_new_tel" data-parsley-trigger="blur" required>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_tel_home">Tel Home(家里电话)</label>
						<input class="form-control" id="input_student_new_tel_home">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_gender">*Gender(性别)</label>
						<select class="form-control" id="input_student_new_gender">
					      <option value="NA">请选择</option>
					      <option value="M">Male（男）</option>
					      <option value="F">Female（女）</option>
					    </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_sal">*Salutation(称呼)</label>
						<select class="form-control" id="input_student_new_sal" >
					      <option value="NA">请选择</option>
					      <option value="0">先生</option>
					      <option value="1">太太</option>
					      <option value="2">女士</option>
					      <option value="3">夫人</option>
					      <option value="4">博士</option>
					      <option value="5">教授</option>
					    </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_bd">*Birthday(生日)</label>
						<input class="form-control" id="input_student_new_bd" data-parsley-trigger="blur" required>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_age">*Age(年龄)</label>
						<input class="form-control" id="input_student_new_age" data-parsley-trigger="blur" required>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_citizenship">*Citizenship(身份)</label>
						<select class="form-control" id="input_student_new_citizenship">
							<option value="NA">请选择</option>
			                <option value="SG">新加坡公民</option>
			                <option value="PR">新加坡PR</option>
			                <option value="EP">Employment pass</option>
			                <option value="WP">Work permit</option>
			                <option value="SP">Student pass</option>
			                <option value="XX">其他</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_nationality">*Nationality(国籍)</label>
						<select class="form-control" id="input_student_new_nationality">
				            <option value="NA">请选择</option>
				            <option value="SG">Singapore Citizen </option>
				            <option value="CN">Chinese </option>
				            <option value="MY">Malaysian </option>
				            <option value="IN">Indian </option>
				            <option value="ID">Indonesian </option>
				            <option value="AF">Afghan </option>
				            <option value="AL">Albanian </option>
				            <option value="DZ">Algerian </option>
				            <option value="US">American </option>
				            <option value="AS">American Samoa </option>
				            <option value="AD">Andorran </option>
				            <option value="AO">Angolan  </option>
				            <option value="AG">Antigua </option>
				            <option value="AR">Argentinian </option>
				            <option value="AM">Armenian </option>
				            <option value="AU">Australian  </option>
				            <option value="AT">Austrian </option>
				            <option value="AZ">Azerbaijani </option>
				            <option value="BS">Bahamas </option>
				            <option value="BH">Bahraini  </option>
				            <option value="BD">Bangladeshi </option>
				            <option value="BB">Barbados </option>
				            <option value="BL">Belarussian </option>
				            <option value="BE">Belgian  </option>
				            <option value="BZ">Belize </option>
				            <option value="BJ">Benin </option>
				            <option value="BT">Bhutan </option>
				            <option value="BO">Bolivian </option>
				            <option value="BA">Bosnian  </option>
				            <option value="BW">Botswana </option>
				            <option value="GC">Br Dep Ter Citizen </option>
				            <option value="GG">Br Nat. Overseas </option>
				            <option value="GE">Br Overseas Cit.  </option>
				            <option value="GJ">Br Protected Pers. </option>
				            <option value="BR">Brazilian </option>
				            <option value="GB">British </option>
				            <option value="UK">British Subject  </option>
				            <option value="BN">Bruneian </option>
				            <option value="BG">Bulgarian </option>
				            <option value="BF">Burkina Faso </option>
				            <option value="BI">Burundi </option>
				            <option value="CF">C`Tral African Rep </option>
				            <option value="KA">Cambodian </option>
				            <option value="CM">Cameroon </option>
				            <option value="CA">Canadian </option>
				            <option value="CV">Cape Verde  </option>
				            <option value="TD">Chadian </option>
				            <option value="CL">Chilean </option>
				            <option value="CO">Colombian  </option>
				            <option value="KM">Comoros </option>
				            <option value="CG">Congo </option>
				            <option value="CK">Cook Islands </option>
				            <option value="CR">Costa Rican  </option>
				            <option value="CB">Croatian </option>
				            <option value="CU">Cuban </option>
				            <option value="CY">Cypriot </option>
				            <option value="CZ">Czech  </option>
				            <option value="CS">Czechoslovak </option>
				            <option value="DK">Danish </option>
				            <option value="DJ">Djibouti </option>
				            <option value="DM">Dominica </option>
				            <option value="DO">Dominican Republic </option>
				            <option value="NL">Dutch </option>
				            <option value="TP">East Timorese </option>
				            <option value="EC">Ecuadorian </option>
				            <option value="EG">Egyptian  </option>
				            <option value="GQ">Equatorial Guinea </option>
				            <option value="ER">Eritrean </option>
				            <option value="EN">Estonian </option>
				            <option value="ET">Ethiopian  </option>
				            <option value="FJ">Fijian </option>
				            <option value="PH">Filipino </option>
				            <option value="FI">Finnish </option>
				            <option value="FR">French </option>
				            <option value="GF">French Guiana  </option>
				            <option value="PF">French Polynesia </option>
				            <option value="GA">Gabon </option>
				            <option value="GM">Gambian </option>
				            <option value="GO">Georgian  </option>
				            <option value="DG">German </option>
				            <option value="DD">German, East </option>
				            <option value="DE">German, West </option>
				            <option value="GH">Ghanaian  </option>
				            <option value="GD">Grenadian </option>
				            <option value="GP">Guadeloupe </option>
				            <option value="GU">Guam </option>
				            <option value="GT">Guatemala  </option>
				            <option value="GN">Guinea </option>
				            <option value="GW">Guinea-Bissau </option>
				            <option value="GY">Guyana </option>
				            <option value="HN">Honduran </option>
				            <option value="HK">Hong Kong </option>
				            <option value="IS">Iceland </option>
				            <option value="IR">Iranian  </option>
				            <option value="IQ">Iraqi </option>
				            <option value="IE">Irish </option>
				            <option value="IL">Israeli </option>
				            <option value="IT">Italian </option>
				            <option value="CI">Ivory Coast  </option>
				            <option value="JM">Jamaican </option>
				            <option value="JP">Japanese </option>
				            <option value="JO">Jordanian </option>
				            <option value="KH">Kampuchean  </option>
				            <option value="KZ">Kazakh </option>
				            <option value="KE">Kenyan </option>
				            <option value="KG">Kirghiz </option>
				            <option value="KI">Kiribati </option>
				            <option value="KP">Korean, North  </option>
				            <option value="KR">Korean, South </option>
				            <option value="KW">Kuwaiti </option>
				            <option value="KS">Kyrghis </option>
				            <option value="KY">Kyrgyzstan  </option>
				            <option value="LA">Laotian </option>
				            <option value="LV">Latvian </option>
				            <option value="LB">Lebanese </option>
				            <option value="LS">Lesotho </option>
				            <option value="LR">Liberian  </option>
				            <option value="LY">Libyan </option>
				            <option value="LI">Liechtenstein </option>
				            <option value="LH">Lithuanian </option>
				            <option value="LU">Luxembourg  </option>
				            <option value="MO">Macao </option>
				            <option value="MB">Macedonia </option>
				            <option value="MG">Madagascar </option>
				            <option value="MW">Malawi  </option>
				            <option value="MV">Maldivian </option>
				            <option value="ML">Mali </option>
				            <option value="MT">Maltese  </option>
				            <option value="MH">Marshallese </option>
				            <option value="MQ">Martinique </option>
				            <option value="MR">Mauritanean </option>
				            <option value="MU">Mauritian  </option>
				            <option value="MX">Mexican </option>
				            <option value="MF">Micronesian </option>
				            <option value="MD">Moldavian </option>
				            <option value="MC">Monaco  </option>
				            <option value="MN">Mongolian </option>
				            <option value="MA">Moroccan </option>
				            <option value="MZ">Mozambique </option>
				            <option value="BU">Myanmar  </option>
				            <option value="NA">Namibia </option>
				            <option value="NR">Nauruan </option>
				            <option value="NP">Nepalese </option>
				            <option value="NT">Netherlands </option>
				            <option value="AN">Netherlands Antil. </option>
				            <option value="NC">New Caledonia </option>
				            <option value="NZ">New Zealander </option>
				            <option value="NI">Nicaraguan </option>
				            <option value="NE">Niger  </option>
				            <option value="NG">Nigerian </option>
				            <option value="NU">Niue Island </option>
				            <option value="NS">Non-S`Pore Citizen </option>
				            <option value="NO">Norwegian  </option>
				            <option value="OM">Oman </option>
				            <option value="PC">Pacific Is Trust T </option>
				            <option value="PK">Pakistani </option>
				            <option value="PW">Palauan  </option>
				            <option value="PN">Palestinian </option>
				            <option value="PA">Panamanian </option>
				            <option value="PG">Papua New Guinea </option>
				            <option value="PY">Paraguay  </option>
				            <option value="PE">Peruvian </option>
				            <option value="PI">Pitcairn </option>
				            <option value="PL">Polish </option>
				            <option value="PT">Portuguese </option>
				            <option value="PR">Puerto Rican </option>
				            <option value="QA">Qatar </option>
				            <option value="RE">Reunion </option>
				            <option value="RO">Romanian </option>
				            <option value="SU">Russian  </option>
				            <option value="RF">Russian </option>
				            <option value="RW">Rwanda </option>
				            <option value="SV">Salvadoran </option>
				            <option value="WS">Samoan </option>
				            <option value="ST">Sao Tome &amp; Princi. </option>
				            <option value="SA">Saudi Arabian </option>
				            <option value="SN">Senegalese </option>
				            <option value="SC">Seychelles </option>
				            <option value="SL">Sierra Leone </option>
				            <option value="SK">Slovak </option>
				            <option value="SI">Slovenian </option>
				            <option value="SB">Solomon Islands </option>
				            <option value="SO">Somali </option>
				            <option value="ZA">South African </option>
				            <option value="ES">Spanish </option>
				            <option value="LK">Sri Lankan  </option>
				            <option value="SW">St Kitts &amp; Nevis </option>
				            <option value="LC">St. Lucia </option>
				            <option value="VC">St. Vincent </option>
				            <option value="SD">Sudanese  </option>
				            <option value="SR">Suriname </option>
				            <option value="SZ">Swazi </option>
				            <option value="SE">Swedish </option>
				            <option value="CH">Swiss </option>
				            <option value="SY">Syrian  </option>
				            <option value="TJ">Tadzhik </option>
				            <option value="TW">Taiwanese </option>
				            <option value="TI">Tajikistani </option>
				            <option value="TZ">Tanzanian  </option>
				            <option value="TH">Thai </option>
				            <option value="TE">Timorense </option>
				            <option value="TG">Togo </option>
				            <option value="TK">Tokelau Islands  </option>
				            <option value="TO">Tonga </option>
				            <option value="TT">Trinidad &amp; Tobago </option>
				            <option value="TN">Tunisia</option>
				            <option value="TR">Turk  </option>
				            <option value="TM">Turkmen </option>
				            <option value="TV">Tuvalu </option>
				            <option value="UG">Ugandian </option>
				            <option value="UR">Ukrainian </option>
				            <option value="AE">United Arab Em. </option>
				            <option value="UN">Unknown </option>
				            <option value="HV">Upper Volta </option>
				            <option value="UY">Uruguay </option>
				            <option value="UZ">Uzbek  </option>
				            <option value="VU">Vanuatu </option>
				            <option value="VE">Venezuelan </option>
				            <option value="VN">Vietnamese </option>
				            <option value="WF">Wallis And Futuna  </option>
				            <option value="EH">Western Sahara </option>
				            <option value="YE">Yemen Arab Rep </option>
				            <option value="YD">Yemen, South </option>
				            <option value="YM">Yemeni  </option>
				            <option value="YU">Yugoslav </option>
				            <option value="ZR">Zairan </option>
				            <option value="ZM">Zambian </option>
				            <option value="ZW">Zimbabwean </option>
				            <option value="XX">Other </option>
						</select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_race">*Race(种族)</label>
						<select class="form-control" id="input_student_new_race">
			            	<option value="NA">请选择</option>
				            <option value="CN">Chinese(华人)</option>
				            <option value="MY">Malay(马来)</option>
				            <option value="IN">Indian(印度)</option>
				            <option value="EU">Eurasian(欧洲)</option>
				            <option value="Other">Other(其他)</option>
						</select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_cnlevel">*华文学历</label>
			            <select class="form-control" id="input_student_new_cnlevel">
				            <option value="NA">请选择</option>
				            <option value="01">No Formal Qualification &amp; Lowe</option>
				            <option value="11">Primary PSLE</option>
				            <option value="20">Lower Secondary</option>
				            <option value="31">'N' Level or equivalent</option>
				            <option value="32">'O' Level or equivalent</option>
				            <option value="41">'A' Level or equivalent</option>
				            <option value="70">Professional Qualification &amp; O</option>
				            <option value="80">University First Degree</option>
				            <option value="90">University Post-graduate Diplo</option>
				            <option value="XX">Not Reported</option>
			            </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_edulevel">*教育水平</label>
							<select class="form-control" id="input_student_new_edulevel">
					            <option value="NA">请选择</option>
					            <option value="01">No Formal Qualification &amp; Lower Primary </option>
					            <option value="11">Primary PSLE</option>
					            <option value="20">Lower Secondary</option>
					            <option value="35">ITE Skills Certification (ISC)</option>
					            <option value="31">'N' Level or equivalent</option>
					            <option value="32">'O' Level or equivalent</option>
					            <option value="41">'A' Level or equivalent</option>
					            <option value="51">NITEC/Post Nitec</option>
					            <option value="54">WSQ Certificate</option>
					            <option value="52">Higher NITEC</option>
					            <option value="55">WSQ Higher Certificate</option>
					            <option value="53">Master NITEC</option>
					            <option value="61">Polytechnic Diploma</option>
					            <option value="73">WSQ Advance Certificate</option>
					            <option value="74">WSQ Diploma</option>
					            <option value="75">WSQ Specialist Diploma</option>
					            <option value="70">Professional Qualification &amp; Other Diploma</option>
					            <option value="80">University First Degree</option>
					            <option value="92">WSQ Graduate Certificate</option>
					            <option value="93">WSQ Graduate Diploma</option>
					            <option value="90">University Post-graduate Diploma &amp; Degree/Master/Doctorate</option>
					            <option value="XX">Not Reported</option>
				            </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_lang">*使用语言</label>
						<select class="form-control" id="input_student_new_lang">
				            <option value="NA">请选择</option>
				            <option value="Chinese">Chinese(中文)</option>
				            <option value="English">English(英语)</option>
				            <option value="Malay">Malay(马来语)</option>
				            <option value="Tamil">Tamil(泰米尔语)</option>
				            <option value="Others">Others(其他)</option>
			            </select>
					</div>
				</div>
				<h4>住址信息</h4><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_blk">BLK</label>
						<input class="form-control" id="input_student_new_blk">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_street">Street</label>
						<input class="form-control" id="input_student_new_street">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_floor_unit">#Floor-Unit No.</label>
						<input class="form-control" id="input_student_new_floor_unit">
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_building">Building Name</label>
						<input class="form-control" id="input_student_new_building">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_postcode">Postcode</label>
						<input class="form-control" id="input_student_new_postcode">
					</div>
				</div>
				<h4>工作信息</h4><hr>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_empstatus">工作状态</label>
				          <select class="form-control" id="input_student_new_empstatus">
				            <option value="NA">请选择</option>
				            <option value="EMP001">Employed</option>
				            <option value="EMP002">Unemployed</option>
				          </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_comn">公司名称</label>
						<input class="form-control" id="input_student_new_comn" value="NA">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_com_type">公司注册类型</label>
						<select class="form-control" id="input_student_new_com_type">
			                <option value="NA">请选择</option>
			                <option value="ROC">Registry of Company</option>
			                <option value="ROB">Registry of Business</option>
			                <option value="UENO">Other Unique Establishments (UENO)</option>
			                <option value="OTHERS">Others - None of the Above</option>
				          </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_com_reg_no">公司注册号</label>
						<input class="form-control" id="input_student_new_com_reg_no" value="NA">
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_industry">行业</label>
			            <select class="form-control" id="input_student_new_industry">
			                <option value="NA">请选择</option>
			                <option value="1" selected="selected">Others</option>
			                <option value="2">Aerospace</option>
			                <option value="3">Bio-Medical Sciences</option>
			                <option value="4">Business Process Outsourcing</option>
			                <option value="5">Chemicals</option>
			                <option value="6">Creative</option>
			                <option value="7">Construction</option>
			                <option value="8">Electronics</option>
			                <option value="9">Environment</option>
			                <option value="10">Finance</option>
			                <option value="11">Food Mfg &amp; Processing</option>
			                <option value="12">Government / Public Services</option>
			                <option value="13">Healthcare</option>
			                <option value="14">Horticulture</option>
			                <option value="15">Hospitality</option>
			                <option value="16">Infocomm Technology</option>
			                <option value="17">Logistics and Transportation</option>
			                <option value="18">Marine</option>
			                <option value="19">Maritime</option>
			                <option value="20">Precision ?Engineering</option>
			                <option value="21">Printing</option>
			                <option value="22">Professional Services</option>
			                <option value="23">Process</option>
			                <option value="24">Repair and Servicing</option>
			                <option value="25">Retail</option>
			                <option value="26">Security</option>
			                <option value="27">Social &amp; Community Services</option>
			                <option value="28">Sports and Recreation</option>
			                <option value="29">Textile</option>
			            </select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_designation">职称</label>
			            <select class="form-control" id="input_student_new_designation">
			                <option value="NA">请选择</option>
			                <option value="01">Legislators, Senior Officials and Mangers</option>
			                <option value="02">Professionals</option>
			                <option value="03">Associate Professionals and Technicians</option>
			                <option value="04">Clerical Workers</option>
			                <option value="05">Service Works and Shop and Market Sales Workers</option>
			                <option value="06">Agricultural and Fishery Workers</option>
			                <option value="07">Production Craftsmen &amp; Related Workers</option>
			                <option value="08">Plan and Machine Operators and Assemblers</option>
			                <option value="09">Cleaners, Laborers and Related Workers</option>
			                <option value="10" selected="selected">Workers not classified by Occupation</option>
			            </select>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-4">
						<label for="input_student_new_sal_range">薪水范围</label>
			            <select class="form-control" id="input_student_new_sal_range">
			                <option value="NA">请选择</option>
			                <option value="00" selected="selected">Unemployed</option>
			                <option value="01">Below $1,000</option>
			                <option value="02">$1,000 - $1,400</option>
			                <option value="03a">$1,401 - $1,700</option>
			                <option value="03b">$1,701 - $2,000</option>
			                <option value="04">$2,000 - $2,499</option>
			                <option value="05">$2,500 - $2,999</option>
			                <option value="06">$3,000 - $3,499</option>
			                <option value="07">$3,500 and above</option>
			            </select>
					</div>
				</div>
				<div class="row">
					<!-- <div class="col-xs-4">
						<label for="input_student_new_branch">Operator Branch</label>
						<select class="form-control" id="input_student_new_branch"></select>
					</div>
					<div class="col-xs-4">
						<label for="input_student_new_op">Operator</label>
						<select class="form-control" id="input_student_new_op"></select>
					</div> -->
					<div class="col-xs-4">
						<label for="input_student_new_remark">Remark</label>
						<textarea class="form-control" id="input_student_new_remark" rows="3"></textarea>
					</div>
				</div>
			</form>
			<hr>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal" id="student_info_modal_confirm">Confirm</button>
      </div>
    </div>
  </div>
</div>