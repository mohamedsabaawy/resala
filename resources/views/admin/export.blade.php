<table id="example1" class="table table-bordered table-responsive">
    <thead>
    @php
        $start = date_format(today(),"Y-m-01");
        $end = date_format(today(),"y-m-t");
        function getActivity($i,$user){
                    if (count($user->activities->where('activity_date',$i))>0){
                        return $user->activities->where('activity_date',$i)->first()->comment;
                    }
                }
        function getActivityEvent($i,$user){
            if (count($user->activities->where('activity_date',"$i"))>0){
                if (!$user->activities->where('activity_date',"$i")->first()->apologize)
                    return optional($user->activities->where('activity_date',$i)->first()->event)->name ?? "تم مسح الحدث";
                return "عذر عن : " .(optional($user->activities->where('activity_date',$i)->first()->event)->name  ?? "تم مسح الحدث" );
            }
        }
    @endphp
    {{--            @if(count($activities)>0)--}}
    <tr>
        <th>كود</th>
        <th>الاسم</th>
        <th>تليفون</th>
        <th>نشاط</th>
        <th>الصفة</th>
        @for($i =$filter_from ; $i<=$filter_to; $i = \Carbon\Carbon::parse($i)->addDay()->format('Y-m-d'))
            <th colspan="2">{{$i}}</th>
        @endfor
    </tr>
    {{--            @endif--}}
    </thead>
    <tbody>
    @forelse($users as $user)
        <tr>
            <td>{{$user->code}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->phone}}</td>
            <td>{{$user->job->name ?? null}}</td>
            <td>{{$user->position->name ?? null}}</td>
            @for($i =$filter_from ; $i<=$filter_to; $i = \Carbon\Carbon::parse($i)->addDay()->format('Y-m-d'))
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
