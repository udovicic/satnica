$(function() {

	// set current date
	var date = new Date();
	$('#date').val($.datepicker.formatDate('dd.mm.yy', new Date()));

	// datepicker setup
	$('#date').datepicker({
		showAnim: 'fold',
		dayNamesMin: [ "Ned", "Pon", "Uto", "Sri", "Čet", "Pet", "Sub" ],
		monthNames: [ "Siječanj", "Veljača", "Ožujak", "Travanj", "Svibanj", "Lipanj", "Srpanj", "Kolovoz", "Rujan", "Listopad", "Studeni", "Prosinac" ],
		dateFormat: 'dd.mm.yy',
		firstDay: 1
	});

	// timepicker setup
	$('#start').timepicker({
		hourText: 'Početak smjene',
		showMinutes: false
	});
	
	$('#end').timepicker({
		hourText: 'Kraj smjene',
		showMinutes: false
	});

// shift add
	var form = $('#shift-add');

	// form submit handling
	form.find('#add').submit(function(event) {
		event.preventDefault();

		var _date = $('#date').val();
		var _start = $('#start').val();
		var _end = $('#end').val();
		var _submit = $('#submit').val();
		var _note = $('#note').val();

		var posting = $.post(
			$('#add').attr('action'),
			{
				date: _date,
				start: _start,
				end: _end,
				note: _note,
				submit: _submit,
				js: 'true'
			});
		posting.always(function() {
			$('#result:visible').slideUp(100);
			$('#waiting').show();
		})
		posting.done(function(data) {
			$('#result').html(data).slideDown();
			$('#waiting').hide();
		})
	})

// shift report
	$('td.date, td.time, td.total').click(function(event) {
		$(this).parent().next('tr.details').fadeToggle();
	});
	
	$('tr.details').click(function(event) {
		$(this).fadeOut();
	});

// shift report - dialogs
	$('#dialog-shift-result').dialog({
		autoOpen: false,
		title: 'Obavijest',
		buttons: {
			'Uredu': function() {
				var url = $(this).data('url');
				if (typeof(url) != undefined) {
					window.location = url;
				}
				$(this).dialog('close');
			}
		}
	});

	// dialogs setup
	$('#dialog-shift-delete').dialog({
		autoOpen: false,
		title: 'Brisanje unosa',
		buttons: {
			'Da': function() {
				var posting = $.post(
					$('#form-shift-delete').attr('action'),
					{
						id: $(this).data('id'),
						js: 'true'
					}
				);
				posting.done(function(data) {
					$('#dialog-shift-result')
						.html(data)
						.data('url', location.href)
						.dialog('open');
				})
				
				$(this).dialog('close');
			},
			'Odustani': function() {
				$(this).dialog('close');
			}
		}
	});

	$('#dialog-shift-edit').dialog({
		autoOpen: false,
		title: 'Izmjena podataka',
		buttons: {
			'Spremi': function() {
				var _id = $(this).data('id');
				var _datum = $(this).find('#date').val();
				var _pocetak = $(this).find('#start').val();
				var _kraj = $(this).find('#end').val();
				var _komentar = $(this).find('#note').val();

				var posting = $.post(
					$('#form-shift-update').attr('action'),
					{
						shift_id: _id,
						date: _datum,
						start: _pocetak,
						end: _kraj,
						note: _komentar,
						js: 'true'
					}
				);
				posting.done(function(data) {
					$('#dialog-shift-result')
						.html(data)
						.data('url', location.href)
						.dialog('open');
				})
				
				$(this).dialog('close');
			},
			'Odustani': function() {
				$(this).dialog('close');
			}
		}
	})

	// dialog trigger
	$('.edit').click(function() {
		var date = $(this).siblings('td.date').html();
		var time = $(this).siblings('td.time').html();
		var id = $(this).parent().attr('id');
		var comment = $(this).parent().next('tr.details').find('li.comment').children('.value').html();

		time = time.split(' - ');
		if (typeof comment == 'undefined') {
			comment = '';
		}
		
		$('#dialog-shift-edit')
			.find('#date').val(date).end()
			.find('#start').val(time[0]).end()
			.find('#end').val(time[1]).end()
			.find('#note').val(comment).end()
			.data('id', id)
			.dialog('open');
	});

	$('.delete').click(function() {
		var dialog = $('#dialog-shift-delete');

		dialog.find('.date').html(
			$(this).siblings('td.date').html()
		);
		dialog
			.data(
				'id',
				$(this).parent().attr('id')
			).dialog('open');
	});
});