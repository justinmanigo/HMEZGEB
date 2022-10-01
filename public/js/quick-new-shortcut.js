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