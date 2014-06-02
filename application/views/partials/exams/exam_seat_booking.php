 <head>
	<meta charset="utf-8">

	<script>
		$(document).ready(function($) {
			calendar_initialization();

			$('#exam_seat_booking_event_generate').on('click', function() {
				generate_new_seat_info();
			});

			$('#exam_seat_booking_event_clear').on('click', function() {
				clear_seat_info();
			});
		});

		function external_event_initialization() {
			$('#seat_infos div.seat_info').each(function() {
		
				// create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
				// it doesn't need to have a start or end
				var eventObject = {
					title: $.trim($(this).text()) // use the element's text as the event title
				};
				
				// store the Event Object in the DOM element so we can get to it later
				$(this).data('eventObject', eventObject);
				
				// make the event draggable using jQuery UI
				$(this).draggable({
					zIndex: 999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
				});
				
			});

		}

		function calendar_initialization() {
			$('#exam_seat_booking_calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month'
				},
				editable: true,
				droppable: true, // this allows things to be dropped onto the calendar !!!
				drop: function(date) { // this function is called when something is dropped
				
					// retrieve the dropped element's stored Event Object
					var originalEventObject = $(this).data('eventObject');
					
					// we need to copy it, so that multiple events don't have a reference to the same object
					var copiedEventObject = $.extend({}, originalEventObject);
					
					// assign it the date that was reported
					copiedEventObject.start = date;
					
					// render the event on the calendar
					// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
					$('#exam_seat_booking_calendar').fullCalendar('renderEvent', copiedEventObject, true);
					
					// is the "remove after drop" checkbox checked?
					if ($('#drop-remove').is(':checked')) {
						// if so, remove the element from the "Draggable Events" list
						$(this).remove();
					}
					
				}
			});
		}

		function generate_new_seat_info() {
			var location = $('#exam_seat_booking_calendar_location').val();
			var exam_time = $('#exam_seat_booking_calendar_exam_time').val();
			var seat_num = $('#exam_seat_booking_calendar_seat_number').val();

			var target = $('#seat_infos');
			target.append(
				'<div class="seat_info">' + 
					'<div class="seat_info_location">'+location+'</div>' +
					'<div class="seat_info_exam_time">'+exam_time+'</div>' +
					'<div class="seat_info_seat_num">'+seat_num+'</div>' +
				'</div>'
			);
			external_event_initialization();
		}

		function clear_seat_info() {
			var target = $('#seat_infos');
			target.empty();
		}
	</script>
</head>
<div class="highlight">
	<div class="row">
		<div class="col-xs-2" id="exam_seat_booking_event_section">
			<div id='exam_seat_booking_event_generate_form'>
				<h4>Seat Info</h4>
				<label>
					Location: 
					<select id="exam_seat_booking_calendar_location">
				        <option value="JE">JE</option>
				        <option value="EUN">EUN</option>
				    </select>
			    </label>
			    <label>
			    	Time: 
				    <select id="exam_seat_booking_calendar_exam_time">
				        <option value="0900">09:00</option>
				        <option value="1400">14:00</option>
				        <option value="1900">19:00</option>
				    </select>
			    </label>
			    <label>
			    	Seat Num: 
			    	<input id="exam_seat_booking_calendar_seat_number" style="width:50%">
			    </label>
			    <br><br>
			    <a class="button glow button-rounded button-flat" id="exam_seat_booking_event_generate">Generate</a>
			    <a class="button glow button-rounded button-flat" id="exam_seat_booking_event_clear">Clear</a>
			</div>
			<hr>
			<div id='seat_infos'>
			</div>
		</div>
		<div class="col-xs-10" id="exam_seat_booking_calendar_section">
			<div id='exam_seat_booking_calendar'></div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-10"></div>
		<div class="col-xs-2">
			<a class="button glow button-rounded button-flat" id="exam_seat_booking_submit">Submit</a>
		</div>
	</div>
</div>