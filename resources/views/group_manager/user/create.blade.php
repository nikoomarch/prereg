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
                            <label for="name" class="text-left col-form-label">نام</label>
                            <input type="text" class="form-control" name="name" id="name" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="name-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="family" class="text-left col-form-label">نام خانوادگی</label>
                            <input type="text" class="form-control" name="family" id="family" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="family-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="gender" class="text-left col-form-label">جنسیت</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="" disabled selected>انتخاب کنید ...</option>
                                <option value="M">مرد</option>
                                <option value="F">زن</option>
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong id="gender-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label">کد دانشجویی</label>
                            <input type="text" class="form-control" name="username" id="username" >
                            <small class="form-text text-muted">کد دانشجویی به عنوان نام کاربری منظور خواهد شد.</small>
                            <span class="invalid-feedback" role="alert">
                                <strong id="username-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="national_code" class="text-left col-form-label">کد ملی</label>
                            <input type="text" class="form-control" name="national_code" id="national_code">
                            <small class="form-text text-muted">کد ملی به عنوان رمز عبور پیشفرض منظور خواهد شد.</small>
                            <span class="invalid-feedback" role="alert">
                                <strong id="national_code-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="entrance_term_id" class="text-left col-form-label">ترم ورود</label>
                            <select class="form-control" name="entrance_term_id" id="entrance_term_id" >
                                @foreach($terms as $term)
                                    <option value="{{$term->id}}">{{$term->code}}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong id="entrance_term_id-error"></strong>
                            </span>
                        </div>
                        <div class=" form-group col-md-4">
                            <div class="form-check">
                                <label class="form-check-label form-check-toggle">
                                    <input class="form-check-input" type="checkbox" name="is_allowed" id="is_allowed" value="1">
                                    <span>امکان ورود</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="ثبت" class="btn btn-success">
                </form>
            </div>
        </div>
    </div>
</div>
