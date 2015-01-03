<head>
<meta charset="utf-8">
<script>
var fullDate = new Date()
var twoDigitMonth = (fullDate.getMonth().toString().length === 2)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);
var twoDigitDate = (fullDate.getDate().toString().length === 2)? (fullDate.getDate()) : '0' + (fullDate.getDate());
var currentDate = fullDate.getFullYear() + "-" + twoDigitMonth + "-" + twoDigitDate;

$(document).ready(function() {
    load_public_message();
    $('#input_public_message_publish').on('click', function() {
        create_new_public_message();
    })
});

function load_public_message() {
    var message_count = 0;
    $.ajax({
        type:"post",
        url:window.api_url + "getPublicMessageOneWeek",
        data:{},
        success:function(json){
            var modalBody = $('#publics-message-section');
            modalBody.empty();
            if(json.trim() != "") {
                var reply = $.parseJSON(json);
                var date = "";
                for (var key in reply) {
                    if (reply.hasOwnProperty(key)) {
                        var cur_date = reply[key].modified.substring(0, 10);
                        if(currentDate == cur_date) { message_count += 1; }
                        if( cur_date != date) {
                            modalBody.append(
                                '<br><h3><span class="label label-success">'+ cur_date +'</span></h3><br>'
                            );
                        }
                        modalBody.append(
                            '<div class="bs-callout bs-callout-info">' +
                                '<span class="label label-danger publics_message_delete" id="publics_message_' + reply[key].id + '"></span>' +
                                '<h4><span class="label label-info">' + reply[key].publics_title + '</span></h4>' +
                                '<div>' + reply[key].publics_content + '</div>' +
                            '</div>'
                        );
                        date = cur_date;
                    }
                }
            }
            else {
            }
            $('#today_message_count').text(message_count);
        }
    });//End ajax
}


</script>
</head>

<nav class="navbar navbar-default navbar-fixed-top" id="top" role="navigation">
  <div class="container">
    <div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bav-bar-sims">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo $this->config->base_url(); ?>index.php/welcome">长春教育管理系统</a>
	</div>
	<div class="collapse navbar-collapse" id="bav-bar-sims">
          <ul class="nav navbar-nav pull-right">
            <?php 
                if($this->tank_auth->is_logged_in()) {
                    echo '<li class="dropdown">';
                    echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">'.$this->tank_auth->get_username().' <b class="caret"></b></a>';
                    echo '<ul class="dropdown-menu" role="menu">';
                    // echo '<li><a href="#">Region</a></li>';
                    // echo '<li><a href="#">Chatting Room</a></li>';
                    echo '<li><a href='.$this->config->base_url().'index.php/auth/change_password>Change Password</a></li>';
                    echo '<li class="divider"></li>';
                    echo '<li><a href='.$this->config->base_url().'index.php/systems/userProfile>Profile</a></li>';
                    echo '<li class="divider"></li>';
                    echo '<li><a href='.$this->config->base_url().'index.php/auth/logout>Logout</a></li>';
                    echo '</ul>';
                    echo '</li>';
                }
            ?>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/students">学员管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/classes">班级管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/exams">考试管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/atos">ATO管理</a></li>
            <li><a href="<?php echo $this->config->base_url(); ?>index.php/financial">收支管理</a></li>
            <?php
                if($this->apis->check_user_role() == 'admin') {
                    echo '<li><a href='.$this->config->base_url().'index.php/systems>系统管理</a></li>';
                } else {
                    echo '<li><a href='.$this->config->base_url().'index.php/systems/userProfile>系统管理</a></li>';
                }
                if($this->tank_auth->is_logged_in()) {
                    echo '<li><a href="#"" data-toggle="modal" data-target="#office-info-modal"><span class="glyphicon glyphicon-volume-up"></span>  <span class="badge" id="today_message_count">0</span></a></li>';
                }
            ?>
          </ul>
    </div>
  </div>
</nav>
<hr>

<!-- Info Modal -->
<div class="modal fade" id="office-info-modal" tabindex="-1" role="dialog" aria-labelledby="office_info_modal_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="office_info_modal_label">公告栏消息</h4>
      </div>
      <div class="modal-body">
        <div class='row'>
            <div id="publics-message-section" style="height: 600px;overflow-y: scroll;padding:10px">
                <div class="bs-callout bs-callout-info">
                    <h5>大叔爱叽叽 <3</h5>
                    <p><code>注意！！这不是演习！！</code></p>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </div>