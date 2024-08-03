<table id="example1" class="table table-bordered table-striped">
    <thead>
    @if(count($meetings)>0)
        <tr>
            <th>تاريخ الاجتماع</th>
            <th>اسم الفرع</th>
            <th>اللجنة</th>
            <th>رئيس الاجتماع</th>
            <th>وظيفة رئيس الاجتماع</th>
            <th>نوع المشاركة</th>
            <th>عدد الحاضرين</th>
            <th>هدف الاجتماع</th>
            <th>ملاحظات</th>
        </tr>
    @endif
    </thead>
    <tbody>
    @foreach($meetings as $meeting)
        <tr class="{{$meeting->deleted_at ? 'bg-gradient-gray':''}}">
            <td>{{$meeting->date}}</td>
            <td>{{$meeting->branch->name}}</td>
            <td>{{$meeting->team->name}}</td>
            <td>{{$meeting->user->name}}</td>
            <td>{{$meeting->position->name}}</td>
            <td>{{$meeting->status ? 'اونلاين':'اوفلاين'}}</td>
            <td>{{$meeting->count}}</td>
            <td>{{$meeting->title}}</td>
            <td>{{$meeting->comment}}</td>
        </tr>

    @endforeach
    </tbody>
    <tfoot>
    <div>
    </div>
    </tfoot>
</table>
