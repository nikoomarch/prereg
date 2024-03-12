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
                <form action="" method="POST" id="form" onsubmit="create()">
                    <input type="hidden" name="id" id="id">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label">نام</label>
                            <input type="text" class="form-control" name="name" id="name" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="name-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label">تعداد واحد</label>
                            <input type="number" class="form-control" name="unit" id="unit" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="unit-error"></strong>
                            </span>
                        </div>
                    </div>
                    <input type="submit" value="ثبت" class="btn btn-outline-success">
                </form>
            </div>
        </div>
    </div>
</div>
