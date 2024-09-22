@section('title','إدارة الاجتماعات')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الاجتماعات</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                @can('meeting create')
                <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()"
                        data-target="#create-model">
                    اضافة اجتماع
                </button>
                @endcan
            </div>
            <div class="form-group clearfix col-6">
                <div class="icheck-primary">
                    <input type="checkbox" id="checkboxPrimary1" wire:model.live="withTrash">
                    <label for="checkboxPrimary1" class="float-right">
                    </label>
                </div>
            </div>
            <div class="col-12">
{{--                @can('user export')--}}
                    <div class="row border">
                        <div class="form-group col">
                            <label class="col-form-label">من</label>
                            <input class="form-control" dir="rtl" type="date" wire:model.live="filter_from">
                        </div>
                        <div class="form-group col">
                            <label class="col-form-label">الي</label>
                            <input class="form-control" dir="rtl" type="date" wire:model.live="filter_to">
                        </div>
                        <button type="button" class="form-control btn btn-info col-12" data-toggle="modal"
                                wire:click="export()">
                            تصدير
                        </button>
                    </div>
{{--                @endcan--}}

            </div>
        </div>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            @if(count($meetings)>0)
                <tr>
                    <th>التارخ</th>
                    <th>هدف الاجتماع</th>
                    <th>رئيس الاجتماع</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($meetings as $meeting)
                <tr class="{{$meeting->deleted_at ? 'bg-gradient-gray':''}}">
                    <td>{{$meeting->date}}</td>
                    <td>{{$meeting->title}}</td>
                    <td>{{$meeting->user->name}}</td>
                    <td>
                        <div class="btn-group">
                            @can('meeting delete')
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-model"
                                    wire:click="show({{$meeting->id}})"><i class="fa fa-trash"></i>مسح
                            </button>
                            @endcan
                            @can('meeting edit')
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#create-model" wire:click="show({{$meeting->id}})"><i
                                        class="fa fa-edit"></i>تعديل
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <h3 class="text-center">لا يوجد بيانات لعرضها</h3>
            @endforelse
            </tbody>
            <tfoot>
            <div>
            </div>
            </tfoot>
        </table>
        {{$meetings->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create meeting model -->
{{--    wire:ignore.self--}}
<!-- start meeting model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل اجتماع" :"انشاء اجتماع جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">هدف الاجتماع</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="title"
                               placeholder="ادخل اسم الاجتماع">
                        <div class="text-danger">@error('title') {{ $message }} @enderror</div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12 col-sm-6">
                            <label for="exampleInputEmail1">رئيس الاجتماع</label>
                            <select class="form-control @error('user_id') is-invalid @enderror" wire:model="user_id">
                                <option value=null>اختر</option>
                                @foreach($users as $key =>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <div class="text-danger">@error('user_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="form-group col-12 col-sm-6">
                            <label for="exampleInputEmail1">النشاط</label>
                            <select class="form-control @error('job_id') is-invalid @enderror" wire:model="job_id">
                                <option value=null>اختر</option>
                                @foreach($jobs as $key =>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                            <div class="text-danger">@error('job_id') {{ $message }} @enderror</div>
                        </div>
                        <div class="form-group col-12 col-sm-4">
                            <label for="exampleInputEmail1">نوع المشاركة</label>
                            <select class="form-control @error('status') is-invalid @enderror" wire:model="status">
                                <option value=0>اوفلاين</option>
                                <option value=1>اونلاين</option>
                            </select>
                            <div class="text-danger">@error('status') {{ $message }} @enderror</div>
                        </div>
                        <div class="form-group col-12 col-sm-4">
                            <label for="exampleInputEmail1">تاريخ الاجتماع</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror"
                                   wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="date"
                                   placeholder="ادخل تاريخ الاجتماع">
                            <div class="text-danger">@error('date') {{ $message }} @enderror</div>
                        </div>
                        <div class="form-group col-12 col-sm-4">
                            <label for="exampleInputEmail1">عدد الحاضرين</label>
                            <input type="number" class="form-control @error('count') is-invalid @enderror"
                                   wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="count"
                                   placeholder="ادخل عدد الحاضرين">
                            <div class="text-danger">@error('count') {{ $message }} @enderror</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ملاحظات</label>
                        <textarea class="form-control @error('comment') is-invalid @enderror" wire:model="comment">

                        </textarea>
{{--                        <input type="number" class="form-control @error('comment') is-invalid @enderror"--}}
{{--                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="comment"--}}
{{--                               placeholder="ادخل عدد الحاضرين">--}}
                        <div class="text-danger">@error('comment') {{ $message }} @enderror</div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary" wire:click="{{$isUpdate ? "update()" : "save()"}}"
                            wire:loading.attr="disabled">حفظ
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--meeting model -->

    <!-- /.modal-dialog delete -->
    <div wire:ignore.self class="modal fade" id="delete-model">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title"> هل انت متاكد من مسح : </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>{{$title}}</h4>
                    @if($deleted_at )
                        <h5 class="bg-gradient-gray">لا يمكن استرجعها مرة اخري</h5>
                    @endif
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-outline-light" wire:click="delete()"
                            wire:loading.attr="disabled">تأكيد
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal-dialog delete -->

</div>

@push('style')


@endpush

@push('script')
    <script>
        // $(function () {
        //     $("#example1").DataTable();
        //     $('#example2').DataTable({
        //         "paging": true,
        //         "lengthChange": false,
        //         "searching": false,
        //         "ordering": true,
        //         "info": true,
        //         "autoWidth": false,
        //     });
        // });


        // document.addEventListener('livewire:initialized', () => {
        // @this.on('close-createBranch', (event) => {
        //     $('#create-meeting').modal('hide');
        // });
        // });


    </script>

    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
