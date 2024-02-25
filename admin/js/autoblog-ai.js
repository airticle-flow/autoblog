jQuery(document).ready(function($) {

    $('#check_token').on('click', function () {
        var token = $('#autoblog_token').val()
       $.ajax({
           url: 'https://airticle-flow.com/api/user',
           headers: {
               "Authorization": "Bearer " + token
           },
           type: "get",
           dataType: 'json',
           success: function(result){
               if(result.id){
                   $.ajax({
                       type: "post",
                       url : wp_vars.ajax_url,
                       data: { token : token , action: 'save_token', nonce:  wp_vars.nonce},
                       success: function(){
                           window.location.reload();
                       }
                   })
               }
           }
       })
    })


    $('#revoke_token').on('click', function(){
        $.ajax({
            type: "post",
            url : wp_vars.ajax_url,
            data: {  action: 'revoke_token', nonce:  wp_vars.nonce},
            success: function(){
                window.location.reload();
            }
        })
    })


    $('#generate_articles').on('click', function(){
        var prompt = $('#autoblog-ai-prompt').val()
        if(prompt.trim().length > 0){
            $.ajax({
                type: "post",
                url : wp_vars.ajax_url,
                data: { prompt : prompt, action : "generate_articles" },
                success: function(){

                }
            })
        }

    })
})

