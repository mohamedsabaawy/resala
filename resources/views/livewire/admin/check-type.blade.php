@section('title','إدارة الاختبارات')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الاختبارات</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()" data-target="#create-model">
            اضافة اختبار
        </button>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            @if(count($checkTypes)>0)
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الحالة</th>
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($checkTypes as $checkType)
                <tr>
                    <td>{{$checkType->id}}</td>
                    <td>{{$checkType->name}}</td>
                    <td class="badge {{$checkType->active == 1 ? "badge-success" : "badge-danger"}}">{{$checkType->active == 1 ? "نشط" : "غير نشط"}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-model" wire:click="show({{$checkType->id}})" >مسح</button>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#create-model" wire:click="show({{$checkType->id}})">تعديل</button>
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
        {{$checkTypes->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create checkType model -->
{{--    wire:ignore.self--}}
<!-- start checkType model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex" >
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل اختبار" :"انشاء اختبار جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم الاختبار</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name" placeholder="ادخل اسم الاختبار">
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">حالة الاختبار</label>

                        <select class="form-control select2 @error('active') is-invalid @enderror" style="width: 100%;" wire:model="active">
                            <option value="1">نشط</option>
                            <option value="0">غير نشط</option>
                        </select>
                        <div class="text-danger">@error('active') {{ $message }} @enderror</div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-primary" wire:click="{{$isUpdate ? "update()" : "save()"}}" wire:loading.attr="disabled">حفظ</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!--checkType model -->

    <!-- /.modal-dialog delete -->
    <div wire:ignore.self class="modal fade" id="delete-model">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex" >
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title"> هل انت متاكد من مسح : </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{--                    <h3></h3>--}}
                    <h4>{{$name}}</h4>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">اغلاق</button>
                    <button type="button" class="btn btn-outline-light" wire:click="delete()" wire:loading.attr="disabled">تأكيد</button>
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
        //     $('#create-checkType').modal('hide');
        // });
        // });
    </script>
    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
