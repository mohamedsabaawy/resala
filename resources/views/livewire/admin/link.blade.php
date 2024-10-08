@section('title','إدارة الروابط')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الروابط</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        @can('link create')
        <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()"
                data-target="#create-model">
            اضافة رابط
        </button>
        @endcan
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            @if(count($links)>0)
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الرابط</th>
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($links as $link)
                <tr>
                    <td>{{$link->id}}</td>
                    <td><a href="{{$link->link}}">{{$link->name}}</a></td>
                    <td>{{$link->link}}</td>
                    <td>
                        <div class="btn-group">
                            @can('link delete')
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-model"
                                    wire:click="show({{$link->id}})">مسح
                            </button>
                            @endcan
                            @can('link edit')
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                    data-target="#create-model" wire:click="show({{$link->id}})">تعديل
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
        {{$links->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create link model -->
{{--    wire:ignore.self--}}
<!-- start link model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل رابط" :"انشاء رابط جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم الرابط</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name"
                               placeholder="ادخل اسم الرابط">
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان الرابط</label>
                        <input type="text" min="0" class="form-control @error('link') is-invalid @enderror"
                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="link"
                               placeholder="ادخل عنوان الرابط">
                        <div class="text-danger">@error('link') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">الانشطة</label>
                        <select multiple class="form-control @error('jobs') is-invalid @enderror" wire:model="jobs">
                            <option>اختر</option>
                            @foreach($allJobs as $k =>$v)
                                <option value="{{$k}}">{{$v}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">@error('jobs') {{ $message }} @enderror</div>
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
    <!--link model -->

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
        //     $('#create-link').modal('hide');
        // });
        // });
    </script>
    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
