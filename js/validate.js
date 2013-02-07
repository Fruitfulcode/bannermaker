jQuery('#create_submit,#update_submit').live('click',function() {
	/*var field = new Array("login", "pass", "confirmpass", "e-mail","about");//поля обязательные
		   
	$("form").submit(function() {// обрабатываем отправку формы   
		var error=0; // индекс ошибки
		$("form").find(":input").each(function() {// проверяем каждое поле в форме
			for(var i=0;i<field.length;i++){ // если поле присутствует в списке обязательных
				if($(this).attr("name")==field[i]){ //проверяем поле формы на пустоту
				   
					if(!$(this).val()){// если в поле пустое
						$(this).css('border', 'red 1px solid');// устанавливаем рамку красного цвета
						error=1;// определяем индекс ошибки      
												   
					}
					else{
						$(this).css('border', 'gray 1px solid');// устанавливаем рамку обычного цвета
					}
				   
				}              
			}
	   })
	   
		if(error==0){ // если ошибок нет то отправляем данные
			return true;
		}
		else{
		if(error==1) var err_text = "Не все обязательные поля заполнены!";
		$("#messenger").html(err_text);
		$("#messenger").fadeIn("slow");
		return false; //если в форме встретились ошибки , не  позволяем отослать данные на сервер.
		}
	})*/
	alert('asd');
});