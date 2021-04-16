@extends('layouts.app')

@section('content')
<!-- Page Content -->
<div class="container">
    <div class="row m-0">
        <!-- Sidebar Widgets Column -->
        @if ($session === null)
        <div class="col-md-6">
            <!-- Authentication Widget -->
            <div class="card my-4">
                <h5 class="card-header text-center">Authentication{{$session}}</h5>
                <div class="card-body">
                    <!-- <form> -->
                    <form method="POST"
                        action="{{ url('home/auth') }}">
                        @csrf
                        <div class="form-group row mt-4 mb-4">
                            <label for="accId"
                                class="col-sm-4 col-form-label">UID</label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control"
                                    name="accId"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="apiKey"
                                class="col-sm-4 col-form-label">API Key</label>
                            <div class="col-sm-8">
                                <input type="text"
                                    class="form-control"
                                    name="apiKey"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="secret"
                                class="col-sm-4 col-form-label">Secret Key</label>
                            <div class="col-sm-8">
                                <input type="password"
                                    class="form-control"
                                    name="secret"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row mb-4 mb-4">
                            <label for="pw"
                                class="col-sm-4 col-form-label">PW</label>
                            <div class="col-sm-8">
                                <input type="password"
                                    class="form-control"
                                    name="pw"
                                    required>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-sm-12 text-center">
                                <button type="submit"
                                    id="auth_submit"
                                    class="btn btn-secondary mt-4 w-25">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @else
        @endif

        @if ($session === null)
        <div class="col-md-6">
            <div class="card my-4">
                @else
                <!-- Market Pair & Current Price Widget -->
                <div class="card col-md-6 my-4 p-0">
                    @endif
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
                                    <span id="current_price">{{$values['current_price']}}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Primary Account Assets Widget -->
                @if ($session === null)
                <div class="card my-4">
                    @else
                    <div class="card col-md-6 my-4 p-0">
                        @endif
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
                                                <span id="main_theta">{{$values['main_theta']}}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex  justify-content-around">
                                            <div>USDT</div>
                                            <div>
                                                <span class="currency">$</span>
                                                <span id="main_usdt">{{$values['main_usdt']}}</span>
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
                                <div class="col-lg-4 pl-0">
                                    <div class="text-center">
                                        <h6>Margin Account</h6>
                                        <div class="justify-content-around">
                                            <div class="d-flex">
                                                <div>THETA:</div>
                                                <div class="ml-auto">
                                                    <span class="currency">$</span>
                                                    <span id="margin_theta_total">
                                                        @if ($session === null)
                                                        0.00
                                                        @else
                                                        <?php
                                                            if (strpos(number_format((float)$values['theta_total'], 2, '.', ''), ".00") !== false) {
                                                                echo "< ".str_replace(".00",".01",number_format((float)$values['theta_total'], 2, '.', ''));
                                                            } else {
                                                                echo number_format((float)$values['theta_total'], 2, '.', '');
                                                            }
                                                        ?>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div>LOAN AMT:</div>
                                                <div class="ml-auto">
                                                    <span class="currency">$</span>
                                                    <span id="margin_theta_liability">
                                                        @if ($session === null)
                                                        0.00
                                                        @else
                                                        <?php
                                                            if (strpos(number_format((float)$values['theta_liability'], 2, '.', ''), ".00") !== false) {
                                                                echo "< ".str_replace(".00",".01",number_format((float)$values['theta_liability'], 2, '.', ''));
                                                            } else {
                                                                echo number_format((float)$values['theta_liability'], 2, '.', '');
                                                            }
                                                        ?>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="justify-content-around">
                                            <div class="d-flex">
                                                <div>USDT:</div>
                                                <div class="ml-auto">
                                                    <span class="currency">$</span>
                                                    <span id="margin_usdt_total">
                                                        @if ($session === null)
                                                        0.00
                                                        @else
                                                        <?php
                                                            if (strpos(number_format((float)$values['usdt_total'], 2, '.', ''), ".00") !== false) {
                                                                echo "< ".str_replace(".00",".01",number_format((float)$values['usdt_total'], 2, '.', ''));
                                                            } else {
                                                                echo number_format((float)$values['usdt_total'], 2, '.', '');
                                                            }
                                                        ?>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <div>LOAN AMT:</div>
                                                <div class="ml-auto">
                                                    <span class="currency">$</span>
                                                    <span id="margin_usdt_liability">
                                                        @if ($session === null)
                                                        0.00
                                                        @else
                                                        <?php
                                                            if (strpos(number_format((float)$values['usdt_liability'], 2, '.', ''), ".00") !== false) {
                                                                echo "< ".str_replace(".00",".01",number_format((float)$values['usdt_liability'], 2, '.', ''));
                                                            } else {
                                                                echo number_format((float)$values['usdt_liability'], 2, '.', '');
                                                            }
                                                        ?>
                                                        @endif
                                                    </span>
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
                                            class="ml-auto">{{$values['debtRatio']}}</h5>
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
                @if ($session === null)
            </div>
            @else
            @endif

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
                                        id="spot-limit-tab"
                                        data-toggle="tab"
                                        href="#spot-limit-tabs"
                                        role="tab"
                                        aria-controls="spot-limit-tabs"
                                        aria-selected="true">Limit</a>
                                </li>
                                <li class="nav-item"
                                    role="presentation">
                                    <a class="nav-link sub-nav-link"
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
                                        id="spot-slimit-tab"
                                        data-toggle="tab"
                                        href="#spot-slimit-tabs"
                                        role="tab"
                                        aria-controls="spot-slimit-tabs"
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
                                <div class="tab-pane fade active show p-2 pl-4"
                                    id="spot-limit-tabs"
                                    role="tabpanel"
                                    aria-labelledby="spot-limit-tab">
                                    <div class="d-flex"><input type="number"
                                            class="form-control w-25 mr-5 mb-3"
                                            id="spot-limit-buy-price"
                                            placeholder="Price">
                                        <input type="number"
                                            class="form-control w-25 mb-3"
                                            id="spot-limit-sell-price"
                                            placeholder="Price">
                                    </div>
                                    <div class="d-flex">
                                        <input type="number"
                                            class="form-control w-25 mr-5"
                                            id="spot-limit-buy-amount"
                                            placeholder="Amount">
                                        <input type="number"
                                            class="form-control w-25"
                                            id="spot-limit-sell-amount"
                                            placeholder="Amount">
                                    </div>
                                </div>
                                <div class="tab-pane fade p-2 pl-4"
                                    id="spot-market-tabs"
                                    role="tabpanel"
                                    aria-labelledby="spot-market-tab">
                                    <div class="d-flex"><input type="text"
                                            class="form-control w-25 mr-5 mb-3"
                                            placeholder="Best Market Price"
                                            disabled>
                                        <input type="text"
                                            class="form-control w-25 mr-5 mb-3"
                                            placeholder="Best Market Price"
                                            disabled>
                                    </div>
                                    <div class="d-flex">
                                        <input type="number"
                                            class="form-control w-25 mr-5"
                                            id="spot-market-buy-amount"
                                            placeholder="Amount">
                                        <input type="number"
                                            class="form-control w-25"
                                            id="spot-market-sell-amount"
                                            placeholder="Amount">
                                    </div>
                                </div>
                                <div class="tab-pane fade p-2 pl-4"
                                    id="spot-slimit-tabs"
                                    role="tabpanel"
                                    aria-labelledby="spot-slimit-tab">
                                    <div class="d-flex"><input type="number"
                                            class="form-control w-25 mr-5 mb-3"
                                            id="spot-slimit-buy-sprice"
                                            placeholder="Stop Price">
                                        <input type="number"
                                            class="form-control w-25 mb-3"
                                            id="spot-slimit-sell-sprice"
                                            placeholder="Stop Price">
                                    </div>
                                    <div class="d-flex"><input type="number"
                                            class="form-control w-25 mr-5 mb-3"
                                            id="spot-slimit-buy-price"
                                            placeholder="Price">
                                        <input type="number"
                                            class="form-control w-25 mb-3"
                                            id="spot-slimit-sell-price"
                                            placeholder="Price">
                                    </div>
                                    <div class="d-flex">
                                        <input type="number"
                                            class="form-control w-25 mr-5"
                                            id="spot-slimit-buy-amount"
                                            placeholder="Amount">
                                        <input type="number"
                                            class="form-control w-25"
                                            id="spot-slimit-sell-amount"
                                            placeholder="Amount">
                                    </div>
                                </div>
                                <div class="tab-pane fade p-2 pl-4"
                                    id="spot-smarket-tabs"
                                    role="tabpanel"
                                    aria-labelledby="spot-smarket-tab">
                                    <div class="d-flex"><input type="number"
                                            class="form-control w-25 mr-5 mb-3"
                                            id="spot-smarket-buy-sprice"
                                            placeholder="Stop Price">
                                        <input type="number"
                                            class="form-control w-25 mb-3"
                                            id="spot-smarket-sell-sprice"
                                            placeholder="Stop Price">
                                    </div>
                                    <div class="d-flex"><input type="text"
                                            class="form-control w-25 mr-5 mb-3"
                                            placeholder="Best Market Price"
                                            disabled>
                                        <input type="text"
                                            class="form-control w-25 mr-5 mb-3"
                                            placeholder="Best Market Price"
                                            disabled>
                                    </div>
                                    <div class="d-flex">
                                        <input type="number"
                                            class="form-control w-25 mr-5"
                                            id="spot-smarket-buy-amount"
                                            placeholder="Amount">
                                        <input type="number"
                                            class="form-control w-25"
                                            id="spot-smarket-sell-amount"
                                            placeholder="Amount">
                                    </div>
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
                                        id="margin-limit-tab"
                                        data-toggle="tab"
                                        href="#margin-limit-tabs"
                                        role="tab"
                                        aria-controls="margin-limit-tabs"
                                        aria-selected="true">Limit</a>
                                </li>
                                <li class="nav-item"
                                    role="presentation">
                                    <a class="nav-link sub-nav-link"
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
                                        href="#margin-slimit-tabs"
                                        role="tab"
                                        aria-controls="margin-slimit-tabs"
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
                                <div class="tab-pane fade show active p-2 pl-4"
                                    id="margin-limit-tabs"
                                    role="tabpanel"
                                    aria-labelledby="margin-limit-tab">
                                    <div class="d-flex"><input type="number"
                                            class="form-control w-25 mr-5 mb-3"
                                            id="margin-limit-buy-price"
                                            placeholder="Price">
                                        <input type="number"
                                            class="form-control w-25 mb-3"
                                            id="margin-limit-sell-price"
                                            placeholder="Price">
                                    </div>
                                    <div class="d-flex">
                                        <input type="number"
                                            class="form-control w-25 mr-5"
                                            id="margin-limit-buy-amount"
                                            placeholder="Amount">
                                        <input type="number"
                                            class="form-control w-25"
                                            id="margin-limit-sell-amount"
                                            placeholder="Amount">
                                    </div>
                                </div>
                                <div class="tab-pane fade p-2 pl-4"
                                    id="margin-market-tabs"
                                    role="tabpanel"
                                    aria-labelledby="margin-market-tab">
                                    <div class="d-flex"><input type="text"
                                            class="form-control w-25 mr-5 mb-3"
                                            placeholder="Best Market Price"
                                            disabled>
                                        <input type="text"
                                            class="form-control w-25 mr-5 mb-3"
                                            placeholder="Best Market Price"
                                            disabled>
                                    </div>
                                    <div class="d-flex">
                                        <input type="number"
                                            class="form-control w-25 mr-5"
                                            id="margin-market-buy-amount"
                                            placeholder="Amount">
                                        <input type="number"
                                            class="form-control w-25"
                                            id="margin-market-sell-amount"
                                            placeholder="Amount">
                                    </div>
                                </div>
                                <div class="tab-pane fade p-2 pl-4"
                                    id="margin-slimit-tabs"
                                    role="tabpanel"
                                    aria-labelledby="margin-limit-tab">
                                    <div class="d-flex"><input type="number"
                                            class="form-control w-25 mr-5 mb-3"
                                            id="margin-slimit-buy-sprice"
                                            placeholder="Stop Price">
                                        <input type="number"
                                            class="form-control w-25 mb-3"
                                            id="margin-slimit-sell-sprice"
                                            placeholder="Stop Price">
                                    </div>
                                    <div class="d-flex"><input type="number"
                                            class="form-control w-25 mr-5 mb-3"
                                            id="margin-slimit-buy-price"
                                            placeholder="Price">
                                        <input type="number"
                                            class="form-control w-25 mb-3"
                                            id="margin-slimit-sell-price"
                                            placeholder="Price">
                                    </div>
                                    <div class="d-flex">
                                        <input type="number"
                                            class="form-control w-25 mr-5"
                                            id="margin-slimit-buy-amount"
                                            placeholder="Amount">
                                        <input type="number"
                                            class="form-control w-25"
                                            id="margin-slimit-sell-amount"
                                            placeholder="Amount">
                                    </div>
                                </div>
                                <div class="tab-pane fade p-2 pl-4"
                                    id="margin-smarket-tabs"
                                    role="tabpanel"
                                    aria-labelledby="margin-smarket-tab">
                                    <div class="d-flex"><input type="number"
                                            class="form-control w-25 mr-5 mb-3"
                                            id="margin-smarket-buy-sprice"
                                            placeholder="Stop Price">
                                        <input type="number"
                                            class="form-control w-25 mb-3"
                                            id="margin-smarket-sell-sprice"
                                            placeholder="Stop Price">
                                    </div>
                                    <div class="d-flex"><input type="text"
                                            class="form-control w-25 mr-5 mb-3"
                                            placeholder="Best Market Price"
                                            disabled>
                                        <input type="text"
                                            class="form-control w-25 mr-5 mb-3"
                                            placeholder="Best Market Price"
                                            disabled>
                                    </div>
                                    <div class="d-flex">
                                        <input type="number"
                                            class="form-control w-25 mr-5"
                                            id="margin-smarket-buy-amount"
                                            placeholder="Amount">
                                        <input type="number"
                                            class="form-control w-25"
                                            id="margin-smarket-sell-amount"
                                            placeholder="Amount">
                                    </div>
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
            <!-- Sub accounts Column -->

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
                        <form method="POST"
                            action="{{ url('home/transfer') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Direction</label>
                                    <div class="d-flex">
                                        <select class="form-control"
                                            id="from_account"
                                            name="from_account"
                                            required>
                                            <option value="MAIN">Main Account</option>
                                            <option value="TRADE">Trading Account</option>
                                            <option value="MARGIN">Margin Account</option>
                                        </select>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            width="16"
                                            height="16"
                                            fill="currentColor"
                                            class="bi bi-arrow-right w-25 mt-auto m-auto"
                                            viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z" />
                                        </svg>
                                        <select class="form-control"
                                            id="to_account"
                                            name="to_account"
                                            required>
                                            <option value="MAIN">Main Account</option>
                                            <option value="TRADE">Trading Account</option>
                                            <option value="MARGIN">Margin Account</option>
                                            <option value="FUTURES">Futures Account</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="coin">Coin</label>
                                    <select class="form-control"
                                        id="coin"
                                        name="coin">
                                        <option value="TETHER">TETHER</option>
                                        <option value="THETA">THETA</option>
                                    </select>
                                </div>
                                <p id="error_msg"
                                    class="text-danger text-center"></p>
                                <div class="form-group">
                                    <div class="row pl-3 pr-3">
                                        <label>Amount</label>
                                        <label class="ml-auto">Available Amount: <span class="text-primary"
                                                id="transfer_available">0<span></label>
                                    </div>
                                    <div class="input-group">
                                        <input type="number"
                                            class="form-control"
                                            id="transfer_amount"
                                            name="transfer_amount"
                                            required>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"
                                                id="transfer_amount_prepend">USDT</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit"
                                    class="btn btn-success w-100">Confirm</button>
                            </div>
                        </form>
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
                        <form method="POST"
                            action="{{ url('home/transfer') }}">
                            @csrf
                            <div class="modal-body">

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="daily-rate">Max Daily Interest Rate (No limit if left
                                                empty)</label>
                                            <div class="input-group">
                                                <input type="number"
                                                    class="form-control"
                                                    id="daily-rate"
                                                    step="any"
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
                                                <label class="ml-auto">Available Amount: <span
                                                        class="text-primary">0<span></label>
                                            </div>
                                            <div class="input-group">
                                                <input type="number"
                                                    class="form-control"
                                                    id="borrow-amount"
                                                    step="any"
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
                                                        type="checkbox"
                                                        name="term-7"
                                                        id="term-7"
                                                        value="7">
                                                    <label class="form-check-label"
                                                        for="term-7">
                                                        7 Days
                                                    </label>
                                                </div>
                                                <div class="form-check col-lg-4">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        name="term-14"
                                                        id="term-14"
                                                        value="14">
                                                    <label class="form-check-label"
                                                        for="term-14">
                                                        14 Days
                                                    </label>
                                                </div>
                                                <div class="form-check col-lg-4">
                                                    <input class="form-check-input"
                                                        type="checkbox"
                                                        name="term-28"
                                                        id="term-28"
                                                        value="28">
                                                    <label class="form-check-label"
                                                        for="term-28">
                                                        28 Days
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="target-rate">Target(%)</label>
                                            <div class='d-flex'>
                                                <input type="number"
                                                    class="form-control"
                                                    id="target-rate">
                                                <button type="button"
                                                    class="btn btn-secondary ml-4"
                                                    id="calc_target_btn">Calculate</button>
                                            </div>
                                        </div>
                                        <div id="seed_borrow_div">
                                            <!-- <div class='w-50 ml-auto mr-auto'>
                                                <div class="d-flex">
                                                    <div>SEED amount</div>
                                                    <div class="ml-auto">
                                                        <span class="currency">$</span>
                                                        <span id="seed_amt"></span>
                                                    </div>
                                                </div>
                                                <div class="d-flex">
                                                    <div>BORROW amount</div>
                                                    <div class="ml-auto">
                                                        <span class="currency">$</span>
                                                        <span id="borrow_amt"></span>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit"
                                    class="btn btn-success w-100">Borrow USDT</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endsection

        @section('script')

        @include('scripts.home-js')

        @endsection