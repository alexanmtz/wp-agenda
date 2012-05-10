/*
 * Administracao da agenda
 * http://blog.alexandremagno.net
 *
 * Use fullcalendar.css for basic styling.
 * For event drag & drop, required jQuery UI draggable.
 * For event resizing, requires jQuery UI resizable.
 *
 * Copyright (c) 2009 Adam Shaw
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 *
 */

var DateConvert = {
	toObject: function(date) {
		var dateArray = date.split('/');
		var DateObject = new Date(dateArray[2], dateArray[1]-1, dateArray[0]);
		console.info(DateObject.toString());
		console.info(dateArray);
		return DateObject;
	}
}

jQuery(document).ready(function() {
	jQuery('#wp-agenda-calendar').fullCalendar({
		monthNames: agenda_locale.monthNames,
		monthNamesShort: agenda_locale.monthNamesShort,
		dayNames: agenda_locale.dayNames,
		dayNamesShort: agenda_locale.dayNamesShort,
		header: agenda_locale.header,
		buttonText: agenda_locale.buttonText,
		editable: false,
		loading: function(loading){
			/*
if (loading) {
				jQuery.blockUI({
					message: 'Carregando agenda...'
				});
			}
			else {
				jQuery.unblockUI();
			}
*/
		},
		events: function(start, end, callback) {
			var date_results = [];
			jQuery.ajax({
				url: ajaxurl,
				dataType: 'json',
				data: {action: 'agenda_events'},
				success: function(results) {
					console.info(results);
					events = [];
					for (result in results) {
						events.push({
							id : results[result]['ID'],
							title : results[result]['post_title'],
							url : results[result]['guid'],
							start: DateConvert.toObject(results[result]['start'][0])							
						});
	
					}
					console.info(events);
					callback(events);
				},
				complete: function(xhr, message) {
					
				},
				error: function(xhr, type, e) {
					console.info(type);
				} 
			});
			
		}
	});
});