$(function(){
   $(".chats_block_btn_sendmessage").on("click", function(){
        let secondUserId = $(this).data("id");
        $.ajax({
            url: "сreate_or_get_chat.php",
            type: "POST",
            data: { second_user_id: secondUserId },
            success: function(response){
                let data = JSON.parse(response);
                if(data.success){
                    window.location.href = "chat.php?chatId=" + data.chat_id;
                } else {
                    alert("Ошибка: " + data.message);
                }
            }
        });
    });
})