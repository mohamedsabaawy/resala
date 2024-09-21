@section('title','إدارة المشاركات')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">الرئيسية</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            @if(strlen($msg)>0)
                <div class="col-12 alert alert-danger">
                    <h5>يوجد بالفعل مشاركة في هذا اليوم لكل من :</h5>
                    <h6>
                        {{$msg}}
                    </h6>
                </div>
            @endif
            <div class="col col-lg-6 btn-group" role="group">
                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#create-model" wire:click="resetInput">
                    اضافة مشاركة
                </button>
                <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                        data-target="#create-model" wire:click="createApologize">
                    اضافة عذر
                </button>
            </div>
            <div class="col-12 accordion">
                <div class="card">
                    <div class="card-header">
                        <h5 class="text-blue">
                            <button class="btn btn-link collapsed text-lg w-100" data-toggle="collapse"
                                    data-target="#filter" aria-expanded="true" aria-controls="filter">
                                بحث وتصفية
                            </button>
                        </h5>
                    </div>
                    <div class="collapse show" id="filter" aria-labelledby="filter">
                        <div class="card-body row">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                <div class="form-group">
                                    <label class="text-red">كود</label>
                                    <input class="form-control text-primary" dir="rtl" type="text"
                                           wire:model.live="searchCode" placeholder="كود">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                <div class="form-group">
                                    <label class="text-red">الاسم</label>
                                    <input class="form-control text-primary" dir="rtl" type="text"
                                           wire:model.live="searchName" placeholder="اسم">
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                <div class="form-group">
                                    <label class="text-red">نشاط</label>
                                    <select class="form-control text-primary" wire:model.live="job">
                                        <option></option>
                                        @foreach($jobs as $job)
                                            <option value="{{$job->id}}">{{$job->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-2">
                                <div class="form-group">
                                    <label class="text-red">من</label>
                                    <input class="form-control text-primary" dir="rtl" type="date"
                                           wire:model.live="filter_from">
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-2">
                                <div class="form-group">
                                    <label class="text-red">الي</label>
                                    <input class="form-control text-primary" dir="rtl" type="date"
                                           wire:model.live="filter_to">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive text-nowrap text-center">
            <table id="example1" class="table table-bordered table-hover">
                <thead class="thead-light">
                @php
                    $start =  $filter_from;
                    $end =$filter_to;
                    if (!function_exists('getActivity'))
                    {
                        function getActivity($i,$user){
                        if (count($user->activities->where('activity_date',$i))>0){
                            return optional($user->activities)->where('activity_date',$i)->first()->comment;
                        }
                    }
                    }
                    if(!function_exists('getActivityEvent'))
                    {
                        function getActivityEvent($i,$user){
                        if (count($user->activities->where('activity_date',$i))>0){
                            if (!$user->activities->where('activity_date',$i)->first()->apologize)
                                return optional($user->activities->where('activity_date',$i)->first()->event)->name ?? "تم مسح الحدث";
                            return "عذر عن : " .(optional($user->activities->where('activity_date',$i)->first()->event)->name  ?? "تم مسح الحدث" );
                        }
                    }
                    }
                @endphp
                {{session('role')}}
                {{--            @if(count($activities)>0)--}}
                <tr>
                    <th>كود</th>
                    <th>الاسم</th>
                    <th>تليفون</th>
                    @for($i =$start ; $i<=$end; $i = \Carbon\Carbon::parse($i)->addDay()->format('Y-m-d'))
                        <th colspan="2">{{$i}}</th>
                    @endfor
                </tr>
                {{--            @endif--}}
                </thead>
                <tbody>
                @forelse($allUsers as $user)
                    <tr>
                        <td class="" scope="row">{{$user->code}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->phone}}</td>
                        @for($i =$start ; $i<=$end; $i = \Carbon\Carbon::parse($i)->addDay()->format('Y-m-d'))
                            <td class="{{str_contains(getActivityEvent($i,$user),'عذر')?'bg-yellow': ''}}">{{getActivityEvent($i,$user)}}</td>
                            <td class="{{str_contains(getActivityEvent($i,$user),'عذر')?'bg-yellow': ''}}">{{getActivity($i,$user)}}</td>
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
        {{$allUsers->links()}}
    </div>

    <!-- /.card-body -->

    <!-- start create activity model -->
    {{--    wire:ignore.self--}}
    <!-- start activity model   wire:ignore.self -->
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
                        <select wire:ignore class="form-control select2" id="userId" multiple
                                wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                                wire:model="userId">
                            {{--                            <option>اختر</option>--}}
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
{{--                                wire:keydown.outside="check()"--}}
                                wire:model.live="event_id" id="event_id">
                            <option>اختر</option>
                            @foreach($events as $event)
                                <option value="{{$event->id}}">{{$event->name}}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">@error('event_id') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label>تاريخ المشاركة</label>
                        <input type="date" min="{{$event_from}}" max="{{$event_to}}"
                               class="form-control @error('date') is-invalid @enderror"
                               wire:click="check"
                               wire:model.live="activity_date" placeholder="dd-mm-yyyy">
                        <div class="text-danger">@error('activity_date') {{ $message }} @enderror</div>
                    </div>
                    {{--                    @if(!$isApologize)--}}
                    {{--                        <div class="form-group">--}}
                    {{--                            <label for="exampleInputEmail1">نوع المشاركة</label>--}}
                    {{--                            <select class="form-control @error('type') is-invalid @enderror" wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"--}}
                    {{--                                    wire:model="type">--}}
                    {{--                                <option>اختر</option>--}}
                    {{--                                <option value="online">online</option>--}}
                    {{--                                <option value="offline">offline</option>--}}
                    {{--                            </select>--}}
                    {{--                            <div class="text-danger">@error('type') {{ $message }} @enderror</div>--}}
                    {{--                        </div>--}}
                    {{--                    @endif--}}
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
