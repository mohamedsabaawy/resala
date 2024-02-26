<x-appAdminlte-layout>

    <div class="card">
        <div class="card-header d-flex">
            <h3 class="card-title text-blue text-bold">روابط تهمك</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">

                @forelse($links as $link)
                    <div class="col-12 col-sm-6 col-lg-4 border">
                        <label for="" class="text-blue">
                            <a href="{{$link->link}}">{{$link->name}}</a>
                        </label>
{{--                        <div class="text-red text-bold">{{$link->name}}</div>--}}
                    </div>
                @empty
                    <h1>لا يوجد بيانات</h1>
                    @endforelse

            </div>
        </div>
        <!-- /.card-body -->


    </div>


</x-appAdminlte-layout>
