@section('title','إدارة الموافقات')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الموافقات</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row form-inline">
            <div class="form-group col-3">
                <label for="dateFrom" class="form-inline">من </label>
                <input type="date" id="dateFrom" value="0" class="form-control" wire:model="dateFrom">
            </div>
            <div class="form-group col-3">
                <label for="dateTo" class="form-inline">الي </label>
                <input type="date" id="dateTo" value="0" class="form-control" wire:model="dateTo">
            </div>
            <div class="form-group col-2">
                <input type="checkbox" id="pending" value="0" class="" wire:model="filter">
                <label for="pending">معلق</label>
            </div>
            <div class="form-group col-2">
                <input type="checkbox" id="approve" value="1" class="" wire:model="filter">
                <label for="approve">موافقة</label>
            </div>
            <div class="form-group col-2">
                <input type="checkbox" id="refused" value="2" class="" wire:model="filter">
                <label for="refused">رفض</label>
            </div>
            <div class="form-group col-3">
                <button class="btn btn-info" wire:click="startFilter" >بحث</button>
            </div>
        </div>
        <table id="example1" class="table table-bordered table-striped table-responsive-sm">
            <thead>
            @if(count($activities)>0)
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>التاريخ</th>
                    <th>الحدث</th>
                    <th>الملاحظات</th>
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($activities as $activity)
                <tr class="{{$activity->approval ==1 ? 'bg-green':($activity->approval==2 ? 'bg-yellow': '')}}">
                    <td>{{$loop->index+1}}</td>
                    <td>{{$activity->user->name}}</td>
                    <td>{{$activity->activity_date}}</td>
                    <td>{{optional($activity->event)->name}}</td>
                    <td>{{$activity->comment}}</td>
                    <td>
                        <div class="btn-group">
                            @if($activity->approval ==0 or auth()->user()->role == 'admin')
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-model" wire:click="show({{$activity->id}})" >مسح</button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="" wire:click="approve({{$activity->id}})">تأكيد</button>
                            @endif
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
        {{$activities->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create activity model -->
{{--    wire:ignore.self--}}
<!-- start activity model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex" >
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل مشاركة" :"انشاء مشاركة جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المشاركة</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name" placeholder="ادخل اسم المشاركة">
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">عدد المشاركة</label>
                        <input type="number" min="0" class="form-control @error('count') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="count" placeholder="ادخل عدد افراد المشاركة">
                        <div class="text-danger">@error('count') {{ $message }} @enderror</div>
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
    <!--activity model -->

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
        //     $('#create-activity').modal('hide');
        // });
        // });
    </script>
    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
