$(document).ready(function(){
    
    //DOM element : table
    var table = $('.all-partners');
    
    //DOM element : td of the table
    var partners = table.find('td');
    
    //For each td of the table
    partners.each(function(){
        
        //When the user click on it
        $(this).on('click', function(){
           //It adds or remove a class if already set
           $(this).toggleClass('in-use');
        });
        
    });
    
    //When the user click on the 'save list' button
    $('#save-partner-list').on('click', function(){
        
        //Show the loading image
        $('#loading-image').show();
        
        //Empty the results text and remove the class
        $('#results').text('').removeClass();
        
        //Array which will contain all the partners to add to the list
        var partners_array = new Array();
        
        //For each td of the table
        partners.each(function(){
            //If it has been selected
            if($(this).hasClass('in-use')){
                //Add it to the array
                partners_array.push($(this).attr('id'));
            }
        });
        
        //Get the URL as a hidden field
        var url = $('#url').val();
        
        //Get the list ID as a hidden field
        var list_id = $('#list_id').val();
        
        //Send the post request with the array of partners as a parameter
        $.post(url + 'admin/ajax/update-partner-list.php', {'partners': partners_array, 'list_id': list_id}, function(data, status){
            if(status === "success"){
                $('#results').text('List updated successfully.').addClass('ok');
            }
            else{
                $('#results').text('Error, something went wrong.').addClass('error');
            }
            $('#loading-image').hide();
        });
    });
    
});
