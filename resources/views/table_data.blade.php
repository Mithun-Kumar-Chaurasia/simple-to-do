<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @php $i=0; @endphp
            @foreach($data as $dt)
                <tr>
                    <td>{{++$i}}</td>
                    <td>{{$dt->task}}</td>
                    <td>{{$dt->status}}</td>
                    <td>
                        @if($dt->status=='')
                        <button class="btn btn-success btn-sm" onclick="complete_task({{$dt->id}});">
                            <i class="fa fa-check-square-o"></i>
                        </button> | 
                        @endif
                        <button class="btn btn-danger btn-sm" onclick="delete_task({{$dt->id}});">X</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<button class="btn btn-info" onclick="show_all();">Show All</button>