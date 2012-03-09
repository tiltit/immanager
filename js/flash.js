// Mimic Flash::set() messages
// optional $object to focus
function flash(type,message,target) {
    switch(type) {
        case 'success': case 'info': case 'error':
        break;
        default:
            type = 'info';
        break;
    }
    $flashBox = $('<div id="'+type+'" class="message" style="display: none">'+message+'</div>');
    $flashBox.appendTo('#header')
        .fadeIn('slow')
        .animate({opacity: 1.0}, 1500)
        .fadeOut('slow', function() {
            $(this).remove();
            if(target)
                target.focus();
        });
}


