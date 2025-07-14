  $(document).ready(function(){
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye-slash fa-eye");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
  });