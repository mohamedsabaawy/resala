<x-appAdminlte-layout>

    <div class="card">
        <div class="card-header d-flex">
            <h3 class="card-title text-blue text-bold">الصفحة الشخصية</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">

                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        الاسم
                    </label>
                    <div class="text-red text-bold">{{$user->name}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        الكود
                    </label>
                    <div class="text-red text-bold">{{$user->code}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        الفرع
                    </label>
                    <div class="text-red text-bold">{{$user->branch->name ?? ''}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        اللجنة
                    </label>
                    <div class="text-red text-bold">{{$user->team->name ?? ''}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        النشاط
                    </label>
                    <div class="text-red text-bold">{{$user->job->name ?? ''}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        الصفة
                    </label>
                    <div class="text-red text-bold">{{$user->position->name ?? ''}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        رقم الهاتف
                    </label>
                    <div class="text-red text-bold">{{$user->phone}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        الرقم القومي
                    </label>
                    <div class="text-red text-bold">{{$user->national_id}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        العنوان
                    </label>
                    <div class="text-red text-bold">{{$user->address}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        البريد الالكتروني
                    </label>
                    <div class="text-red text-bold">{{$user->email}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        تاريخ الانضمام
                    </label>
                    {{--                    <div class="text-red text-bold">{{date_diff(date_format(today(),'Y-m-d') , $user->join_date)}}</div>--}}
                    {{--                    <div class="text-red text-bold">{{ strtotime(date_format(today(),'Y-m-d')) - strtotime($user->join_date) }}</div>--}}
                    <div class="text-red text-bold">{{ $user->join_date }}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        تاريخ الميلاد
                    </label>
                    <div class="text-red text-bold">{{$user->birth_date}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        الحالة الاجنماعية
                    </label>
                    <div class="text-red text-bold">{{$user->maritalStatus->name ?? ''}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        المؤهل
                    </label>
                    <div class="text-red text-bold">{{$user->qualification->name ?? ''}}</div>
                </div>
                <div class="col-12 col-sm-6 col-lg-4 border">
                    <label for="" class="text-blue fa fa-user">
                        الجنسية
                    </label>
                    <div class="text-red text-bold">{{$user->nationality->name ?? ''}}</div>
                </div>

            </div>
        </div>
        <!-- /.card-body -->


    </div>

{{--    <div class="login-box">--}}
        <div class="card">
            <div class="card-header d-flex">
                <h3 class="card-title text-blue text-bold">تعديل كلمة المرور</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                @if(session('status'))
                    <div class="alert alert-success">{{session('status')}}</div>
                @endif

                <form method="post" action="{{ route('password.update') }}" class="">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label class="">كلمة المرور القديمة</label>
                        <input class="form-control" type="password" name="current_password">
                        <div class="text-danger">@error('current_password') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label class="">كلمة المرور الجديدة</label>
                        <input class="form-control" type="password" name="password">
                        <div class="text-danger">@error('password') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label class="">تاكيد كلمة المرور الجديدة</label>
                        <input class="form-control" type="password" name="password_confirmation">
                    </div>
                    <button type="submit" class="form-control btn btn-primary">حفظ</button>
                </form>

            </div>
            <!-- /.card-body -->


        </div>
{{--    </div>--}}

</x-appAdminlte-layout>
