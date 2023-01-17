<table class="default-table manage-job-table" data-pageApplied={{$pageApplied}}>
    <thead>
        <tr>
            <th>Ứng viên</th>
            <th>Thông tin liên hệ </th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listSeeker as $item)
            <tr>
                <td>
                    <h6>{{ $item->name }}</h6>
                    {{-- <span>{{ $item->pivot->is_see == 1 ? "Đã xem" : "Chưa xem" }}</span> --}}
                </td>
                <td>{{ $item->phone }} <br>{{ $item->email }}
                </td>
                <td><a class="check_see" data-id-cv="{{$item->id}}" target="_blank" href="{{'/upload/cv/'.$item->path_cv}}">Chi tiết</a></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td><nav class="ls-pagination">
              {{$listSeeker->links('company.layout.paginate')}}
             </nav>
            </td>
          </tr>
    </tfoot>
</table>
