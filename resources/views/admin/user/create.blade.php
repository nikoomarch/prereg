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
                            <label class="text-left col-form-label">نام خانوادگی</label>
                            <input type="text" class="form-control" name="family" id="family" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="family-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label">رشته</label>
                            <input type="text" class="form-control" name="field" id="field">
                            <span class="invalid-feedback" role="alert">
                                <strong id="field-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label">نام کاربری</label>
                            <input type="text" class="form-control" name="username" id="username" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="username-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="text-left col-form-label">رمز عبور</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <span class="invalid-feedback" role="alert">
                                <strong id="password-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="text-left col-form-label">تکرار رمز عبور</label>
                            <input type="password" class="form-control" name="confirm" id="confirm">
                            <span class="invalid-feedback" role="alert">
                                <strong id="confirm-error"></strong>
                            </span>
                        </div>
                    </div>
                    <input type="submit" value="ثبت" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>
