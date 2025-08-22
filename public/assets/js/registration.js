$(function(){
    $("form").on("submit", function(e){
        let password = $("#password").val();
        let passwordConfirm = $("#password_confirm").val();
        if(password !== passwordConfirm){
            e.preventDefault();
            $(".form_error_password").text("Пароли не совпали");
            return;
        }
    })
});