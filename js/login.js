$(document).ready(function(){
	$("#btnLogin").click(function(){
		handler.login();
	});
	var handler = {
		login: function()
		{
			try{
               
                if( ! $("[name='username']").val())
                    throw { msg : "Please Enter Username" , elem : "[name='username']"}
                if( ! $("[name='password']").val())
                    throw { msg : "Please Enter password" , elem : "[name='password']"}
            }
            catch(e){
                alert(e.msg);
                setTimeout(function(){$(e.elem).focus()},0);
                return;
            }
	        
	        var formData = $("[name='loginForm']").serializeArray();
	        console.log(formData);
	        formData.push({name: 'action', value: 'login'});
	        $.ajax({ 
	             url: 'server/',
	             data: formData,
	             type: 'post', 
	             dataType: 'json',        
	             success: function(data) 
	             {
	             	if(data['error'] == 0)
	             	{
	             		window.location.href = "dashboard.php";	                    
	             	}
	             	else
	             		alert(data['message']);
	             }
	        });
		}
	};
});