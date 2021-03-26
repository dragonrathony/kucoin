@extends('layouts.app')

@section('style')

@endsection

@section('content')
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Sub accounts Column -->
        <div class="col-lg-8">

            <div class="card my-4">
                <h5 class="card-header text-center">Sub accounts</h5>
                <div class="card-body">
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>#</th>
                                <th>#</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>-</th>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <th>-</th>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <th>-</th>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <!-- Authentication Widget -->
            <div class="card my-4">
                <h5 class="card-header text-center">Authentication</h5>
                <div class="card-body">
                    <!-- <form> -->
                    @csrf
                    <div class="form-group row">
                        <label for="accId" class="col-sm-4 col-form-label">UID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="accId">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="apiKey" class="col-sm-4 col-form-label">API Key</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="apiKey">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="secret" class="col-sm-4 col-form-label">Secret Key</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="secret">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pw" class="col-sm-4 col-form-label">PW</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="pw">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                            <button type="button" id="auth_submit" class="btn btn-secondary">Submit</button>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>

            <!-- Market Pair & Current Price Widget -->
            <div class="card my-4">
                <h5 class="card-header text-center">Market Pair & Current Price</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 text-center">
                            <div class="mb-2">
                                <b>Market Pair</b>
                            </div>
                            <div>THETA-USDT</div>
                        </div>
                        <div class="col-lg-6 text-center">
                            <div class="mb-2">
                                <b>Current Price</b>
                            </div>
                            <div>
                                <span class="currency">$&nbsp;</span>
                                <span id="current_price">0.00</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Primary Account Assets Widget -->
            <div class="card my-4">
                <h5 class="card-header text-center">Primary Account Assets</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-2">
                                Main Account
                                <div class="d-flex  justify-content-around">
                                    <div>THETA</div>
                                    <div>
                                        <span class="currency">$&nbsp;</span>
                                        <span id="main_theta">0.00</span>
                                    </div>
                                </div>
                                <div class="d-flex  justify-content-around">
                                    <div>USDT</div>
                                    <div>
                                        <span class="currency">$&nbsp;</span>
                                        <span id="main_usdt">0.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                Trading Account
                                <div class="d-flex  justify-content-around">
                                    <div>THETA</div>
                                    <div>
                                        <span class="currency">$&nbsp;</span>
                                        <span id="trade_theta">0.00</span>
                                    </div>
                                </div>
                                <div class="d-flex  justify-content-around">
                                    <div>USDT</div>
                                    <div>
                                        <span class="currency">$&nbsp;</span>
                                        <span id="trade_usdt">0.00</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2">
                                Margin Account
                                <div class="d-flex  justify-content-around text-success">
                                    <div>THETA:</div>
                                    <div>
                                        <div>
                                            <span class="currency">$&nbsp;</span>
                                            <span id="margin_theta_total">0.00</span>
                                        </div>
                                        <div>
                                            <span id="margin_debt_ratio">0.00</span>
                                            <span class="currency">%</span>
                                        </div>
                                    </div>

                                </div>
                                <div class="d-flex  justify-content-around text-success">
                                    <div>USDT:</div>
                                    <div>
                                        <div>
                                            <span class="currency">$&nbsp;</span>
                                            <span id="margin_usdt_total">0.00</span>
                                        </div>
                                        <div>
                                            <span class="currency">$&nbsp;</span>
                                            <span id="margin_usdt_liability">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>



        </div>

    </div>
    <!-- /.row -->

</div>
@endsection

@section('script')

@include('scripts.home-js')

@endsection