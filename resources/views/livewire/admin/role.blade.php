@section('title','إدارة مجموعة المستخدمين')
<div class="card">
    <div class="card-header d-flex">
        <h3 class="card-title ">مجموعة المستخدمين</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                @can('role create')
                    <button type="button" class="btn btn-outline-info" data-toggle="modal" wire:click="resetInput()"
                            data-target="#create-model">
                        اضافة مجموعة مستخدمين
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
            @if(count($roles)>0)
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>اجراء</th>
                </tr>
            @endif
            </thead>
            <tbody>
            @forelse($roles as $role)
                <tr class="{{$role->deleted_at ? 'bg-gradient-gray':''}}">
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        <div class="btn-group">
                            @can('role delete')
                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#delete-model"
                                        wire:click="show({{$role->id}})"><i class="fa fa-trash"></i>مسح
                                </button>
                            @endcan
                            @can('role edit')
                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#create-model" wire:click="show({{$role->id}})"><i
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
        {{$roles->links()}}
    </div>
    <!-- /.card-body -->

    <!-- start create role model -->
{{--    wire:ignore.self--}}
<!-- start role model -->
    <div wire:ignore.self class="modal fade " id="create-model">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="overlay d-none justify-content-center align-items-center hide" wire:loading.class="d-flex">
                    <i class="fas fa-2x fa-sync fa-spin"></i>
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">{{$isUpdate ? "تعديل مجموعة مستخدمين" :"انشاء مجموعة مستخدمين جديد"}}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المجموعة مستخدمين</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               wire:keydown.enter="{{$isUpdate ? "update()" : "save()"}}" wire:model="name"
                               placeholder="ادخل اسم المجموعة مستخدمين">
                        <div class="text-danger">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <div>
                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-below-main-tab" data-toggle="pill"
                                   href="#custom-content-below-main" role="tab"
                                   aria-controls="custom-content-below-main" aria-selected="true">الهيكل</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-user-tab" data-toggle="pill"
                                   href="#custom-content-below-user" role="tab"
                                   aria-controls="custom-content-below-user" aria-selected="false">المتطوعين</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-below-approval-tab" data-toggle="pill"
                                   href="#custom-content-below-approval" role="tab"
                                   aria-controls="custom-content-below-approval" aria-selected="false">الموافقة</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent">
                            <div class="tab-pane fade active show" id="custom-content-below-main" role="tabpanel"
                                 aria-labelledby="custom-content-below-main-tab">
                                {{--                                --}}
                                <div class="row">

                                    <div class="col-12 col-sm-12 text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="main-menu-show"
                                                   value="main menu show" wire:model="permission">
                                            <label for="main-menu-show" class="custom-control-label">عرض ادارة الهيكل</label>
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-6">
                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                             aria-orientation="vertical">
                                            <a class="nav-link active" id="vert-tabs-branch-tab" data-toggle="pill"
                                               href="#vert-tabs-branch" role="tab" aria-controls="vert-tabs-branch"
                                               aria-selected="false">الفرع</a>
                                            <a class="nav-link" id="vert-tabs-job-tab" data-toggle="pill"
                                               href="#vert-tabs-job" role="tab" aria-controls="vert-tabs-job"
                                               aria-selected="false">الانشطة</a>
                                            <a class="nav-link" id="vert-tabs-team-tab" data-toggle="pill"
                                               href="#vert-tabs-team" role="tab" aria-controls="vert-tabs-team"
                                               aria-selected="false">اللجان</a>
                                            <a class="nav-link" id="vert-tabs-position-tab" data-toggle="pill"
                                               href="#vert-tabs-position" role="tab" aria-controls="vert-tabs-position"
                                               aria-selected="false">الصفات</a>
                                            <a class="nav-link" id="vert-tabs-event-tab" data-toggle="pill"
                                               href="#vert-tabs-event" role="tab" aria-controls="vert-tabs-event"
                                               aria-selected="true">الاحداث</a>
                                            <a class="nav-link" id="vert-tabs-link-tab" data-toggle="pill"
                                               href="#vert-tabs-link" role="tab" aria-controls="vert-tabs-link"
                                               aria-selected="true">الروابط</a>
                                            <a class="nav-link" id="vert-tabs-role-tab" data-toggle="pill"
                                               href="#vert-tabs-role" role="tab" aria-controls="vert-tabs-role"
                                               aria-selected="true">صلاحيات</a>
                                            <a class="nav-link" id="vert-tabs-meeting-tab" data-toggle="pill"
                                               href="#vert-tabs-meeting" role="tab" aria-controls="vert-tabs-meeting"
                                               aria-selected="true">الاجتماعات</a>
                                        </div>
                                    </div>
                                    <div class="col-5 col-sm-6">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                            <div class="tab-pane fade active show" id="vert-tabs-branch" role="tabpanel"
                                                 aria-labelledby="vert-tabs-branch-tab">
                                                <h5>الفروع</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="branch-create"
                                                           value="branch create" wire:model="permission">
                                                    <label for="branch-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="branch-show"
                                                           value="branch show" wire:model="permission">
                                                    <label for="branch-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="branch-edit"
                                                           value="branch edit" wire:model="permission">
                                                    <label for="branch-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="branch-delete"
                                                           value="branch delete" wire:model="permission">
                                                    <label for="branch-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-job" role="tabpanel"
                                                 aria-labelledby="vert-tabs-job-tab">
                                                <h5 class="underline">الانشطة</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="job-create"
                                                           value="job create" wire:model="permission">
                                                    <label for="job-create" class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="job-show"
                                                           value="job show" wire:model="permission">
                                                    <label for="job-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="job-edit"
                                                           value="job edit" wire:model="permission">
                                                    <label for="job-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="job-delete"
                                                           value="job delete" wire:model="permission">
                                                    <label for="job-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-team" role="tabpanel"
                                                 aria-labelledby="vert-tabs-team-tab">
                                                <h5 class="underline">اللجان</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="team-create"
                                                           value="team create" wire:model="permission">
                                                    <label for="team-create" class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="team-show"
                                                           value="team show" wire:model="permission">
                                                    <label for="team-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="team-edit"
                                                           value="team edit" wire:model="permission">
                                                    <label for="team-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="team-delete"
                                                           value="team delete" wire:model="permission">
                                                    <label for="team-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-position" role="tabpanel"
                                                 aria-labelledby="vert-tabs-position-tab">
                                                <h5 class="underline">الصفات</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="position-create"
                                                           value="position create" wire:model="permission">
                                                    <label for="position-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="position-show"
                                                           value="position show" wire:model="permission">
                                                    <label for="position-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="position-edit"
                                                           value="position edit" wire:model="permission">
                                                    <label for="position-edit"
                                                           class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="position-delete"
                                                           value="position delete" wire:model="permission">
                                                    <label for="position-delete"
                                                           class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-event" role="tabpanel"
                                                 aria-labelledby="vert-tabs-event-tab">
                                                <h5>الاحداث</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="event-create"
                                                           value="event create" wire:model="permission">
                                                    <label for="event-create" class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="event-show"
                                                           value="event show" wire:model="permission">
                                                    <label for="event-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="event-edit"
                                                           value="event edit" wire:model="permission">
                                                    <label for="event-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="event-delete"
                                                           value="event delete" wire:model="permission">
                                                    <label for="event-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-link" role="tabpanel"
                                                 aria-labelledby="vert-tabs-link-tab">
                                                <h5>الروابط</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="link-create"
                                                           value="link create" wire:model="permission">
                                                    <label for="link-create" class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="link-show"
                                                           value="link show" wire:model="permission">
                                                    <label for="link-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="link-edit"
                                                           value="link edit" wire:model="permission">
                                                    <label for="link-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="link-delete"
                                                           value="link delete" wire:model="permission">
                                                    <label for="link-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-role" role="tabpanel"
                                                 aria-labelledby="vert-tabs-role-tab">
                                                <h5>الصلاحيات</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="role-menu-show"
                                                           value="role menu show" wire:model="permission">
                                                    <label for="role-menu-show" class="custom-control-label">عرض ادارة الصلاحيات</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="role-create"
                                                           value="role create" wire:model="permission">
                                                    <label for="role-create" class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="role-show"
                                                           value="role show" wire:model="permission">
                                                    <label for="role-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="role-edit"
                                                           value="role edit" wire:model="permission">
                                                    <label for="role-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="role-delete"
                                                           value="role delete" wire:model="permission">
                                                    <label for="role-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-meeting" role="tabpanel"
                                                 aria-labelledby="vert-tabs-meeting-tab">
                                                <h5>الاجتماعات</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="meeting-create"
                                                           value="meeting create" wire:model="permission">
                                                    <label for="meeting-create" class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="meeting-show"
                                                           value="meeting show" wire:model="permission">
                                                    <label for="meeting-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="meeting-edit"
                                                           value="meeting edit" wire:model="permission">
                                                    <label for="meeting-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="meeting-delete"
                                                           value="meeting delete" wire:model="permission">
                                                    <label for="meeting-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="custom-content-below-user" role="tabpanel"
                                 aria-labelledby="custom-content-below-user-tab">

                                <div class="row">

                                    <div class="col-12 col-sm-12 text-center">
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="user-menu-show"
                                                   value="user menu show" wire:model="permission">
                                            <label for="user-menu-show" class="custom-control-label">عرض قائمة ادارة المتطوعين</label>
                                        </div>
                                    </div>
                                    <div class="col-7 col-sm-6">
                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                             aria-orientation="vertical">
                                            <a class="nav-link active" id="vert-tabs-degree-tab" data-toggle="pill"
                                               href="#vert-tabs-degree" role="tab" aria-controls="vert-tabs-degree"
                                               aria-selected="false">درجات التطوع</a>
                                            <a class="nav-link" id="vert-tabs-status-tab" data-toggle="pill"
                                               href="#vert-tabs-status" role="tab" aria-controls="vert-tabs-status"
                                               aria-selected="false">حالة التطوع</a>
                                            <a class="nav-link" id="vert-tabs-maritalStatus-tab" data-toggle="pill"
                                               href="#vert-tabs-maritalStatus" role="tab"
                                               aria-controls="vert-tabs-maritalStatus"
                                               aria-selected="false">الحالة الاجتماعية</a>
                                            <a class="nav-link" id="vert-tabs-nationality-tab" data-toggle="pill"
                                               href="#vert-tabs-nationality" role="tab"
                                               aria-controls="vert-tabs-nationality"
                                               aria-selected="false">الجنسيات</a>
                                            <a class="nav-link" id="vert-tabs-qualification-tab" data-toggle="pill"
                                               href="#vert-tabs-qualification" role="tab"
                                               aria-controls="vert-tabs-qualification"
                                               aria-selected="false">الشهادات العلمية</a>
                                            <a class="nav-link" id="vert-tabs-category-tab" data-toggle="pill"
                                               href="#vert-tabs-category" role="tab" aria-controls="vert-tabs-category"
                                               aria-selected="false">التصنيفات</a>
                                            <a class="nav-link" id="vert-tabs-user-tab" data-toggle="pill"
                                               href="#vert-tabs-user" role="tab" aria-controls="vert-tabs-user"
                                               aria-selected="false">المتطوعين</a>
                                        </div>
                                    </div>
                                    <div class="col-5 col-sm-6">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                            <div class="tab-pane fade active show" id="vert-tabs-degree" role="tabpanel"
                                                 aria-labelledby="vert-tabs-degree-tab">
                                                <h5>درجات التطوع</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="degree-create"
                                                           value="degree create" wire:model="permission">
                                                    <label for="degree-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="degree-show"
                                                           value="degree show" wire:model="permission">
                                                    <label for="degree-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="degree-edit"
                                                           value="degree edit" wire:model="permission">
                                                    <label for="degree-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="degree-delete"
                                                           value="degree delete" wire:model="permission">
                                                    <label for="degree-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-status" role="tabpanel"
                                                 aria-labelledby="vert-tabs-status-tab">
                                                <h5 class="underline">التصنيفات</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="status-create"
                                                           value="status create" wire:model="permission">
                                                    <label for="status-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="status-show"
                                                           value="status show" wire:model="permission">
                                                    <label for="status-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="status-edit"
                                                           value="status edit" wire:model="permission">
                                                    <label for="status-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="status-delete"
                                                           value="status delete" wire:model="permission">
                                                    <label for="status-delete" class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-maritalStatus" role="tabpanel"
                                                 aria-labelledby="vert-tabs-maritalStatus-tab">
                                                <h5 class="underline">الحالة الاجتماعية</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="maritalStatus-create"
                                                           value="maritalStatus create" wire:model="permission">
                                                    <label for="maritalStatus-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="maritalStatus-show"
                                                           value="maritalStatus show" wire:model="permission">
                                                    <label for="maritalStatus-show"
                                                           class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="maritalStatus-edit"
                                                           value="maritalStatus edit" wire:model="permission">
                                                    <label for="maritalStatus-edit"
                                                           class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="maritalStatus-delete"
                                                           value="maritalStatus delete" wire:model="permission">
                                                    <label for="maritalStatus-delete"
                                                           class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-nationality" role="tabpanel"
                                                 aria-labelledby="vert-tabs-nationality-tab">
                                                <h5 class="underline">الجنسيات</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="nationality-create"
                                                           value="nationality create" wire:model="permission">
                                                    <label for="nationality-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="nationality-show"
                                                           value="nationality show" wire:model="permission">
                                                    <label for="nationality-show"
                                                           class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="nationality-edit"
                                                           value="nationality edit" wire:model="permission">
                                                    <label for="nationality-edit"
                                                           class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="nationality-delete"
                                                           value="nationality delete" wire:model="permission">
                                                    <label for="nationality-delete"
                                                           class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-qualification" role="tabpanel"
                                                 aria-labelledby="vert-tabs-qualification-tab">
                                                <h5 class="underline">الشهادات العلمية</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="qualification-create"
                                                           value="qualification create" wire:model="permission">
                                                    <label for="qualification-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="qualification-show"
                                                           value="qualification show" wire:model="permission">
                                                    <label for="qualification-show"
                                                           class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="qualification-edit"
                                                           value="qualification edit" wire:model="permission">
                                                    <label for="qualification-edit"
                                                           class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="qualification-delete"
                                                           value="qualification delete" wire:model="permission">
                                                    <label for="qualification-delete"
                                                           class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-category" role="tabpanel"
                                                 aria-labelledby="vert-tabs-category-tab">
                                                <h5 class="underline">التصنيفات</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="category-create"
                                                           value="category create" wire:model="permission">
                                                    <label for="category-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="category-show"
                                                           value="category show" wire:model="permission">
                                                    <label for="category-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="category-edit"
                                                           value="category edit" wire:model="permission">
                                                    <label for="category-edit"
                                                           class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="category-delete"
                                                           value="category delete" wire:model="permission">
                                                    <label for="category-delete"
                                                           class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="vert-tabs-user" role="tabpanel"
                                                 aria-labelledby="vert-tabs-user-tab">
                                                <h5 class="underline">المتطوعين</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="user-create"
                                                           value="user create" wire:model="permission">
                                                    <label for="user-create" class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="user-show"
                                                           value="user show" wire:model="permission">
                                                    <label for="user-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="user-edit"
                                                           value="user edit" wire:model="permission">
                                                    <label for="user-edit" class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="user-delete"
                                                           value="user delete" wire:model="permission">
                                                    <label for="user-delete" class="custom-control-label">مسح</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="user-export"
                                                           value="user export" wire:model="permission">
                                                    <label for="user-export" class="custom-control-label">تصدير اكسيل</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="custom-content-below-approval" role="tabpanel"
                                 aria-labelledby="custom-content-below-approval-tab">

                                <div class="row">
                                    <div class="col-7 col-sm-6">
                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist"
                                             aria-orientation="vertical">
                                            <a class="nav-link active" id="vert-tabs-approval-tab" data-toggle="pill"
                                               href="#vert-tabs-approval" role="tab" aria-controls="vert-tabs-approval"
                                               aria-selected="false">الموافقات</a>
                                        </div>
                                    </div>
                                    <div class="col-5 col-sm-6">
                                        <div class="tab-content" id="vert-tabs-tabContent">
                                            <div class="tab-pane fade active show" id="vert-tabs-approval"
                                                 role="tabpanel"
                                                 aria-labelledby="vert-tabs-approval-tab">
                                                <h5>الموافقات</h5>
                                                <hr>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="approval-create"
                                                           value="approval create" wire:model="permission">
                                                    <label for="approval-create"
                                                           class="custom-control-label">انشاء</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="approval-show"
                                                           value="approval show" wire:model="permission">
                                                    <label for="approval-show" class="custom-control-label">عرض</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="approval-edit"
                                                           value="approval edit" wire:model="permission">
                                                    <label for="approval-edit"
                                                           class="custom-control-label">تعديل</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox"
                                                           id="approval-delete"
                                                           value="approval delete" wire:model="permission">
                                                    <label for="approval-delete"
                                                           class="custom-control-label">مسح</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
    <!--role model -->

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
        //     $('#create-role').modal('hide');
        // });
        // });
    </script>
    <!-- DataTables -->
    {{--    <script src="{{asset('adminlte/plugins/datatables/jquery.dataTables.js')}}"></script>--}}
    {{--    <script src="{{asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>--}}
@endpush
