$(function(){
    $("form").submit(function(e){
        var $form = $(this);
        $.ajax({
            type: "POST",
            data: {'prompt': $form.find('textarea').html()},
            url: $form.attr('action'),
            success: function (data) {
                $("#response .data").html(data);
                $("#response .spinner").hide();
            },
            dataType: 'html',
            beforeSend: function () {
                $("#response .spinner").show();
            }
        });
        return false;
    });
});
