$(function() {
// monthly report
	// spinner setup
	$('#dialog-monthly-report').find('#month')
		.val($.datepicker.formatDate('mm', new Date()))
		.spinner({
			spin: function( event, ui ) {
				if ( ui.value > 12 ) {
					$( this ).spinner( "value", 1 );
					return false;
				} else if ( ui.value < 1 ) {
					$( this ).spinner( "value", 12 );
					return false;
				}
			}
		});

	// dialog setup
	$('#dialog-monthly-report').dialog({
		autoOpen: false,
		title: 'Mjesečni izvještaj',
		buttons: {
			'Prikaži': function() {
				var month = $('#dialog-monthly-report').find('#month').spinner('value');
				var url = $(this).data('url') + '/' + month;
				window.location = url;
			},
			'Odustani': function() {
				$(this).dialog('close');
			}
		}
	});

	// click event setup
	$('.report-link').click(function(event) {
		event.preventDefault();
		$('#dialog-monthly-report')
			.data('url', $(this).attr('href'))
			.dialog('open');
	});
});