(function($) {$(function() {	var		templates = {			deleteBtn: '<a class="delete_btn" href="#">Delete</a>',			confirm: '<span style="display: none;"><a class="yes" title="Confirm" href="#"><img src="' + mgWpOptionsWipeoutParams.yes + '"></a> <a class="no" title="Cancel" href="#"><img src="' + mgWpOptionsWipeoutParams.no + '"></a></span>',			ajaxSpinner: '<img style="display: none;" src="' + mgWpOptionsWipeoutParams.ajaxSpinnerUrl + '">'		}	;		$('tr').append(		'<td>' + 		templates.deleteBtn + 		templates.confirm + 		templates.ajaxSpinner + 		'</td>'	);		$('body').on('click', '.delete_btn', function(e) {		$(e.target).hide().next().show();		return false;	});		$('body').on('click', '.no', function(e) {		$(e.target).parent().parent().hide().prev().show();		return false;	});		$('body').on('click', '.yes', function(e) {		var			container = $(e.target).parent().parent(),			td = container.parent()			tr = td.parent()		;				var option_name = td.prev().children().first().attr('name');			$.ajax({			url: mgWpOptionsWipeoutParams.ajaxEndpoint,			type: 'POST',			data: {				action: mgWpOptionsWipeoutParams.wpAjaxAction,				option_name: option_name			},			dataType: 'json',			beforeSend: function() {				container.hide().next().show();			}		})			.success(function(data) {				tr.hide(500, function() {					tr.remove();				});			})			.error(function(jqXHR, textStatus, errorThrown) {				/* msg += 'Something went wrong:';				msg += '<ul>';								if (textStatus)					msg += '<li>' + textStatus + '</li>';								if (errorThrown)					msg += '<li>' + errorThrown + '</li>';								if (jqXHR.responseText) {					var data = $.parseJSON(jqXHR.responseText);					if (data.errMsgs)						$(data.errMsgs).each(function(i, err) { msg += '<li>' + err + '</li>'; });				}								msg += '</ul>';								feedback.addClass('error'); */			})			.complete(function() {			})		;			return false;	});		});})(jQuery);