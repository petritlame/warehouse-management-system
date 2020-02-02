@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Kategoria: {{ucfirst($category)}}</h5>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#Modal2" class="btn btn-success btn-sm" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shto +</a>
            <h4 style="float: right;">Vlera totale: <b id="totalShitje">{{$vlera}}</b></h4>
            <h4 style="float: right; margin-right: 70px;">Vlera totale e {{ucfirst($category)}}: <b>{{$shuma}}</b></h4>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Emertimi</th>
                        <th>Sasia</th>
                        <th>Cmimi Blerjes</th>
                        <th>Cmimi Shitje</th>
                        <th>Vlera Blerje</th>
                        <th>Vlera Shitje</th>
                        <th>Diferenca</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{$product->emri}}</td>
                            <td>{{$product->sasia}}</td>
                            <td>{{$product->cmim_blerje}}</td>
                            <td>{{$product->cmim_shitje}}</td>
                            <td>{{$product->vlera_blerje}}</td>
                            <td>{{$product->vlera_shitje}}</td>
                            <td>{{($product->vlera_shitje) - ($product->vlera_blerje)}}</td>
                            <td>
                                <p style="text-align: center">
                                    <a href="#" class="btn btn-cyan btn-sm edit_product" data-id="{{$product->id}}" data-toggle="modal" data-target="#Modal3">Edito</a>
                                    <a href="{{route('delete_product', ['id' => $product->id])}}" class="btn btn-danger btn-sm" onclick="return delete_product('produkt');">Fshi</a>
                                </p>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Emertimi</th>
                        <th>Sasia</th>
                        <th>Cmimi Blerjes</th>
                        <th>Cmimi Shitje</th>
                        <th>Vlera Blerje</th>
                        <th>Vlera Shitje</th>
                        <th>Diferenca</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Produkt ne Magazine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('add_product')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Emertimi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="emertimi" name="emertimi" placeholder="Emertimi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Sasia</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="sasia" name="sasia" placeholder="Sasia">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Cmimi Blerje</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="cmim_blerje" name="cmim_blerje" placeholder="Cmimi Blerje">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Cmim Shitje</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="cmim_shitje" name="cmim_shitje" placeholder="Cmim Shitje">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Vlera Shitje</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="kategoria" name="category_id">
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->emertimi}}</option>
                                        @endforeach
                                    </select>
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

    <div class="modal fade" id="Modal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ndrysho Produktin ne Magazine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('update_product')}}" method="post">
                        @csrf
                        <input type="hidden" id="product_id" name="id">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Emertimi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_emertimi" name="emertimi" placeholder="Emertimi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Sasia</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" id="edit_sasia" name="sasia" placeholder="Sasia">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Cmimi Blerje</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="edit_cmim_blerje" name="cmim_blerje" placeholder="Cmimi Blerje">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Cmim Shitje</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="edit_cmim_shitje" name="cmim_shitje" placeholder="Cmim Shitje">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Vlera Shitje</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="edit_kategoria" name="category_id">
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->emertimi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ndrysho</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
