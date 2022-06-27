<div class="table-responsive">
    <table id="" class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key=>$item)
                @php
                    $presents = json_decode($item->present_students,true);
                    $absents = json_decode($item->absent_students,true);
                    
                @endphp
                @if (in_array($user_id,$presents) || in_array($user_id,$absents))
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->attendance_date }}</td>
                        <td>
                            @if (in_array($user_id,$presents))
                                <span class="badge light badge-success">P</span>
                            @elseif (in_array($user_id,$absents))
                                <span class="badge light badge-danger">A</span>
                            @else
                                <span class="badge light badge-info">-</span>
                            @endif
                        </td>												
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>