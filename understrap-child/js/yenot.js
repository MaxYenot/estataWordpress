jQuery(function($){
	$(document).on( 'submit', '#estateForm', function(e){
		e.preventDefault();
		
		$(this).hide();
		$("#estateStatus").html('<div class="alert alert-info">Подождите! Идет отправка объекта недвижимости.</div>');
		
		var formObj = {
			action: "r_submit_user_estate"
			,title: $("#e_inputTitle").val
			,content: tinymce.activeEditor.getContent()
		};
		
		$.post( recipe_obj.ajax_url, formObj, function(data){
			console.log(data);
			if(data.status == 2){
				$("#estateStatus").html('<div class="alert alert-success">Объект недвижимости успешно добавлен. Он появится на сайте после подтверждения администратором.</div>');
			}else{
				$("#estateStatus").html('<div class="alert alert-success">Не удалось добавить объект недвижимости. Возможно, Вы не заполнили все поля</div>');
				$("#estateForm").show();
			}
		} );
		
	});
	
});