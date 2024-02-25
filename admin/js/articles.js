jQuery(document).ready(function($) {
    var airticle_projects = [];
    var published_post_ids = [];
    var featured_post_ids = [];
    function getProjects() {
        $.ajax({
            type: "get",
            url: wp_vars.ajax_url,
            data: {action: "get_projects", nonce: wp_vars.nonce},
            dataType: "json",
            success: function (result) {
                airticle_projects = result;
                loadProjects()
            }
        })
    }

    function loadProjects(){
        for(var i=0; i < airticle_projects.length; i++){
            $('#airticle_projects')
                .append('<option value="'+airticle_projects[i].id+'">'+airticle_projects[i].name+'</option>')
        }
    }

    getProjects()

    $('#publish-articles').on('click', function(){
        $('#publish-articles').addClass('autoblog-d-none');
        $('#publishing-articles').removeClass('autoblog-d-none');
        var schedule = $('input[name="schedule"]:checked').val();
        if(schedule === 'drip'){
            var planning = {
                "period_time" : $('[name="perdiod_time"]').val(),
                "period_type" : $('[name="period_type"]').val(),
                "frequency_type": $('input[name="frequency"]:checked').val()
            };
            if(planning.frequency_type === "static"){
                planning.frequency_hours = $('[name="frequency_hours"]').val();
                planning.frequency_minutes = $('[name="frequency_minutes"]').val();
            }
        }



        $.ajax({
            type: "post",
            url: wp_vars.ajax_url,
            data: {
                action: "publish_articles",
                project_id : $('#airticle_projects').val(),
                category_id : $('select[name="category"]').val(),
                schedule: $('input[name="schedule"]:checked').val(),
                planning: planning,
                nonce:  wp_vars.nonce
            },
            dataType: "json",
            success: function (result) {
                published_post_ids = result;
                addFeaturedImages();
            }
        })
    })

    $('[name="schedule"]').on('input', function(){
        if($(this).val() !== 'drip'){
            $('.schedule-wrapper').empty()
        }
        else{
            buildSchedulePlanner();
        }
    })
    var hours = ["00", "01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", "21", "22", "23", "24"];
    var minutes = ["00", "05", "10", "15", "20", "25", "30", "35", "40", "45", "50", "55", "60"];
    function buildSchedulePlanner(){
        $('.schedule-wrapper').html('<div class="flex flex-col">' +
            ' <div class="flex space-x-3 items-center">' +
            '   <span>Every</span> ' +
            '   <input type="number" name="perdiod_time" min="1" value="1" />'+
            '   <select name="period_type">' +
            '       <option value="day">day</option>' +
            '       <option value="week">week</option>' +
            '       <option value="month">month</option>' +
            '   </select>'+
            ' </div>' +
            ' <div class="autoblog-ai-flex-col autoblog-ai-mt-2">' +
            '   <label for="random"><input type="radio" name="frequency" value="random" id="random" checked> At random times</label>'+
            '   <label for="static"><input type="radio" name="frequency" value="static" id="static" > At specific time</label>' +
            ' </div>' +
            ' <div id="frequency-wrapper"></div>    ' +
            '</div>')
    }

    $('.schedule-wrapper').on('input', '[name=frequency]', function(){
        if($(this).val() === 'random'){
            $('#frequency-wrapper').empty();
        }
        else{
            buildFrequencyPlanner();
        }
    })

    function buildFrequencyPlanner(){
        var selectHours = '<select name="frequency_hours">';
        for(var i =0; i < hours.length; i++){
            selectHours += '<option>'+hours[i]+'</option>';
        }
        selectHours += '</select>';

        var selectMinutes = '<select name="frequency_minutes">';
        for(var i =0; i < minutes.length; i++){
            selectMinutes += '<option>'+minutes[i]+'</option>';
        }
        selectMinutes += '</select>';


        $('#frequency-wrapper').html('<div class="autoblog-ai-flex autoblog-ai-space-x-3 autoblog-ai-items-center autoblog-ai-mt-2">' +
            selectHours + '<span>h</span>'+selectMinutes+'<span>min</span>'+
            '</div>')
    }

    function addFeaturedImages(){

        if(published_post_ids.length > 0){
            var postId = published_post_ids.shift();
            $.ajax({
                type: "post",
                url: wp_vars.ajax_url,
                data: {
                    action: "set_featured_image",
                    post_id: postId,
                    nonce:  wp_vars.nonce
                },
                dataType: "json",
                success: function (result) {
                    featured_post_ids.push(postId);
                    setTimeout(function () {
                        if (published_post_ids.length === 0) {
                            $('#publish-articles').removeClass('autoblog-d-none');
                            $('#publishing-articles').addClass('autoblog-d-none');
                        } else {
                            addFeaturedImages();
                        }
                    }, 300)
                }
            })
        }
    }
});
