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
    {{--            @if(count($activities)>0)--}}
    <tr>
        <th>#</th>
        <th>الاسم</th>
        <th>اللجنة</th>
        <th>الصفة</th>
        @for($i =$filter_from ; $i<=$filter_to; $i++)
            <th colspan="2">{{$i}}</th>
        @endfor
    </tr>
    {{--            @endif--}}
    </thead>
    <tbody>
    @forelse($users as $user)
        <tr>
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->team->name}}</td>
            <td>{{$user->position->name}}</td>
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
