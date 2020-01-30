@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="{{route('generateInvoiceStore')}}" target="_blank" class="btn btn-success btn-sm {{($products->count() == 0) ? 'disabled' : ''}}" id="generateSaleInvoice" style="position: absolute;left: 95px;top: 26px;">Gjenero Fature</a>
            <a href="{{route('history')}}" class="btn btn-success btn-sm" id="history" style="position: absolute;left: 200px;top: 26px;">Historiku</a>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#shtoDyqani" class="btn btn-success btn-sm" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shto +</a>
            <h4 style="float: right">Cmimi Total: <b>{{$totali}}</b></h4>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produkti</th>
                        <th>Cmimi per njesi</th>
                        <th>Sasia</th>
                        <th>Totoal</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="carProductsBody">
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->cmimi}}</td>
                            <td>{{$product->sasia}}</td>
                            <td>{{$product->total}}</td>
                            <td>
                                <p style="text-align: center">
                                    <a href="{{route('hiqProdukt', ['id' => $product->id])}}" class="btn btn-danger btn-sm" onclick="return delete_product('produkt');">Hiqe</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Produkti</th>
                        <th>Cmimi per njesi</th>
                        <th>Sasia</th>
                        <th>Totoal</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shtoDyqani" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Shto Kategori</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="{{route('add_dyqani')}}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="address" class="col-sm-3 text-right control-label col-form-label">Kategoria</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="category_id" id="dyqani_category_select">
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
                                <select class="form-control" name="product_id" id="product_select_dyqani">
                                    <option disabled selected>Zgjidh Produktin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 text-right control-label col-form-label">Sasia</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="dyqani_sasia" name="sasia" placeholder="Sasia">
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
@endsection
