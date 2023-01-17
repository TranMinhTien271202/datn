@extends('company.layout.app')
@section('title')
    {{ __('Lịch sử giao dịch') }}
@endsection
@section('content')
    <div class="row view-invoice">
        <div class="col-lg-12">
            <!-- Ls widget -->
            <div class="ls-widget">
                <div class="tabs-box">
                    <div class="widget-title">
                        <h3 class="pt-2">Lịch sử giao dịch</h3>
                    </div>
                    <div class="widget-content">
                        <div class="tab active-tab" id="monthly">
                            <div class="content ml-5">
                                <div class="row resume-outer">
                                    <div class="text col-3" style="margin-left: 5px; padding-top:7px">
                                        Số dư hiện tại : {{auth('company')->user()->coin}}
                                    </div>
                                    {{-- <div class="col-2">
                                        <button class="theme-btn btn-style-one btn-sm" style="padding: 7px 15px 5px 15px;" >Rút tiền</button>
                                    </div> --}}
                                </div>
                                <div class="row resume-outer theme-blue">
                                    <!-- Pricing Table -->
                                    @foreach ($history as $item)
                                        <div class="resume-block">
                                            <div class="inner">
                                                <span class="name"
                                                    style="">{{ $item['type_coin'] != 0 ? '+' : '-' }}</span>
                                                <div class="title-box">
                                                    <div class="info-box">
                                                    </div>
                                                    <div class="edit-box">
                                                        <span
                                                            class="year">{{ date_format($item['created_at'], 'd-m-Y') }}</span>
                                                    </div>
                                                </div>
                                                <div class="text">
                                                    {{ $item['note'] }}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
