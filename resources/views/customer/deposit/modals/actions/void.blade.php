<form id="void-deposit" action="" method="POST">
    @csrf
    <div class="modal fade" id="modal-void-confirmation" tabindex="-1" role="dialog" aria-labelledby="modal-void-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-void-label">Void Record</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to void deposit record?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Void</button>
                </div>
            </div>
        </div>
    </div>
</form>