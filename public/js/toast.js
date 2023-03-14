var toast_number = 0;

function toast(message, type, duration = 5000) {
    var toast_container = document.getElementById("toast-container");
    var number = toast_number;
    window.toast_number++;

    var toast = `
        <div id="toast-${number}" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="${duration}">
            <div class="toast-header">
                <strong class="mr-auto">${message}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    `;

    setTimeout(function(){
        console.log("This is executed.", number)
        $(`#toast-${number}`).remove();
    }, duration+1000)

    toast_container.innerHTML += toast;

    $(`.toast`).toast('show');

}
