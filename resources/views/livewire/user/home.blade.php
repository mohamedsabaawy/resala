@section('title','إدارة المشاركات')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الرئيسية</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col col-6">
                <button type="button" class="btn btn-outline-info" data-toggle="modal"
                        data-target="#create-model" wire:click="resetInput">
                    اضافة مشاركة
                </button>
                <button type="button" class="btn btn-outline-info" data-toggle="modal"
                        data-target="#create-model" wire:click="createApologize">
                    اضافة عذر
                </button>
            </div>
            <div class="col col-3">
            </div>
            <div class="col col-3">
                <div class="row">
                    <div class="col-1">
                        <label class="col-form-label">من</label>
                    </div>
                    <div class="col-10">
                        <input class="form-control" dir="rtl" type="date" wire:model.live="filter_from" >
                    </div>
                </div>
                <div class="row">
                    <div class="col-1">
                        <label class="col-form-label">الي</label>
                    </div>
                    <div class="col-10">
                        <input class="form-control" dir="rtl" type="date" wire:model.live="filter_to" >
                    </div>
                </div>
            </div>
        </div>
        <table id="example1" class="table table-bordered table-responsive">
            <thead>
            @php
                $start = date_format(today(),"Y-m-01");
                $end = date_format(today(),"y-m-t");
                function getActivity($i,$user){
                    if (count($user->activities->where('activity_date',"$i"))>0){
                        if (!$user->activities->where('activity_date',"$i")->first()->apologize)
                            return $user->activities->where('activity_date',"$i")->first()->type;
                        return "عذر";
                    }
                }
                function getActivityEvent($i,$user){
                    if (count($user->activities->where('activity_date',"$i"))>0){
                        if (!$user->activities->where('activity_date',"$i")->first()->apologize)
                            return $user->activities->where('activity_date',"$i")->first()->event->name;
                        return "عذر";
                    }
                }
            @endphp
            {{session('role')}}
            {{--            @if(count($activities)>0)--}}
            <tr>
                <th>#</th>
                <th>الاسم</th>
                @for($i =$filter_from ; $i<=$filter_to; $i++)
                    <th colspan="2">{{$i}}</th>
                @endfor
            </tr>
            {{--            @endif--}}
            </thead>
            <tbody>
            @forelse($allUsers as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    @for($i =$filter_from ; $i<=$filter_to; $i++)
                        <td>{{getActivity($i,$user)}}</td>
                        <td>{{getActivityEvent($i,$user)}}</td>
                    @endfor
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
    </div>
    <!-- /.card-body -->

    <!-- start create activity model -->
{{--    wire:ignore.self--}}
<!-- start activity model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل مشاركة" :"انشاء مشاركة جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{--                    <div class="form-check">--}}
                    {{--                        <input type="checkbox" wire:model.live="isApologize" class="form-check-input" id="apologize">--}}
                    {{--                        <label for="apologize" class="form-check-label">عذر</label>--}}
                    {{--                    </div>--}}
                    <div class="form-group">
                        <label for="userId">متطوع</label>
                        <select class="form-control select2" id="userId"
                                wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                                wire:model="userId">
                            <option>اختر</option>
                            @foreach($users as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">@error('userId') {{ $message }} @enderror</div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">الاحداث</label>
                        <select class="form-control select2-blue"
{{--                                {{$isUpdate ? "update()" : "save()"}}  --}}
                                wire:keydown.outside="check()"
                                wire:model.live="event_id" id="event_id">
                            <option>اختر</option>
                            @foreach($events as $event)
                                <option value="{{$event->id}}">{{$event->name}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">@error('event_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">تاريخ المشاركة</label>
                        <input type="date" min="{{$event_from}}" max="{{$event_to}}" class="form-control @error('date') is-invalid @enderror"
                               wire:click="check"
                               wire:model.live="activity_date" placeholder="dd-mm-yyyy">
                        <div class="text-danger">@error('activity_date') {{ $message }} @enderror</div>
                    </div>
                    @if(!$isApologize)
                        <div class="form-group">
                            <label for="exampleInputEmail1">نوع المشاركة</label>
                            <select class="form-control" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                                    wire:model="type">
                                <option>اختر</option>
                                <option value="online">online</option>
                                <option value="offline">offline</option>
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="exampleInputEmail1">تفاصيل</label>
                        <textarea class="form-control textarea @error('comment') is-invalid @enderror"
                                  wire:model="comment"></textarea>
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
    <!--activity model -->
    <!-- start activity model -->
    <div wire:ignore.self class="modal fade" id="create-apologize-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل عزر" :"انشاء عذر جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عذر</label>
                        <input type="checkbox">
                    </div>
                    @if(auth()->user()->position->role !="user")
                        <div class="form-group">
                            <label for="exampleInputEmail1">متطوع</label>
                            <select class="form-control select2"
                                    wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                                    wire:model="userId">
                                <option>اختر</option>
                                @foreach($users as $key=>$value)
                                    <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="exampleInputEmail1">تاريخ العذر</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror"
                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                               wire:model.live="activity_date">
                        <div class="text-danger">@error('activity_date') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">تفاصيل</label>
                        <textarea class="form-control textarea @error('comment') is-invalid @enderror"
                                  wire:model="comment"></textarea>
                        <div class="text-danger">@error('comment') {{ $message }} @enderror</div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">الاحداث</label>
                        <select class="form-control select2-blue"
                                wire:keydown.enter="{{$isUpdate ? "updateApologize()" : "saveApologize()"}}"
                                wire:model="event_id" id="event_id">
                            <option>اختر</option>
                            @foreach($events as $event)
                                <option value="{{$event->id}}">{{$event->name}}</option>
                            @endforeach
                        </select>
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
    <!--activity model -->

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
                    <h4>{{$activity_date}}</h4>
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
        //     $('#create-activity').modal('hide');
        // });
        // });
    </script>

    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush

