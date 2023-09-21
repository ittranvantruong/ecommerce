@extends('admin.layouts.master')
@push('custom-css')
    <style>
        .draw-chart {
            width: 100%;
            height: 500px;
        }
    </style>
@endpush
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        {{ __('Dashboard') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="row row-cards">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-green text-white avatar">
                                                <i class="ti ti-currency-dollar"></i>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold text-primary">
                                                {{ format_price($statistic_order[0]['order_total']) }}
                                            </div>
                                            <div class="text-secondary">
                                                @lang('Tổng doanh thu')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-green text-white avatar">
                                                <i class="ti ti-shopping-cart"></i>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold text-primary">
                                                {{ $statistic_order[0]['order_count'] }}
                                            </div>
                                            <div class="text-secondary">
                                                @lang('Đơn hoàn thành')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-green text-white avatar">
                                                <i class="ti ti-brand-producthunt"></i>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold text-primary">
                                                {{ $total_product_sold }}
                                            </div>
                                            <div class="text-secondary">
                                                @lang('Sản phẩm đã bán')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card card-sm">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-green text-white avatar">
                                                <i class="ti ti-user"></i>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="fw-bold text-primary">
                                                {{ $total_user }}
                                            </div>
                                            <div class="text-secondary">
                                                @lang('Thành viên')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">{{ __('Biểu đồ doanh thu 7 ngày gần đây') }}</h3>
                            <div id="showChartOrder" class="draw-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">{{ __('Biểu đồ sản phẩm đã bán trong 7 ngày ') }}</h3>
                            <div id="showChartProductSold" class="draw-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('admin.scripts.amchart')
@push('libs-js')

@endpush

@push('custom-js')
<x-input id="dataChartOrder" type="hidden" :value="$chart_order" />
<x-input id="dataChartProductSold" type="hidden" :value="$chart_product_sold" />
<!-- Chart code -->
<script>
    $(document).ready(function(){
        makeAmchart('showChartOrder', $('#dataChartOrder').val(), 'order_date', 'order_total');
        makeAmchart('showChartProductSold', $('#dataChartProductSold').val(), 'sell_date', 'product_qty');
        console.log(JSON.parse($('#dataChartProductSold').val()));
    })
</script>
@endpush

