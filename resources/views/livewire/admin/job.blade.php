@section('title','إدارة الانشطة')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الانشطة</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                @can('job create')
                <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()"
                        data-target="#create-model">
                    اضافة نشاط
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
        </div>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            @if(count($jobs)>0)
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>المدير</th>
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($jobs as $job)
                <tr class="{{$job->deleted_at ? 'bg-gradient-gray':''}}">
                    <td>{{$job->id}}</td>
                    <td>{{$job->name}}</td>
                    <td>{{$job->manager->name ?? ''}}</td>
                    <td>
                        <div class="btn-group">
                            @can('job delete')
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-model"
                                    wire:click="show({{$job->id}})"><i class="fa fa-trash"></i>مسح
                            </button>
                            @endcan
                            @can('job edit')
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#create-model" wire:click="show({{$job->id}})"><i
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
        {{$jobs->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create job model -->
{{--    wire:ignore.self--}}
<!-- start job model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل نشاط" :"انشاء نشاط جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم النشاط</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name"
                               placeholder="ادخل اسم النشاط">
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="manager_id">المدير</label>
                        <select class="form-control" wire:model="manager_id" id="manager_id">
                            <option value="">اختر</option>
                            @forelse($managers as $manager)
                                <option value="{{$manager->id}}">{{$manager->name}}</option>
                            @empty
                            @endforelse
                        </select>
                        <div class="text-danger">@error('manager_id') {{ $message }} @enderror</div>
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
    <!--job model -->

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
                    <h4>{{$name}}</h4>
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
        //     $('#create-job').modal('hide');
        // });
        // });
    </script>
    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
