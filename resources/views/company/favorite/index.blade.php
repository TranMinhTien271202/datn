@extends('company.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <!-- Ls widget -->
            <div class="ls-widget">
                <div class="tabs-box">
                    <div class="widget-title">
                        <h4>{{ $title }}</h4>
                    </div>

                    <div class="widget-content">
                        <div class="table-outer">
                            <table class="default-table manage-job-table">
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
                                                <span>{{ $item->pivot->is_see == 1 ? "Đã xem" : "Chưa xem" }}</span>
                                            </td>
                                            <td>{{ $item->phone }} <br>{{ $item->email }}
                                            <td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Info Section -->
    @endsection
