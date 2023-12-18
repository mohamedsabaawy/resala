@section('title','إدارة المشاركات')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الرئيسية</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()" data-target="#create-model">
            اضافة مشاركة
        </button>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            @if(count($activities)>0)
                <tr>
                    <th>#</th>
                    <th>تاريخ المشاركة</th>
                    <th>نوع المشاركة</th>
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($activities as $activity)
                <tr>
                    <td>{{$activity->id}}</td>
                    <td>{{$activity->activity_date}}</td>
                    <td>{{$activity->type}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-model" wire:click="show({{$activity->id}})" >مسح</button>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#create-model" wire:click="show({{$activity->id}})">تعديل</button>
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
                        <label for="exampleInputEmail1">تاريخ المشاركة</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model.live="activity_date">
                        <div class="text-danger">@error('activity_date') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نوع المشاركة</label>
                        <select class="form-control" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="type" >
                            <option>اختر</option>
                            <option value="online">online</option>
                            <option value="offline">offline</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">تفاصيل</label>
                        <textarea class="form-control textarea @error('comment') is-invalid @enderror" wire:model="comment"></textarea>
                        <div class="text-danger">@error('comment') {{ $message }} @enderror</div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">الاحداث</label>
                        <select class="form-control" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="event_id" >
                            <option>اختر</option>
                            @foreach($events as $event)
                                <option value="{{$event->id}}">{{$event->name}}</option>
                            @endforeach
                        </select>
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
                    <h4>{{$activity_date}}</h4>
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
