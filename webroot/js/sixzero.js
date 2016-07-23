String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second parm
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    if (hours == '00') {
        return minutes+':'+seconds;
    } else {
        return hours+':'+minutes+':'+seconds;
    }
}

function showAlert(type, msg) {
    var html = '<div data-alert class="alert-box ' + type + '">';
    html += msg;
    html += '<a href="#" class="close">&times;</a></div>';
    $('body').prepend(html);
    $(document).foundation();
}
function clearAlert() {
    $('.alert-box').remove();
}