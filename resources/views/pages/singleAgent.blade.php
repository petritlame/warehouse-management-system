@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{$agentName}}</h5>
            @if(Auth::user()->type == 1)
            <a href="{{route('generateAgentInvoice', ['id' => $agent_id])}}" class="btn btn-success btn-sm {{ ($invoiceItem->count() > 0) ? '' : 'disabled' }}" id="generateAgentInvoice" style="position: absolute;left: 200px;top: 55px;">Gjenero Fature</a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#withoutInvoice" class="btn btn-cyan btn-sm {{ ($invoiceItem->count() > 0) ? '' : 'disabled' }}" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shiko Produktet pa fature</a>
                <div class="form-group row" style="width: 20%;position: absolute;left: 315px;top: 51px;">
                    <label for="name" class="col-sm-3 text-right control-label col-form-label">Data</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control agenti_data" name="start_date" id="agent_start_date" placeholder="Data nga">
                    </div>
                </div>
                <div class="form-group row" style="width: 20%;position: absolute; left: 525px;top: 51px;">
                    <div class="col-sm-9">
                        <input type="text" class="form-control agenti_data" name="end_date" id="agent_end_date" placeholder="Data deri me">
                    </div>
                </div>
            <input type="hidden" value="{{$agent_id}}" id="agent_id">
                <a href="#" class="btn btn-cyan btn-sm" id="submit_date_search" style="margin-left: 500px;margin-bottom: 20px;margin-top: 6px; position: absolute">Kerko</a>
            @endif
            <h4 style="float: right">Total Shitjet: <b id="totalShitje">{{$agentTotal}}</b></h4>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Fatura</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody id="agent_sales">
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{$invoice->id}}</td>
                            <td>{{$invoice->data}}</td>
                            <td><a href="{{asset('invoices/salesInvoices/')}}/{{$invoice->invoice}}" target="_blank">{{$invoice->invoice}}</a></td>
                            <td><b>{{$invoice->total}}</b></td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Fatura</th>
                        <th>Total</th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="withoutInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Produktet e shituar te pa faturuara</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Produkti</th>
                            <th scope="col">Sasia</th>
                            <th scope="col">Cmim Shitje</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($invoiceItem->count() > 0)
                        @foreach($invoiceItem as $item)
                        <tr>
                            <td>{{$item->data}}</td>
                            <td>{{$item->product_name}}</td>
                            <td>{{$item->sasia}}</td>
                            <td>{{$item->cmim_shitje}}</td>
                            <td>{{$item->total}}</td>
                        </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endsection
