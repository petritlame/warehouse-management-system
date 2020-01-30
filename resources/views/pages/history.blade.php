@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h4 style="float: right">Total: <b></b></h4>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Totali</th>
                        <th>Fatura</th>
                    </tr>
                    </thead>
                    <tbody id="carProductsBody">
                    @foreach($histories as $history)
                        <tr>
                            <td>{{$history->id}}</td>
                            <td>{{$history->data}}</td>
                            <td>{{$history->total}}</td>
                            <td><a href="{{asset('invoices/store')}}/{{$history->invoice}}" target="_blank">{{$history->invoice}}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Totali</th>
                        <th>Fatura</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    @endsection
