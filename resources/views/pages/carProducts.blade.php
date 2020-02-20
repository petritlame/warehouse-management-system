@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
           <select class="form-control" style="width: 20%;position: absolute;left: 165px;top: 20px;" id="makina" name="makina">
                <option value="" selected disabled>Zgjidh Makinen</option>
                @foreach($makinat as $makina)
                    <option value="{{$makina->id}}">{{$makina->targa}} - {{$makina->emri}}</option>
                @endforeach
            </select>
            <select class="form-control" style="width: 20%;position: absolute;left: 400px;top: 20px;" id="invoiceDate" name="invoiceDate">
                <option value="" selected disabled>Zgjidh Daten</option>
                @foreach($dates as $date)
                    <option value="{{$date->data}}">{{$date->data}}</option>
                @endforeach
            </select>
            <a href="javascript:void(0)" class="btn btn-success btn-sm disabled" id="generateInvoice" data-toggle="modal" data-target="#generate" style="position: absolute;left: 630px;top: 23px;">Gjenero Fature</a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#shtoProdukt" class="btn btn-success btn-sm" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shto +</a>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Produkti</th>
                        <th>Makina ID</th>
                        <th>Agjenti</th>
                        <th>Sasia</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="carProductsBody">
                    @foreach($carProducts as $carProduct)
                        <tr>
                            <td>{{$carProduct->id}}</td>
                            <td>{{$carProduct->data}}</td>
                            <td>{{$carProduct->emertimi}}</td>
                            <td>{{$carProduct->targa}}</td>
                            <td>{{$carProduct->emri}} {{$carProduct->mbiemri}}</td>
                            <td>{{$carProduct->sasia}}</td>
                            <td>
                                <p style="text-align: center">
                                    <a href="#" class="btn btn-cyan btn-sm shto_ne_makine" data-id="{{$carProduct->id}},{{$carProduct->product_id}}" data-toggle="modal" data-target="#carProductAdd">+</a>
                                    <a href="#" class="btn btn-cyan btn-sm hiq_nga_makine" data-id="{{$carProduct->id}},{{$carProduct->product_id}}" data-toggle="modal" data-target="#carProductRemove">-</a>
                                    <a href="#" class="btn btn-success btn-sm dalje dalje_invoices" id="dalje_invoice" data-id="{{$carProduct->id}}" data-toggle="modal" data-target="#carPassToInvoice">Dalje</a>
                                    <a href="{{route('delete_products', ['id' => $carProduct->id])}}" class="btn btn-danger btn-sm" onclick="return delete_product('produkt');">Hiqe</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Produkti</th>
                        <th>Makina ID</th>
                        <th>Agjenti</th>
                        <th>Sasia</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shtoProdukt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Produkt ne Makine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('add_products')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Data</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control data_arka" name="makina_data" id="makina_data" placeholder="dd/mm/yyyy">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Kategoria</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="category_id" id="category_select">
                                        <option disabled selected>Zgjidh Kategorine</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->emertimi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Produkti</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="product_id" id="product_select">
                                        <option disabled selected>Zgjidh Produktin</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Makinen</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="makina_id" id="makina_select">
                                        <option disabled selected>Zgjidh Makinen</option>
                                        @foreach($makinat as $makina)
                                            <option value="{{$makina->id}}">{{$makina->targa}} - {{$makina->emri}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Sasia</label>
                                <div class="col-sm-9">
                                    <input type="number" value="0" step="0.01" class="form-control" id="sasia" name="sasia" placeholder="Sasia">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Shto</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="carProductAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Produkt ne Makine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('update_products')}}" method="post">
                        @csrf
                        <input type="hidden" id="shto_product_id" name="shto_product_id">
                        <input type="hidden" id="shto_item_id" name="shto_item_id">
                        <input type="hidden" id="type" name="type" value="in">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Sasia</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="sasia_plus" name="sasia_plus" placeholder="Sasia">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Shto</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="carProductRemove" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hiq Produkt nga Makina</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('update_products')}}" method="post">
                        @csrf
                        <input type="hidden" id="hiq_product_id" name="hiq_product_id">
                        <input type="hidden" id="hiq_item_id" name="hiq_item_id">
                        <input type="hidden" id="type" name="type" value="out">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Sasia</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="sasia_min" name="sasia_min" placeholder="Sasia">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Hiq</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="carPassToInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Produktin si te shitur</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('addInvoiceItem')}}" method="post">
                        @csrf
                        <input type="hidden" id="product_invoice" name="product_id">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Sasia</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="sasia" name="sasia" placeholder="Sasia">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Shto</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
