@extends('layouts.app')

@section('content')
<!-- Page Content -->
<div class="container">
    <div class="row">
        <!-- Sidebar Widgets Column -->
        <div class="col-md-6">
            <!-- Authentication Widget -->
            <div class="card my-4">
                <h5 class="card-header text-center">Authentication</h5>
                <div class="card-body">
                    <!-- <form> -->
                    @csrf
                    <div class="form-group row mt-4 mb-4">
                        <label for="accId"
                            class="col-sm-4 col-form-label">UID</label>
                        <div class="col-sm-8">
                            <input type="text"
                                class="form-control"
                                id="accId">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="apiKey"
                            class="col-sm-4 col-form-label">API Key</label>
                        <div class="col-sm-8">
                            <input type="text"
                                class="form-control"
                                id="apiKey">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <label for="secret"
                            class="col-sm-4 col-form-label">Secret Key</label>
                        <div class="col-sm-8">
                            <input type="password"
                                class="form-control"
                                id="secret">
                        </div>
                    </div>
                    <div class="form-group row mb-4 mb-4">
                        <label for="pw"
                            class="col-sm-4 col-form-label">PW</label>
                        <div class="col-sm-8">
                            <input type="password"
                                class="form-control"
                                id="pw">
                        </div>
                    </div>
                    <div class="form-group row mb-4">
                        <div class="col-sm-12 text-center">
                            <button type="button"
                                id="auth_submit"
                                class="btn btn-secondary mt-4 w-25">Submit</button>
                        </div>
                    </div>
                    <!-- </form> -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
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
                                <span class="currency">$</span>
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
                        <div class="col-lg-4">
                            <div class="text-center">
                                <h6>Main Account</h6>
                                <div class="d-flex  justify-content-around">
                                    <div>THETA</div>
                                    <div>
                                        <span class="currency">$</span>
                                        <span id="main_theta">0.00</span>
                                    </div>
                                </div>
                                <div class="d-flex  justify-content-around">
                                    <div>USDT</div>
                                    <div>
                                        <span class="currency">$</span>
                                        <span id="main_usdt">0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-center">
                                <h6>Trading Account</h6>
                                <div class="d-flex  justify-content-around">
                                    <div>THETA</div>
                                    <div>
                                        <span class="currency">$</span>
                                        <span id="trade_theta">0.00</span>
                                    </div>
                                </div>
                                <div class="d-flex  justify-content-around">
                                    <div>USDT</div>
                                    <div>
                                        <span class="currency">$</span>
                                        <span id="trade_usdt">0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-center">
                                <h6>Margin Account</h6>
                                <div class="d-flex  justify-content-around">
                                    <div>THETA:</div>
                                    <div>
                                        <div>
                                            <span class="currency">$</span>
                                            <span id="margin_theta_total">0.00</span>
                                        </div>
                                        <div>
                                            <span id="margin_debt_ratio">0.00</span>
                                            <span class="currency">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex  justify-content-around">
                                    <div>USDT:</div>
                                    <div>
                                        <div>
                                            <span class="currency">$</span>
                                            <span id="margin_usdt_total">0.00</span>
                                        </div>
                                        <div>
                                            <span class="currency">$</span>
                                            <span id="margin_usdt_liability">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-center">Leverage(%)</h6>
                        <div class="row">
                            <div class="col-lg-4 text-center">
                                <button type="button"
                                    class="btn btn-primary"
                                    data-toggle="modal"
                                    data-target="#transfer-funds">Transfer Funds</button>
                            </div>
                            <div class="col-lg-4 d-flex mt-2">
                                <h5 id="leverage"
                                    class="ml-auto">0.00</h5>
                                <h5 class="currency mr-auto">%</h5>
                            </div>
                            <div class="col-lg-4 text-center">
                                <button type="button"
                                    class="btn btn-info"
                                    data-toggle="modal"
                                    data-target="#margin-borrow">Margin Borrow</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trading -->
    <div class="card my-4">
        <h5 class="card-header text-center">Trading</h5>
        <div class="card-body">
            <!-- Trading tabs navs -->
            <ul class="nav nav-tabs"
                role="tablist">
                <li class="nav-item"
                    role="presentation">
                    <a class="nav-link active trading-tabs"
                        id="spot-tab"
                        data-toggle="tab"
                        href="#spot-tabs"
                        role="tab"
                        aria-controls="spot-tabs"
                        aria-selected="true">Spot</a>
                </li>
                <li class="nav-item"
                    role="presentation">
                    <a class="nav-link trading-tabs"
                        id="margin-tab"
                        data-toggle="tab"
                        href="#margin-tabs"
                        role="tab"
                        aria-controls="margin-tabs"
                        aria-selected="false">Margin</a>
                </li>
            </ul>
            <!-- Trading tabs navs -->

            <!-- Trading tabs content -->
            <div class="tab-content"
                id="ex1-content">
                <div class="tab-pane fade show active"
                    id="spot-tabs"
                    role="tabpanel"
                    aria-labelledby="spot-tab">
                    <!-- Sub tab navs -->
                    <ul class="nav nav-tabs mb-3 sub-nav-tabs"
                        id="ex1"
                        role="tablist">
                        <li class="nav-item"
                            role="presentation">
                            <a class="nav-link active sub-nav-link"
                                id="spot-market-tab"
                                data-toggle="tab"
                                href="#spot-market-tabs"
                                role="tab"
                                aria-controls="spot-market-tabs"
                                aria-selected="true">Market</a>
                        </li>
                        <li class="nav-item"
                            role="presentation">
                            <a class="nav-link sub-nav-link"
                                id="spot-limit-tab"
                                data-toggle="tab"
                                href="#spot-limit-tabs"
                                role="tab"
                                aria-controls="spot-limit-tabs"
                                aria-selected="false">Stop Limit</a>
                        </li>
                        <li class="nav-item"
                            role="presentation">
                            <a class="nav-link sub-nav-link"
                                id="spot-smarket-tab"
                                data-toggle="tab"
                                href="#spot-smarket-tabs"
                                role="tab"
                                aria-controls="spot-smarket-tabs"
                                aria-selected="false">Stop Market</a>
                        </li>
                    </ul>
                    <!-- Sub tab navs -->

                    <!-- Sub tab content -->
                    <div class="tab-content"
                        id="ex1-content">
                        <div class="tab-pane fade show active p-2 pl-4"
                            id="spot-market-tabs"
                            role="tabpanel"
                            aria-labelledby="spot-market-tab">
                            <input type="number"
                                class="form-control w-25 mb-3"
                                id="spot-market-price"
                                placeholder="Price">
                            <input type="number"
                                class="form-control w-25"
                                id="spot-market-amount"
                                placeholder="Amount">
                        </div>
                        <div class="tab-pane fade"
                            id="spot-limit-tabs"
                            role="tabpanel"
                            aria-labelledby="spot-limit-tab">
                            spot 2 content
                        </div>
                        <div class="tab-pane fade"
                            id="spot-smarket-tabs"
                            role="tabpanel"
                            aria-labelledby="spot-smarket-tab">
                            spot 3 content
                        </div>
                    </div>
                    <!-- Sub tab content -->

                </div>
                <div class="tab-pane fade"
                    id="margin-tabs"
                    role="tabpanel"
                    aria-labelledby="margin-tab">
                    <!-- Sub tab navs -->
                    <ul class="nav nav-tabs mb-3 sub-nav-tabs"
                        id="ex1"
                        role="tablist">
                        <li class="nav-item"
                            role="presentation">
                            <a class="nav-link active sub-nav-link"
                                id="margin-market-tab"
                                data-toggle="tab"
                                href="#margin-market-tabs"
                                role="tab"
                                aria-controls="margin-market-tabs"
                                aria-selected="true">Market</a>
                        </li>
                        <li class="nav-item"
                            role="presentation">
                            <a class="nav-link sub-nav-link"
                                id="margin-limit-tab"
                                data-toggle="tab"
                                href="#margin-limit-tabs"
                                role="tab"
                                aria-controls="margin-limit-tabs"
                                aria-selected="false">Stop Limit</a>
                        </li>
                        <li class="nav-item"
                            role="presentation">
                            <a class="nav-link sub-nav-link"
                                id="margin-smarket-tab"
                                data-toggle="tab"
                                href="#margin-smarket-tabs"
                                role="tab"
                                aria-controls="margin-smarket-tabs"
                                aria-selected="false">Stop Market</a>
                        </li>
                    </ul>
                    <!-- Sub tab navs -->

                    <!-- Sub tab content -->
                    <div class="tab-content"
                        id="ex1-content">
                        <div class="tab-pane fade show active"
                            id="margin-market-tabs"
                            role="tabpanel"
                            aria-labelledby="margin-market-tab">
                            margin 1 content
                        </div>
                        <div class="tab-pane fade"
                            id="margin-limit-tabs"
                            role="tabpanel"
                            aria-labelledby="margin-limit-tab">
                            margin 2 content
                        </div>
                        <div class="tab-pane fade"
                            id="margin-smarket-tabs"
                            role="tabpanel"
                            aria-labelledby="margin-smarket-tab">
                            margin 3 content
                        </div>
                    </div>
                    <!-- Sub tab content -->
                </div>
            </div>
            <!-- Trading tabs content -->
        </div>
    </div>
    <!-- Trading -->
    <!-- Sub accounts Column -->
    <div>
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
    <!-- /.row -->
    <div class="modal fade"
        id="transfer-funds"
        tabindex="-1"
        role="dialog"
        aria-labelledby="transfer-funds-label"
        aria-hidden="true">
        <div class="modal-dialog"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="transfer-funds-label">Transfer</h5>
                    <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Direction</label>
                            <div class="d-flex">
                                <select class="form-control"
                                    id="direction1">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    width="16"
                                    height="16"
                                    fill="currentColor"
                                    class="bi bi-arrow-left-right w-25 mt-2"
                                    viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 11.5a.5.5 0 0 0 .5.5h11.793l-3.147 3.146a.5.5 0 0 0 .708.708l4-4a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 11H1.5a.5.5 0 0 0-.5.5zm14-7a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 1 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 4H14.5a.5.5 0 0 1 .5.5z" />
                                </svg>
                                <select class="form-control"
                                    id="direction2">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="coin">Coin</label>
                            <select class="form-control"
                                id="coin">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row pl-3 pr-3">
                                <label>Amount</label>
                                <label class="ml-auto">Available Amount: <span class="text-primary">0<span></label>
                            </div>
                            <div class="input-group">
                                <input type="number"
                                    class="form-control"
                                    id="transfer-amount"
                                    required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text"
                                        id="transfer-amount-prepend">USDT</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-success w-100">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade"
        id="margin-borrow"
        tabindex="-1"
        role="dialog"
        aria-labelledby="margin-borrow-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="margin-borrow-label">Borrow USDT</h5>
                    <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form class="col-lg-6">
                            <div class="form-group">
                                <label for="daily-rate">Max Daily Interest Rate (No limit if left empty)</label>
                                <div class="input-group">
                                    <input type="number"
                                        class="form-control"
                                        id="daily-rate"
                                        placeholder="Daily Interest Rate: 0% ~ 2%"
                                        required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="daily-rate-prepend">%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row pl-3 pr-3">
                                    <label>Amount</label>
                                    <label class="ml-auto">Available Amount: <span class="text-primary">0<span></label>
                                </div>
                                <div class="input-group">
                                    <input type="number"
                                        class="form-control"
                                        id="borrow-amount"
                                        required>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"
                                            id="borrow-amount-prepend">USDT</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-3 pr-0">
                                        <button type="button"
                                            class="btn btn-light w-100">25%</button>
                                    </div>
                                    <div class="col-lg-3 pr-0">
                                        <button type="button"
                                            class="btn btn-light w-100">50%</button>
                                    </div>
                                    <div class="col-lg-3 pr-0">
                                        <button type="button"
                                            class="btn btn-light w-100">75%</button>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="button"
                                            class="btn btn-light w-100">100%</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="terms">Terms</label>
                                <div class="input-group">
                                    <div class="form-check col-lg-4">
                                        <input class="form-check-input"
                                            type="radio"
                                            name="term-radio"
                                            id="term-7"
                                            value="7">
                                        <label class="form-check-label"
                                            for="term-7">
                                            7 Days
                                        </label>
                                    </div>
                                    <div class="form-check col-lg-4">
                                        <input class="form-check-input"
                                            type="radio"
                                            name="term-radio"
                                            id="term-14"
                                            value="14">
                                        <label class="form-check-label"
                                            for="term-14">
                                            14 Days
                                        </label>
                                    </div>
                                    <div class="form-check col-lg-4">
                                        <input class="form-check-input"
                                            type="radio"
                                            name="term-radio"
                                            id="term-28"
                                            value="28">
                                        <label class="form-check-label"
                                            for="term-28">
                                            28 Days
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </form>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="target-rate">Target(%)</label>
                                <div class='d-flex'>
                                    <input type="number"
                                        class="form-control"
                                        id="target-rate"
                                        required>
                                    <button type="button"
                                        class="btn btn-secondary ml-4">Calculate</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-success w-100">Borrow USDT</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@include('scripts.home-js')

@endsection