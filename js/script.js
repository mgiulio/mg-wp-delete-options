(function($) {$(function() {	$('tr').append(		'<td>' + 			'<span class="panel delete"><a class="btn" href="#">Delete</a></span>' + 			'<span class="panel confirm" style="display: none;"><a class="yes" title="Confirm" href="#"><img alt="Confirm" src="' + mgdeleteoptions_args.yes + '"></a> <a class="no" title="Cancel" href="#"><img alt="Cancel" src="' + mgdeleteoptions_args.no + '"></a></span>' + 			'<span class="panel processing" style="display: none;"><img src="' + mgdeleteoptions_args.ajaxSpinnerUrl + '"></span>' + 			'<span class="panel error" style="display: none;"><a class="ok" href="#" style="color: red;">Error</a></span>' +		'</td>'	);		$('body')		.on('click', '.panel.delete .btn', function(e) {			$(e.target).closest('.panel').hide().siblings('.panel.confirm').show();			return false;		})		.on('click', '.panel.confirm .no', function(e) {			$(e.target).closest('.panel').hide().siblings('.panel.delete').show();			return false;		})		.on('click', '.panel.confirm .yes', function(e) {			var				td = $(e.target).closest('.panel').parent(),				tr = td.parent()			;					var option_name = td.prev().children().first().attr('name');						var processingPanel;			$.ajax({				url: mgdeleteoptions_args.ajaxEndpoint,				type: 'POST',				data: {					action: mgdeleteoptions_args.wpAjaxAction,					option_name: option_name,					_wpnonce: mgdeleteoptions_args.nonce				},				dataType: 'json',				beforeSend: function() {					processingPanel = $(e.target).closest('.panel').hide().siblings('.panel.processing');					processingPanel.show();				}			})				.done(function(data) {					tr.hide(500, function() {						tr.remove();					});				})				.fail(function(jqXHR, textStatus, errorThrown) {					processingPanel.hide().siblings('.panel.error').show();				})			;						return false;		})		.on('click', '.panel.error .ok', function(e) {			$(e.target).closest('.panel').hide().siblings('.panel.delete').show();			return false;		})	;});})(jQuery);