var idleTime;
$(document).ready(function () {
        authCheck();
});

function authCheck() {
    // clearTimeout(idleTime);
    idleTime = setInterval(function () {
        // Check if the user is still authenticated.
        // If not, then alert user to login again.
        $.ajax({
            url: '/check-authentication',
            type: 'GET',
            success: function (response) {
                console.log("Checking user authentication.");
                console.log(response);
                if (response == "") {
                    alert('Your session has expired. Please login again.');
                    location.reload();
                }
            }
        });
    }, 30000);
}
