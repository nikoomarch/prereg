<div class="modal fade" id="insertModal" tabindex="-1" role="dialog" aria-labelledby="insertModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ثبت</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="form" onsubmit="create()">
                    <div class="form-group row">
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="کد" name="code" id="code" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="code-error"></strong>
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <input type="submit" value="ثبت" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
