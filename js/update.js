$(function() {
    // Update last navigation time feature
    updateLastNav = function() {
        $.getJSON('index.php?action=update_last_nav', function() {

            // refresh last nav time
            setTimeout(function(){
               updateLastNav();
            }, 180000); // 3 mins
        });
    }
    updateLastNav();
});