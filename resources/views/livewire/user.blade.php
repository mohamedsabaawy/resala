@section('title','أدارة المتطوعين')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">المتطوعين</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()" data-target="#create-model">
            اضافة متطوع
        </button>
        <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="export()" >
            تصدير
        </button>
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            @if(count($users)>0)
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>الفرع</th>
                    <th>الفريق</th>
                    <th>صورة</th>
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->branch->name ?? ""}}</td>
                    <td>{{$user->team->name ?? ""}}</td>
                    <td>
                        <img src="{{asset($user->photo)}}" width="150px">
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-model" wire:click="show({{$user->id}})" >مسح</button>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#create-model" wire:click="show({{$user->id}})">تعديل</button>
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
        {{$users->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create user model -->
{{--    wire:ignore.self--}}
<!-- start user model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex" >
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل متطوع" :"انشاء متطوع جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">

                    <div class="form-group col-4">
                        <label for="exampleInputEmail1">اسم المتطوع</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name" placeholder="ادخل اسم المتطوع">
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-3">
                        <label for="exampleInputEmail1">رقم هاتف المتطوع</label>
                        <input type="text" min="0" class="form-control @error('phone') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="phone" placeholder="ادخل عدد افراد المتطوع">
                        <div class="text-danger">@error('phone') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-3">
                        <label for="exampleInputEmail1">رقم قومي</label>
                        <input type="text" class="form-control @error('card_id') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="card_id" placeholder="ادخل عدد افراد المتطوع">
                        <div class="text-danger">@error('card_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-2">
                        <label for="exampleInputEmail1">صورة</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror"  wire:model="{{$isUpdate ? "newPhoto" : "photo"}}" >
                        <div class="text-danger">@error('photo') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-2">
                        <label for="exampleInputEmail1">تاريخ الانضمام</label>
                        <input type="date" class="form-control @error('join_date') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="join_date" >
                        <div class="text-danger">@error('join_date') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-2">
                        <label for="exampleInputEmail1">الفرع</label>
                        <select class="form-control select2" style="width: 100%;" wire:model="branch_id">
                            <option>اختر فرع</option>
                            @forelse($branches as $branch)
                                <option value="{{$branch->id}}">{{$branch->name}}</option>
                            @empty
                                <option>لا يوجد فروع</option>
                            @endforelse
                        </select>
                        <div class="text-danger">@error('branch_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-3">
                        <label for="exampleInputEmail1">الفريق</label>
                        <select class="form-control select2" style="width: 100%;" wire:model="team_id">
                            <option>اختر فريق</option>
                            @forelse($teams as $team)
                                <option value="{{$team->id}}">{{$team->name}}</option>
                            @empty
                                <option>لا يوجد فرق</option>
                            @endforelse
                        </select>
                        <div class="text-danger">@error('team_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-3">
                        <label for="exampleInputEmail1">المستوي</label>
                        <select class="form-control select2" style="width: 100%;" wire:model="position_id">
                            <option>اختر مستوي</option>
                            @forelse($positions as $position)
                                <option value="{{$position->id}}">{{$position->name}}</option>
                            @empty
                                <option>لا يوجد مستويات</option>
                            @endforelse
                        </select>
                        <div class="text-danger">@error('position_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-2">
                        <label for="exampleInputEmail1">الحالة</label>
                        <select class="form-control select2" style="width: 100%;" wire:model="status">
                            <option>اختر حالة</option>
                            <option value="active">نشط</option>
                            <option value="hold">معلق</option>
                            <option value="out">خرج</option>
                        </select>
                        <div class="text-danger">@error('status') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group col-12">
                        <label for="exampleInputEmail1">تعليق</label>
                        <textarea class="form-control @error('join_date') is-invalid @enderror" wire:model="comment"></textarea>
                        <div class="text-danger">@error('comment') {{ $message }} @enderror</div>
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
    <!--user model -->

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
        //     $('#create-user').modal('hide');
        // });
        // });
    </script>

    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
