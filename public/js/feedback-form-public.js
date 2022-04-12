jQuery( document ).ready(function($) {
    
    $("#CodeableFeedbackForm").submit(function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var actionUrl = form.attr('action');
        
        // remove all error placeholders
        form.find('small.cff-error').remove();

        // start spinner
        form.find(".spinner").addClass("is-active"); 

        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function(response){
                
                // stop spinner
                form.find(".spinner").removeClass("is-active");

                if(response.success){
                    form.trigger("reset");
                    form.parent().addClass("after-submit");
                } else{
                    // when there are errors
                    $.each(response.data, function( index, value ) {
                        form.find('#'+index).after('<small class="cff-error"><em>'+value+'</em></small>');
                    });
                }

            }
        });
        
    });

    /* PAGINATION JS */
    $("#CodeableFeedbackForm-list-wrapper").on("click", '.cvf-universal-pagination li.active', function (){
        
        var page = $(this).data('p');
        $('#CodeableFeedbackForm-list-wrapper').find('.pagination-loading').addClass('active');
        $.ajax({
            type: "GET",
            url: ajax.url,
            data: {
                "action": 'codeable_get_feedbacks',
                "page" : page,
                "feedback_nonce" : ajax.feedback_nonce
            },
            success: function(response){
                
                $('#CodeableFeedbackForm-list-wrapper').html(response);
                $('#CodeableFeedbackForm-list-wrapper').find('.pagination-loading').removeClass('active');

            }
        });

    });


    /* View detail */
    
    $("#CodeableFeedbackForm-list-wrapper").on("click", 'button.view-details', function (){
        
        var id = $(this).data('id');
        $('#CodeableFeedbackForm-list-wrapper').find('tr.single-view').remove();
        $('#CodeableFeedbackForm-list-wrapper').find('button.view-details').text("Open");
        $('#CodeableFeedbackForm-list-wrapper').find('button.view-details').prop("disabled", false);

        $(this).text("Wait...");


        $.ajax({
            type: "POST",
            url: ajax.url,
            data: {
                "action": 'codeable_get_single_feedback',
                "id" : id,
                "feedback_nonce" : ajax.feedback_nonce
            },
            success: function(response){
                
                $('#CodeableFeedbackForm-list-wrapper').find('.row-'+id).after('<tr class="single-view"><td colspan="7">'+response+'</td></tr>')
                $('#CodeableFeedbackForm-list-wrapper').find('.row-'+id).find('button.view-details').text("Open");
                $('#CodeableFeedbackForm-list-wrapper').find('.row-'+id).find('button.view-details').prop("disabled", true);

            }
        });

    });

});
