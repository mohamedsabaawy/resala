@section('title','إدارة الصفات')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الصفات</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @can('position create')
            <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()"
                    data-target="#create-model">
                اضافة صفة
            </button>
        @endcan
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            @if(count($positions)>0)
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    {{--                    <th>النوع</th>--}}
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($positions as $position)
                <tr>
                    <td>{{$position->id}}</td>
                    <td>{{$position->name}}</td>
                    <td>
                        <div class="btn-group">
                            @can('position delete')
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#delete-model"
                                        wire:click="show({{$position->id}})">مسح
                                </button>
                            @endcan
                            @can('position edit')
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#create-model" wire:click="show({{$position->id}})">تعديل
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
        {{$positions->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create position model -->
{{--    wire:ignore.self--}}
<!-- start position model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل صفة" :"انشاء صفة جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم الصفة</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name"
                               placeholder="ادخل اسم الصفة">
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>
                    {{--                    <div class="form-group">--}}
                    {{--                        <label for="exampleInputEmail1">نوع المستخدم</label>--}}
                    {{--                        <select class="form-control select2" style="width: 100%;" wire:model="role">--}}
                    {{--                            <option>اختر</option>--}}
                    {{--                            <option value="admin">مدير النظام</option>--}}
                    {{--                            <option value="supervisor">مشرف</option>--}}
                    {{--                            <option value="user">مستخدم عادي</option>--}}
                    {{--                        </select>--}}
                    {{--                        <div class="text-danger">@error('role') {{ $message }} @enderror</div>--}}
                    {{--                    </div>--}}

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
    <!--position model -->

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
                    {{--                    <h3></h3>--}}
                    <h4>{{$name}}</h4>
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
        //     $('#create-position').modal('hide');
        // });
        // });
    </script>

    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
