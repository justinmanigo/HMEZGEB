$(document).ready(function(){
    let urlString = window.location.href;
    let paramString = urlString.split('?')[1];
    let queryString = new URLSearchParams(paramString);
    for(let pair of queryString.entries()) {
        console.log("Key is:" + pair[0]);
        console.log("Value is:" + pair[1]);

        if(pair[0] == "new") {
            $(`#${pair[1]}`).modal('show');
            console.log(`Opening modal for #${pair[1]}`);
        }
    }
});

$(document).on('click', '.quick-new-link', function(e){
    e.preventDefault();

    let currentUrl = window.location.href.split('?')[0];
    let redirectUrl = $(this).attr('href');
    let redirectUrlParams = new URLSearchParams(redirectUrl.split('?')[1]);
    let redirectPathName = $(this)[0].pathname;

    console.log(window.location.pathname);
    console.log(redirectPathName);

    // If the current page is the same as the page we're redirecting to, just open the modal
    if(window.location.pathname == redirectPathName) {
        for(let pair of redirectUrlParams.entries()) {
            console.log("Key is:" + pair[0]);
            console.log("Value is:" + pair[1]);
    
            if(pair[0] == "new") {
                $(`#${pair[1]}`).modal('show');
                console.log(`Opening modal for #${pair[1]}`);
            }
        }
    }
    // Otherwise, redirect to the page. The modal will open automatically.
    else {
        window.location.href = redirectUrl;
    }
})