
$(document).ready(function() {
    // Hide the second form initially
    // $('.second').hide();
    
    // Attach click event handlers to the links
    $('#signup').click(function() {
        // Hide the first form and show the second form
        $('.first').slideUp("slow", function() {
            $('.second').slideDown("slow");     
        });        
    });
    
    $('#signin').click(function() {
        // Hide the first form and show the second form
        $('.second').slideUp("slow", function() {
            $('.first').slideDown("slow");     
        });        
    });
});
    


