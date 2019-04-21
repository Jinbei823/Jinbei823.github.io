//Cookie
$(function(){
    // 1回目のアクセス
    if($.cookie("access") == undefined) {
      alert("ようこそ！\n作業できる場所をお探しですね？\nサッと探してサッとタスクを終わらせましょう！");
      $.cookie("access","onece");
      $(".mod_message").css("display","block")
    // 2回目以降
    } else {
      alert("再度ご利用ありがとうございます！");
    }
  });
   
  // Message close
  $(function() {
    $(".mod_message .close").click(function(){
      $(".mod_message").css("display","none")
    });
  });