@section('title','إدارة الاحداث')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الاحداث</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @can('event create')
        <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()"
                data-target="#create-model">
            اضافة حدث
        </button>
        @endcan
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            @if(count($events)>0)
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>التفاصيل</th>
                    <th>من</th>
                    <th>الي</th>
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($events as $event)
                <tr>
                    <td>{{$event->id}}</td>
                    <td>{{$event->name}}</td>
                    <td>{{$event->details}}</td>
                    <td>{{$event->from}}</td>
                    <td>{{$event->to}}</td>
                    <td>
                        <div class="btn-group">
                            @can('event delete')
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-model"
                                    wire:click="show({{$event->id}})">مسح
                            </button>
                            @endcan
                            @can('event edit')
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#create-model" wire:click="show({{$event->id}})">تعديل
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
        {{$events->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create event model -->
{{--    wire:ignore.self--}}
<!-- start event model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل حدث" :"انشاء حدث جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم الحدث</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name"
                               placeholder="ادخل اسم الحدث">
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">تفاصيل الحدث</label>
                        <textarea class="form-control textarea @error('details') is-invalid @enderror"
                                  wire:model="details"></textarea>
                        <div class="text-danger">@error('details') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <div class="icheck-primary">
                            <label for="checkboxPrimary1" class="">
                                حدث عام
                            </label>
                            {{--                            {{$type}}--}}
                            <input type="checkbox" id="checkboxPrimary1" wire:model.live="type">
                        </div>
                    </div>
                    @if($type==0)
                        <div class="form-group">
                            <label for="exampleInputEmail1">من</label>
                            <input type="date" class="form-control @error('from') is-invalid @enderror"
                                   wire:model="from">
                            <div class="text-danger">@error('from') {{ $message }} @enderror</div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">الي</label>
                            <input type="date" class="form-control @error('to') is-invalid @enderror" wire:model="to">
                            <div class="text-danger">@error('to') {{ $message }} @enderror</div>
                        </div>
                    @endif
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
    <!--event model -->

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


        // $(function () {
        //     // Summernote
        //     $('.textarea').summernote()
        // })

        // document.addEventListener('livewire:initialized', () => {
        // @this.on('close-createBranch', (event) => {
        //     $('#create-event').modal('hide');
        // });
        // });
    </script>
    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
