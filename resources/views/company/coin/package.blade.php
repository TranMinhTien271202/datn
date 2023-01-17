@extends('company.layout.app')
@section('title')
    {{ __('Gói cước') }}
@endsection
@section('content')
    <div class="row view-invoice">
        <div class="col-lg-12">
            <!-- Ls widget -->
            <div class="ls-widget">
                <div class="tabs-box">
                    <div class="widget-title">
                        <h4>Gói dịch vụ</h4>
                    </div>
                    <div class="widget-content">
                        <div class="tab active-tab" id="monthly">
                            <div class="content">
                                <div class="row">
                                    <!-- Pricing Table -->
                                    @foreach ($packages as $package)
                                        <div class="pricing-table col-lg-4 col-md-6 col-sm-6">
                                            <div class="inner-box">
                                                <div class="title">{{ $package['title'] }}</div>
                                                <div class="price row mb-0">
                                                    <div class="col-12">
                                                        {{ number_format(($package['amount']-$package['discount']), 0, ',', '.') }} vnđ<span
                                                            class="duration">/ {{ $package['expired'] }} tháng</span>
                                                    </div>

                                                    <p style="text-decoration-line:line-through" class="col-12">
                                                        {{ number_format($package['amount'], 0, ',', '.') }}vnđ <span
                                                            class="">/ {{ $package['expired'] }} tháng</span>
                                                    </p>
                                                </div>
                                                <div class="table-footer">
                                                    <button data-id="{{ $package['id'] }}"
                                                        class="theme-btn btn-style-three btn_buy">Mua ngay</button>
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
@section('script')
    @parent
    <script>
        $(document).ready(function() {
            $('.btn_buy').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                        icon: 'info',
                        text: 'Bạn có đồng ý mua không ?',
                        showCancelButton: true,
                        confirmButtonText: 'Đồng ý',
                        confirmButtonColor: '#C46F01',
                        cancelButtonText: 'Không'
                    })
                    .then((results) => {
                        if (results.isConfirmed) {
                            var data = {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "id": id,
                            }
                            $.ajax({
                                type: "POST",
                                url: `insertInvoice`,
                                data: data,
                                success: function(response) {
                                    $(".view-invoice").html(response);
                                   
                                }
                            });

                        }
                    });
            });
        });
    </script>
@endsection
