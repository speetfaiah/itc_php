$(document).ready(function($) {
	//всплывающие окна
	$('button.auth').click(function() {
		$('.wrapping').show();
	    $('.auth_form').show();
	    return false;
	});
	$('button.register').click(function() {
	    $('.wrapping').show();
	    $('.register_form').show();
	    return false;
	});
	$('.window_header .close').click(function() {
	    $('.auth_form').hide();
	    $('.register_form').hide();
	    $('.wrapping').hide();
	});
	//отправка данных с форм
	$('.register_form form').ajaxForm({ //регистрация
		url: "/workwithuser.php",
		type: "POST",
		dataType: "json",
		beforeSubmit: function() {
			$(".register_form form button").attr('disabled','disabled');
		},
		success: function(responseText, statusText, xhr, $form) {
			$(".register_form form button").removeAttr('disabled');
        	if (responseText.status === true) {
          		location.reload();
          		return;
        	}
        	$('#register_hint').show();
        	$('#register_hint').text(responseText.message);
      	}
	});
	$('.auth_form form').ajaxForm({ //авторизация
		url: "/workwithuser.php",
		type: "POST",
		dataType: "json",
		beforeSubmit: function() {
			$(".auth_form form button").attr('disabled','disabled');
		},
		success: function(responseText, statusText, xhr, $form) {
			$(".auth_form form button").removeAttr('disabled');
        	if (responseText.status === true) {
          		location.reload();
          		return;
        	}
        	$('#auth_hint').show();
        	$('#auth_hint').text(responseText.message);
      	}
	});
	$('.header form').ajaxForm({ //выход из учетки
		url: "/workwithuser.php",
		type: "POST",
		dataType: "json",
		success: function(responseText, statusText, xhr, $form) {
        	if (responseText.status === true) {
          		location.reload();
          		return;
        	}
      	}
	});
	$('.row.marketing form').ajaxForm({ //отправка сообщения
		url: "/workwithuser.php",
		type: "POST",
		dataType: "json",
		beforeSubmit: function() {
			$(".row.marketing form button").attr('disabled','disabled');
			$('.alert-danger#sending_hint').hide();
		},
		success: function(responseText, statusText, xhr, $form) {
			$(".row.marketing form button").removeAttr('disabled');
        	if (responseText.status === true) {
          		window.location.href = '/';
          		return;
        	}
        	$('.alert-danger#sending_hint').show();
        	$('.alert-danger#sending_hint').text(responseText.message);
      	}
	});
	$('#type_comment form').ajaxForm({ //отправка комментария
		url: "/workwithuser.php",
		type: "POST",
		dataType: "json",
		beforeSubmit: function() {
			$("#type_comment form button").attr('disabled','disabled');
			$('.alert-danger#comment_hint').hide();
		},
		success: function(responseText, statusText, xhr, $form) {
			$("#type_comment form button").removeAttr('disabled');
        	if (responseText.status === true) {
        		location.reload();
          		return;
        	}
        	$('.alert-danger#comment_hint').show();
        	$('.alert-danger#comment_hint').text(responseText.message);
      	}
	});
	$('.personal_form form').ajaxForm({ //изменение данных в личном кабинете
		url: "/workwithuser.php",
		type: "POST",
		dataType: "json",
		beforeSubmit: function() {
			$(".personal_form form button").attr('disabled','disabled');
			$('.alert-danger#personal_hint').hide();
		},
		success: function(responseText, statusText, xhr, $form) {
			$(".personal_form form button").removeAttr('disabled');
        	if (responseText.status === true) {
          		location.reload();
          		return;
        	}
        	$('#personal_hint').show();
        	$('#personal_hint').text(responseText.message);
      	}
	});
});

function show_details(id) {
	$('.jumbotron .row .col-md-8').load("details.php?storyid="+id);
}

function edit_comment(id) {
	$("a.edit_comment" + id).css('display','none');
	var text = $("div.comment-"+id+" #comment_text p").text();
	var html = 
	'<form method="post">' +
		'<input type="hidden" name="TYPE" value="edit_comment">' +
		'<input type="hidden" name="COMMENT_ID" value="' + id + '">' +
	    '<div class="form-group">' +
			'<textarea class="form-control" rows="3" name="COMMENT_TEXT">' + text + '</textarea>' +
		'</div>' +
		'<div class="form-group"><button type="submit" class="btn btn-success">Сохранить</button></div>' +
	'</form>';
	$("div.comment-"+id+" #comment_text").html(html);
	$("div.comment-"+id+" #comment_text form button").on("click", function() {
		$("div.comment-"+id+" #comment_text form").ajaxForm({ //изменение комментария админом
			url: "/workwithadmin.php",
			type: "POST",
			dataType: "json",
			beforeSubmit: function() {
				$("div.comment-"+id+" #comment_text form button").attr('disabled','disabled');
				$('.alert-danger#comment_hint').hide();
			},
			success: function(responseText, statusText, xhr, $form) {
				$("div.comment-"+id+" #comment_text form button").removeAttr('disabled');
	        	if (responseText.status === true) {
	        		location.reload();
	          		return;
	        	}
	        	console.log(responseText.message);
	        	$('.alert-danger#comment_hint').show();
	        	$('.alert-danger#comment_hint').text(responseText.message);
	      	}
		});
	});
}

function delete_comment(id) {
	$.ajax({
    	type: 'POST',
        url: '/workwithadmin.php',
        data: { TYPE: "delete_comment", COMMENT_ID: id  },
        dataType: 'json',
        beforeSend: function(xhr) {
        	$('.alert-danger#comment_hint').hide();
        },
        success: function(result) {
            if (result.status === true) {
          		location.reload();
          		return;
        	}
        }
   });
}

function edit_message(id) {
	var theme = $("div.jumbotron #story h2").text();
	var text = $("div.jumbotron #story p").text();
	var html = 
	'<form method="post">' +
		'<input type="hidden" name="TYPE" value="edit_message">' +
		'<input type="hidden" name="MESSAGE_ID" value="' + id + '">' +
	    '<div class="form-group">' +
			'<input type="text" class="form-control" name="MESSAGE_THEME" maxlength="255" value="' + theme + '"/>' +
		'</div>' +
	    '<div class="form-group">' +
			'<textarea class="form-control" rows="3" name="MESSAGE_TEXT">' + text + '</textarea>' +
		'</div>' +
		'<div class="form-group"><button type="submit" class="btn btn-success">Сохранить</button></div>' +
	'</form>';
	$("div.jumbotron #story").html(html);
	$("div.jumbotron #story form button").on("click", function() {
		$("div.jumbotron #story form").ajaxForm({ //изменение сообщения админом
			url: "/workwithadmin.php",
			type: "POST",
			dataType: "json",
			beforeSubmit: function() {
				$("div.jumbotron #story form button").attr('disabled','disabled');
				$('.alert-danger#comment_hint').hide();
			},
			success: function(responseText, statusText, xhr, $form) {
				$("div.jumbotron #story form button").removeAttr('disabled');
	        	if (responseText.status === true) {
	        		location.reload();
	          		return;
	        	}
	        	console.log(responseText.message);
	        	$('.alert-danger#comment_hint').show();
	        	$('.alert-danger#comment_hint').text(responseText.message);
	      	}
		});
	});
}

function delete_message(id) {
	$.ajax({
    	type: 'POST',
        url: '/workwithadmin.php',
        data: { TYPE: "delete_message", MESSAGE_ID: id  },
        dataType: 'json',
        beforeSend: function(xhr) {
        	$('.alert-danger#comment_hint').hide();
        },
        success: function(result) {
            if (result.status === true) {
          		window.location.href = '/';
          		return;
        	}
        }
   });
}

function block_user(id) {
	$.ajax({
    	type: 'POST',
        url: '/workwithadmin.php',
        data: { TYPE: "block_user", USER_ID: id  },
        dataType: 'json',
        success: function(result) {
            if (result.status === true) {
          		location.reload();
          		return;
        	}
        }
   });
}
