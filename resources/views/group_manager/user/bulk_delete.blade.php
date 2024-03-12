<div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog" aria-labelledby="bulkDeleteModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف گروهی دانشجویان</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="bulkDeleteForm" onsubmit="bulkDelete()">
                    <div class="form-group row justify-content-center">
                        <label class="text-left col-form-label" data-toggle="tooltip" data-placement="top" title="">ترم ها</label>
                        <div class="col-md-3">
                            <select class="form-control" name="terms[]" multiple="multiple" style="width:100%;">
                                @foreach($terms as $term)
                                    <option value="{{$term->code}}">{{$term->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="cursor btn btn-danger" type="submit">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>