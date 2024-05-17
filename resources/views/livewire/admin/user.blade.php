@section('title','إدارة المتطوعين')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">المتطوعين</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body row">
        <div class="col-12 col-sm-6 ">
            <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()"
                    data-target="#create-model">
                اضافة متطوع
            </button>
        </div>
        <div class="col-12 col-sm-6  form-inline">
            @can('user export')
                <div class="row border">
                    <div class="form-group col">
                        <label class="col-form-label">من</label>
                        <input class="form-control" dir="rtl" type="date" wire:model="filter_from">
                    </div>
                    <div class="form-group col">
                        <label class="form-text">الي</label>
                        <input class="form-control" dir="rtl" type="date" wire:model="filter_to">
                    </div>
                    <button type="button" class="form-control btn btn-info col-12" data-toggle="modal"
                            wire:click="export()">
                        تصدير
                    </button>
                </div>
            @endcan

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
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive text-nowrap text-center">
            <table id="example1" class="table table-bordered table-striped ">
                <thead>
                @if(count($users)>0)
                    <tr>
                        <th>كود</th>
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
                        <td>{{$user->code}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->branch->name ?? ""}}</td>
                        <td>{{$user->team->name ?? ""}}</td>
                        <td>
                            <img src="{{asset($user->photo)}}" width="150px">
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#delete-model"
                                        wire:click="show({{$user->id}})">مسح
                                </button>
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#create-model" wire:click="show({{$user->id}})">تعديل
                                </button>
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
        </div>
    </div>
    <div class="">
        {{$users->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create user model -->
{{--    wire:ignore.self--}}
<!-- start user model -->
    <div wire:ignore.self class="modal fade" id="create-model">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل متطوع" :"انشاء متطوع جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">

                    <div class="col-12 col-lg-10">
                        <div class="row">
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">الرقم</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="code"
                                       placeholder="كود">
                                <div class="text-danger">@error('code') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
                                <label for="exampleInputEmail1">اسم المتطوع</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name"
                                       placeholder="ادخل اسم المتطوع">
                                <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="exampleInputEmail1">رقم هاتف المتطوع</label>
                                <input type="text" min="0" class="form-control @error('phone') is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="phone"
                                       placeholder="ادخل رقم الهاتف">
                                <div class="text-danger">@error('phone') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="exampleInputEmail1">رقم قومي</label>
                                <input type="text" class="form-control @error('national_id') is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                                       wire:model="national_id" placeholder="ادخل الرقم القومي">
                                <div class="text-danger">@error('national_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">كلمة السر</label>
                                <input type="password"
                                       class="form-control @error($isUpdate ? "newPassword" : "password") is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                                       wire:model="{{$isUpdate ? "newPassword" : "password"}}">
                                <div
                                    class="text-danger">@error($isUpdate ? "newPassword" : "password") {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">تاريخ الانضمام</label>
                                <input type="date" class="form-control @error('join_date') is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                                       wire:model="join_date">
                                <div class="text-danger">@error('join_date') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">تاريخ الميلاد</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}"
                                       wire:model="birth_date">
                                <div class="text-danger">@error('birth_date') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="exampleInputEmail1">العنوان</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="address"
                                       placeholder="عنوان المتطوع">
                                <div class="text-danger">@error('address') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-3">
                                <label for="exampleInputEmail1">الفرع</label>
                                <select class="form-control select2  @error('branch_id') is-invalid @enderror"
                                        wire:model="branch_id">
                                    <option>اختر فرع</option>
                                    @forelse($branches as $branch)
                                        <option value="{{$branch->id}}">{{$branch->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('branch_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">النشاط</label>
                                <select class="form-control select2  @error('job_id') is-invalid @enderror"
                                        wire:model="job_id">
                                    <option value="">اختر نشاط</option>
                                    @forelse($jobs as $job)
                                        <option value="{{$job->id}}">{{$job->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('job_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">اللجنة</label>
                                <select class="form-control select2  @error('team_id') is-invalid @enderror"
                                        wire:model="team_id">
                                    <option value="">اختر لجنة</option>
                                    @forelse($teams as $team)
                                        <option value="{{$team->id}}">{{$team->name}}</option>
                                    @empty
                                        <option>لا يوجد لجان</option>
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('team_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">الصفة</label>
                                <select class="form-control select2  @error('position_id') is-invalid @enderror"
                                        wire:model="position_id">
                                    <option value="">اختر صفة</option>
                                    @forelse($positions as $position)
                                        <option value="{{$position->id}}">{{$position->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('position_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">الحالة</label>
                                <select class="form-control select2  @error('status_id') is-invalid @enderror"
                                        wire:model="status_id">
                                    <option value="">اختر حالة</option>
                                    @forelse($statuses as $status)
                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('status_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">درجة التطوع</label>
                                <select class="form-control select2  @error('degree_id') is-invalid @enderror"
                                        wire:model="degree_id">
                                    <option value="">اختر</option>
                                    @forelse($degrees as $degree)
                                        <option value="{{$degree->id}}">{{$degree->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('degree_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">التصنيف</label>
                                <select class="form-control select2  @error('category_id') is-invalid @enderror"
                                        wire:model="category_id">
                                    <option value="">اختر</option>
                                    @forelse($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('category_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">الجنسية</label>
                                <select class="form-control select2  @error('nationality_id') is-invalid @enderror"
                                        wire:model="nationality_id">
                                    <option value="">اختر</option>
                                    @forelse($nationalities as $nationality)
                                        <option value="{{$nationality->id}}">{{$nationality->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('nationality_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">المؤهل</label>
                                <select class="form-control select2  @error('qualification_id') is-invalid @enderror"
                                        wire:model="qualification_id">
                                    <option value="">اختر</option>
                                    @forelse($qualifications as $qualification)
                                        <option value="{{$qualification->id}}">{{$qualification->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('qualification_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">الحالة الاجتماعية</label>
                                <select class="form-control select2  @error('marital_status_id') is-invalid @enderror"
                                        wire:model="marital_status_id">
                                    <option value="">اختر</option>
                                    @forelse($maritalStatuses as $marital_status)
                                        <option value="{{$marital_status->id}}">{{$marital_status->name}}</option>
                                    @empty
                                    @endforelse
                                </select>
                                <div class="text-danger">@error('marital_status_id') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">
                                <label for="exampleInputEmail1">النوع</label>
                                <select class="form-control select2  @error('gender') is-invalid @enderror"
                                        wire:model="gender">
                                    <option value="">اختر</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                </select>
                                <div class="text-danger">@error('gender') {{ $message }} @enderror</div>
                            </div>
                            {{--                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-2">--}}
                            {{--                                <label for="exampleInputEmail1">نوع المستخدم</label>--}}
                            {{--                                <select class="form-control select2  @error('role') is-invalid @enderror"--}}
                            {{--                                        wire:model="role">--}}
                            {{--                                    <option value="">اختر</option>--}}
                            {{--                                    --}}{{--                                    <option value="admin">superAdmin</option>--}}
                            {{--                                    <option value="admin">admin</option>--}}
                            {{--                                    <option value="supervisor">supervisor</option>--}}
                            {{--                                    <option value="user">user</option>--}}
                            {{--                                </select>--}}
                            {{--                                <div class="text-danger">@error('qualification_id') {{ $message }} @enderror</div>--}}
                            {{--                            </div>--}}
                            <div class="form-group col-12 col-sm-6 col-md-4 col-lg-4">
                                <label for="exampleInputEmail1">البريد الالكتروني</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                       wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="email"
                                       placeholder="البريد الالكتروني">
                                <div class="text-danger">@error('email') {{ $message }} @enderror</div>
                            </div>
                            <div class="form-group col-12">
                                <label for="exampleInputEmail1">تعليق</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror"
                                          wire:model="comment"></textarea>
                                <div class="text-danger">@error('comment') {{ $message }} @enderror</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
                        <div class="row">
                            <div class="col-12">
                                @if ($photo and $isUpdate==false)
                                    <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail">
                                @elseif($isUpdate)
                                    @if($photo)
                                        <img src="{{asset($photo) }}" class="img-thumbnail">
                                    @endif
                                    @if($newPhoto)
                                        <label>الصورة الجديدة</label>
                                        <img src="{{ $newPhoto->temporaryUrl() }}" class="img-thumbnail">
                                    @endif
                                @endif
                            </div>
                            <div class="form-group col-12">
                                <label for="exampleInputEmail1">صورة</label>
                                <input type="file"
                                       class="form-control @error($isUpdate ? 'newPhoto' : 'photo') is-invalid @enderror"
                                       wire:model="{{$isUpdate ? "newPhoto" : "photo"}}">
                                <div
                                    class="text-danger">@error($isUpdate ? 'newPhoto' : 'photo') {{ $message }} @enderror</div>
                            </div>
                        </div>
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
    <!--user model -->

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
        //     $('#create-user').modal('hide');
        // });
        // });
    </script>

    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
