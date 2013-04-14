$(document).ready(function(){
    
    //Get the URL as a hidden field
    var url = $('#url').val();
    
    //Send the post request 
    $('#resize-images').on('click', function(){
        //Show the loading image
        $('#loading-image').show();
        
        //Empty the results text and remove the class
        $('#results').text('').removeClass();
        
        $.post(url + 'admin/ajax/resize-images.php', function(data, status){
            if(status === "success"){
                $('#results').text('All the thumbnails has been resized successfully.').addClass('ok');
            }
            else{
                $('#results').text('Error, something went wrong during the reisizing operation.').addClass('error');
            }
            $('#loading-image').hide();
        });    
    });

});

