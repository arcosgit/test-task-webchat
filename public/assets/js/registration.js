$(function(){
    $("form").on("submit", function(e){
        e.preventDefault();
        let password = $("#password").val();
        let passwordConfirm = $("#password_confirm").val();
        if(password !== passwordConfirm){
            $(".form_error_password").text("Пароли не совпали");
            return;
        }
    })
});