@extends('layouts.app')
@section('title')
    تعریف انتخاب واحد
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-end mt-3">
            <div class="col-md-2">
                <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#insertModal">
                    ثبت انتخاب واحد جدید
                </button>
            </div>
        </div>
        <div class="card table-responsive p-2 mt-4">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover mt-3">
                    <thead class="thead-light">
                    <th scope="col">ترم های ورودی مجاز به انتخاب واحد</th>
                    <th scope="col">تاریخ شروع انتخاب واحد</th>
                    <th scope="col">تاریخ اتمام انتخاب واحد</th>
                    <th scope="col">سقف واحد مجاز برای انتخاب واحد</th>
                    <th scope="col">ترم انتخاب واحد</th>
                    <th scope="col">ترم فعال</th>
                    <th scope="col">عملیات</th>
                    </thead>
                    <tbody>
                    @foreach($selections as $selection)
                        <tr id="selection-{{$selection->id}}">
                            <td>
                                @foreach($selection->allowedTerms as $term)
                                    {{$term->code}} - {{$term->pivot->gender == 'M' ? 'آقایان':'بانوان'}}
                                    @if(!$loop->last)
                                        ||
                                    @endif
                                @endforeach
                            </td>
                            <td>{{\Morilog\Jalali\Jalalian::fromDateTime($selection->start_date)->format('Y/m/d')}}</td>
                            <td>{{\Morilog\Jalali\Jalalian::fromDateTime($selection->end_date)->format('Y/m/d')}}</td>
                            <td>{{$selection->max}}</td>
                            <td>{{$selection->term}}</td>
                            <td>
                                <i @class([
                                'fa fa-check-circle text-success' => $selection->is_active,
                                'fa fa-times-circle text-danger' => !$selection->is_active
                                ])></i>
                            </td>
                            <td>
                                <button class="btn"
                                        onclick="edit('{{$selection->id}}')"
                                        data-toggle="tooltip" data-placement="top" title="تغییر">
                                    <i class="fa fa-edit text-primary fa-lg pointer"></i>
                                </button>
                                <button class="btn" onclick="del('{{$selection->id}}')" data-toggle="tooltip"
                                        data-placement="top" title="حذف"><i class="fa fa-minus text-danger pointer"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
            </div>
        </div>
        @include('group_manager.selection.create')
    </div>
@endsection
@section('script')
    <script>
        let fields = ['id', 'terms', 'start_date', 'end_date', 'max', 'term'];
        $(document).ready(function () {
            $('#insertModal').on('hide.bs.modal', function (e) {
                $('input[type="submit"]').prop('value', 'ثبت').removeClass('btn-warning').addClass('btn-success');
                $('#id').val('').prop('disabled', true);
                clearErrors(fields);
                clearForm(fields);
            });
            $('#start_date').pDatepicker({
                autoClose: true,
                format: 'YYYY/MM/DD',
                altField: '#start_date_alt',
                altFormat: 'X',
                toolbox: {
                    calendarSwitch: {
                        enabled: false
                    }
                },
                initialValueType: 'gregorian'
            });
            $('#end_date').pDatepicker({
                autoClose: true,
                format: 'YYYY/MM/DD',
                altField: '#end_date_alt',
                altFormat: 'X',
                toolbox: {
                    calendarSwitch: {
                        enabled: false
                    }
                },
                initialValueType: 'gregorian'
            });
            $('select[name="term"]').select2({theme: 'bootstrap4'});
            $('select[name="terms[]"]').select2({theme: 'bootstrap4'});
        });

        function edit(id) {
            NProgress.start();
            axios({
                'method': 'GET',
                'url': `/selection/${id}`,
            }).then(function (response) {
                NProgress.done();
                let data = response.data;
                $('#id').val(data.id);
                $('#is_active').prop('checked', data.is_active);
                let start_date = Date.parse(data.start_date);
                let pd = $('#start_date').persianDatepicker({
                    autoClose: true,
                    format: 'YYYY/MM/DD',
                    altField: '#start_date_alt',
                    altFormat: 'X',
                    toolbox: {
                        calendarSwitch: {
                            enabled: false
                        }
                    },
                });
                pd.setDate(start_date);
                let end_date = Date.parse(data.end_date);
                pd = $('#end_date').persianDatepicker({
                    autoClose: true,
                    format: 'YYYY/MM/DD',
                    altField: '#end_date_alt',
                    altFormat: 'X',
                    toolbox: {
                        calendarSwitch: {
                            enabled: false
                        }
                    },
                });
                pd.setDate(end_date);
                $('#max').val(data.max);
                let terms = [];
                data.allowed_terms.forEach(function (term) {
                    terms.push(`${term.id}-${term.pivot.gender}`);
                });
                $('#terms').val(terms).trigger('change');
                $('#term').val(data.term).trigger('change');
                $('input[name="_method"]').prop('disabled', false);
                $('input[type="submit"]').prop('value', 'تغییر');
                $('#insertModal').modal('show');
                $('#form').prop('action', `/project/${id}`);
            }).catch(function (error) {
                console.log(error);
            });
        }

        function create() {
            event.preventDefault();
            clearErrors(fields);
            let id = $('#id').val();
            if (id == '')
                store();
            else
                update(id);
        }

        function store() {
            let field_id = $('#field_id').val();
            let terms = $('#terms').val();
            let max = $('#max').val();
            let term = $('#term').val();
            let start_date = $('#start_date_alt').val();
            let end_date = $('#end_date_alt').val();
            let is_active = $('#is_active:checkbox:checked').length > 0;
            NProgress.start();
            axios({
                method: 'POST',
                url: '/selection',
                data: {
                    field_id: field_id,
                    terms: terms,
                    max: max,
                    term: term,
                    start_date: start_date,
                    end_date: end_date,
                    is_active: is_active
                }
            }).then(function (res) {
                NProgress.done();
                Swal.fire({
                    title: 'موفقیت آمیز',
                    text: "با موفقیت انجام شد.",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'خب!',
                }).then((result) => {
                    location.reload();
                })
            }).catch(function (error) {
                let errors = error.response.data.errors;
                console.log(errors);
                Object.keys(errors).forEach(function (index) {
                    console.log('#' + index + '-error');
                    $('#' + index).addClass('is-invalid');
                    $('#' + index + '-error').text(errors[index]);
                });
                NProgress.done();
            })
        }

        function update(id) {
            let field_id = $('#field_id').val();
            let terms = $('#terms').val();
            let max = $('#max').val();
            let term = $('#term').val();
            let start_date = $('#start_date_alt').val();
            let end_date = $('#end_date_alt').val();
            let is_active = $('#is_active:checkbox:checked').length > 0;
            NProgress.start();
            axios({
                method: 'PUT',
                url: `/selection/${id}`,
                data: {
                    field_id: field_id,
                    terms: terms,
                    max: max,
                    term: term,
                    start_date: start_date,
                    end_date: end_date,
                    is_active: is_active
                }
            }).then(function (res) {
                NProgress.done();
                Swal.fire({
                    title: 'موفقیت آمیز',
                    text: "با موفقیت انجام شد.",
                    type: 'success',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'خب!',
                }).then((result) => {
                    location.reload();
                })
            }).catch(function (error) {
                let errors = error.response.data.errors;
                console.log(errors);
                Object.keys(errors).forEach(function (index) {
                    console.log('#' + index + '-error');
                    $('#' + index).addClass('is-invalid');
                    $('#' + index + '-error').text(errors[index]);
                });
                NProgress.done();
            })
        }

        function del(id) {
            Swal.fire({
                title: 'آیا مطمئن هستید؟',
                text: "این عمل قابل بازگشت نیست",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'بله',
                cancelButtonText: 'خیر'
            }).then((result) => {
                if (result.value) {
                    NProgress.start();
                    axios({
                        'method': 'DELETE',
                        'url': `selection/${id}`
                    }).then(function (response) {
                        NProgress.done();
                        $(`#selection-${id}`).fadeOut();
                    }).catch(function (error) {
                        console.log(error);
                    })
                }
            });
        }
    </script>
@endsection
