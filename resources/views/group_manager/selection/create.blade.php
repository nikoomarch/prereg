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
                <form action="{{route('selection.store')}}" method="POST" id="form" onsubmit="create()">
                    <input type="hidden" name="field_id" id="field_id" value="{{auth()->user()->field_id}}">
                    <input type="hidden" name="id" id="id">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label" data-toggle="tooltip" data-placement="top" title="ترم های ورودی مجاز به انتخاب واحد">ترم ها</label>
                            <select class="form-control @error('terms') is-invalid @enderror" name="terms[]" id="terms" multiple="multiple">
                                @foreach($terms as $term)
                                    <option value="{{"{$term->id}-M"}}">{{"{$term->code} - آقایان"}}</option>
                                    <option value="{{"{$term->id}-F"}}">{{"{$term->code} - بانوان"}}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong id="terms-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label" data-toggle="tooltip" data-placement="top" title="تاریخ شروع انتخاب واحد">تاریخ شروع</label>
                            <input type="text" class="form-control" id="start_date" required/>
                            <input type="hidden" name="start_date" id="start_date_alt">
                            <span class="invalid-feedback" role="alert">
                                <strong id="start_date-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label" data-toggle="tooltip" data-placement="top" title="تاریخ پایان انتخاب واحد">تاریخ پایان</label>
                            <input type="text" class="form-control" id="end_date" required/>
                            <input type="hidden" name="end_date" id="end_date_alt">
                            <span class="invalid-feedback" role="alert">
                                <strong id="end_date-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label" data-toggle="tooltip" data-placement="top" title="سقف واحد مجاز برای انتخاب واحد">حداکثر تعداد واحد</label>
                            <input type="number" class="form-control" name="max" id="max" >
                            <span class="invalid-feedback" role="alert">
                                <strong id="max-error"></strong>
                            </span>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="text-left col-form-label">ترم انتخاب واحد</label>
                            <select class="form-control @error('term') is-invalid @enderror" name="term" id="term" >
                                @foreach($terms as $term)
                                    <option value="{{$term->code}}">{{$term->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class=" form-group col-md-4">
                            <div class="form-check">
                                <label class="form-check-label form-check-toggle">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1">
                                    <span>ترم فعال</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">بازگشت</button>
                        <input type="submit" value="ثبت" class="btn btn-success">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
