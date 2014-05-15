<!-- 
 * Wang Zihao
 * wzhjay@gmail.com
 * 09.05.2014 
 -->
 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			event.preventDefault();
			$('#student_info_form').parsley();
			$('#input_student_bd').datepicker({
				format: 'dd/mm/yyyy'
			});
		});
	</script>
</head>
<div class="highlight">
<form role="form" id="student_info_form">
	<h4>基本信息</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_ic">IC Number</label>
			<input class="form-control" id="input_student_ic" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_student_fn">First Name</label>
			<input class="form-control" id="input_student_fn" data-parsley-trigger="blur" required>
		</div>
		<div class="col-xs-4">
			<label for="input_student_ln">Last Name</label>
			<input class="form-control" id="input_student_ln" data-parsley-trigger="blur" required>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_on">Other Name</label>
			<input class="form-control" id="input_student_on">
		</div>
		<div class="col-xs-4">
			<label for="input_student_tel">Tel</label>
			<input class="form-control" id="input_student_tel">
		</div>
		<div class="col-xs-4">
			<label for="input_student_tel_home">Tel Home</label>
			<input class="form-control" id="input_student_tel_home">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_gender">Gender</label>
			<select class="form-control" id="input_student_gender">
		      <option value="NA">请选择</option>
		      <option value="M">Male（男）</option>
		      <option value="F">Female（女）</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_sal">Salutation</label>
			<select class="form-control" id="input_student_sal">
				<option>Mr</option>
				<option>Mrs</option>
				<option>Ms</option>
				<option>Miss</option>
				<option>Dr</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_bd">Birthday</label>
			<input class="form-control" id="input_student_bd">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_age">Age</label>
			<input class="form-control" id="input_student_age">
		</div>
		<div class="col-xs-4">
			<label for="input_student_ic_type">IC Type</label>
			<select class="form-control" id="input_student_ic_type">
		      <option value="0">请选择</option>
		      <option value="1">NRIC</option>
		      <option value="2">FIN</option>
		      <option value="3">Passport</option>
		      <option value="4">Workpermit</option>
		    </select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_citizenship">Citizenship</label>
			<select class="form-control" id="input_student_citizenship">
				<option value="0">请选择</option>
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
			<label for="input_student_nationality">Nationality</label>
			<select class="form-control" id="input_student_nationality">
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
			<label for="input_student_race">Race</label>
			<select class="form-control" id="input_student_race">
            	<option value="NA">请选择</option>
	            <option value="CN">Chinese(华人)</option>
	            <option value="MY">Malay(马来)</option>
	            <option value="IN">Indian(印度)</option>
	            <option value="EU">Eurasian(欧洲)</option>
	            <option value="XX">Other(其他)</option>
			</select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_cnlevel">华文学历</label>
			<select class="form-control" id="input_student_cnlevel">
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
			<label for="input_student_edulevel">教育水平</label>
				<select class="form-control" id="input_student_edulevel">
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
	</div>
	<h4>工作信息</h4><hr>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_empstatus">工作状态</label>
			<select class="form-control" id="input_student_empstatus">
	            <option value="NA">请选择</option>
	            <option value="Employed">Employed</option>
	            <option value="Unemployed">Unemployed</option>
          </select>
		</div>
		<div class="col-xs-4">
			<label for="input_student_comn">公司名称</label>
			<input class="form-control" id="input_student_comn" value="NA">
		</div>
		<div class="col-xs-4">
			<label for="input_student_com_status">公司注册类型</label>
			<select class="form-control" id="input_student_com_status">
                <option value="NA">请选择</option>
                <option value="ROC">Registry of Company</option>
                <option value="ROB">Registry of Business</option>
                <option value="UENO">Other Unique Establishments (UENO)</option>
                <option value="OTHERS" selected="selected">Others - None of the Above</option>
	          </select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_com_reg_no">公司注册号</label>
			<input class="form-control" id="input_student_com_reg_no" value="NA">
		</div>
		<div class="col-xs-4">
			<label for="input_student_industry">行业</label>
			<select class="form-control" id="input_student_industry">
                <option value="NA">请选择</option>
                <option value="1">Others</option>
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
			<label for="input_student_designation">职称</label>
			<select class="form-control" id="input_student_designation">
                <option value="NA">请选择</option>
                <option value="1">Legislators, Senior Officials and Mangers</option>
                <option value="2">Professionals</option>
                <option value="3">Associate Professionals and Technicians</option>
                <option value="4">Clerical Workers</option>
                <option value="5">Service Works and Shop and Market Sales Workers</option>
                <option value="6">Agricultural and Fishery Workers</option>
                <option value="7">Production Craftsmen &amp; Related Workers</option>
                <option value="8">Plan and Machine Operators and Assemblers</option>
                <option value="9">Cleaners, Laborers and Related Workers</option>
                <option value="10">Workers not classified by Occupation</option>
            </select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<label for="input_student_sal_range">薪水范围</label>
			<select class="form-control" id="input_student_sal_range">
                <option value="NA">请选择</option>
                <option value="00">Unemployed</option>
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
		<div class="col-xs-4">
			<label for="input_student_lang">使用语言</label>
			<select class="form-control" id="input_student_lang">
	            <option value="NA">请选择</option>
	            <option value="Chinese">Chinese(中文)</option>
	            <option value="English">English(英语)</option>
	            <option value="Malay">Malay(马来语)</option>
	            <option value="Tamil">Tamil(泰米尔语)</option>
	            <option value="O">Others(其他)</option>
            </select>
		</div>
	</div>
</form>
<hr>
<div class="row">
	<div class="col-xs-10"></div>
	<div class="col-xs-2">
		<a class="button glow button-rounded button-flat" id="student_new_submit">Submit</a>
	</div>
</div>
</div>