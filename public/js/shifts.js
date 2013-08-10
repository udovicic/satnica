$(function() {

// add
	var date = new Date();
	$('#date').val($.datepicker.formatDate('dd.mm.yy', new Date()));

	$('#date').datepicker({
		showAnim: 'fold',
		dayNamesMin: [ "Ned", "Pon", "Uto", "Sri", "Čet", "Pet", "Sub" ],
		monthNames: [ "Siječanj", "Veljača", "Ožujak", "Travanj", "Svibanj", "Lipanj", "Srpanj", "Kolovoz", "Rujan", "Listopad", "Studeni", "Prosinac" ],
		dateFormat: 'dd.mm.yy',
		firstDay: 1
	});
	
	$('#start').timepicker({
		minutes: { interval: 30 },
		hourText: 'Početak smjene',
		showMinutes: false
	});
	
	$('#end').timepicker({
		//minutes: { interval: 30 },
		hourText: 'Kraj smjene',
		showMinutes: false
	});

	$('#add').submit(function(event) {
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
// list
	$('tr.data').click(function(event) {
		$(this).next('tr.details').fadeToggle();
	});
	
	$('tr.details').click(function(event) {
		$(this).fadeOut();
	});
});