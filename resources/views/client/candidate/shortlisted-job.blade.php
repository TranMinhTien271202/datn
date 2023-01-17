@extends('client.layout.app')
@section('title')
    {{ __('UB Work') }} | {{__('Công việc đã lưu') }}
@endsection
@section('content')
<section class="page-title" style="margin-top: 90px">
  <div class="auto-container">
      <div class="title-outer">
          <h1>Công việc đã lưu</h1>
      </div>
  </div>
  </section>
    <section class="user-dashboard">
      <div class="dashboard-outer">
        <div class="row pt-5" >
          <div class="col-lg-10 m-auto">
            <!-- Ls widget -->
            <div class="ls-widget">
              <div class="tabs-box">
                <div class="widget-content">
                  <div class="table-outer">
                    <table class="default-table manage-job-table">
                      <thead>
                        <tr>
                          <th>Tiêu đề</th>
                          <th>Thời gian lưu</th>
                          <th>Hành động</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data as $item)
                        <tr>
                          <td>
                            <!-- Job Block -->
                            <div class="job-block">
                              <div class="inner-box">
                                <div class="content">
                                  <span class="company-logo"><img src="{{asset('storage/images/company/'.$job_short[$item->job_post_id]->company->logo)}}" alt=""></span>
                                  <h4><a  href="{{route('job-detail', ['id' => $job_short[$item->job_post_id]->id])}}" target="_blank">{{$job_short[$item->job_post_id]->title}} </a></h4>
                                  <ul class="job-info">
                                    <li><span class="icon flaticon-briefcase"></span> {{config('custom.level')[$job_short[$item->job_post_id]->level]['name']}} </li>
                                    <li><span class="icon flaticon-map-locator"></span>{{$job_short[$item->job_post_id]->company->address}}</li>
                                  </ul>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td>{{$item->created_at->format('H:m:s d/m/Y')}}</td>
                          <td>
                            <div class="option-box">
                              <ul class="option-list">
                                <li><a target="_blank" href="{{route('job-detail', ['id' => $job_short[$item->job_post_id]->id])}}"><button data-text="View Aplication"><span class="la la-eye"></span></button></a></li>
                                <li><a href="{{route('delete_shortlisted', ['id' => $item->id])}}"><button data-text="Delete Aplication"><span class="la la-trash"></span></button></a></li>
                              </ul>
                            </div>
                          </td>
                        </tr>
                        @endforeach
                        
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3"><nav class="ls-pagination">
                            {{ $data->links('company.layout.paginate') }}
                          </nav></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection