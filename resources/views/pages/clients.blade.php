@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#shtoKlient" class="btn btn-success btn-sm" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shto +</a>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Emri</th>
                        <th>Adresa</th>
                        <th>Numri tel</th>
                        <th>Pershkrimi</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="carProductsBody">
                    @foreach($clients as $client)
                        <tr>
                            <td>{{$client->id}}</td>
                            <td>{{$client->emri}}</td>
                            <td>{{$client->adressa}}</td>
                            <td>{{$client->phone}}</td>
                            <td>{{$client->pershkrimi}}</td>
                            <td>
                                <p style="text-align: center">
                                    <a href="#" id="" data-id="{{$client->id}}" class="btn btn-success btn-sm clientProduct">Shiko</a>
                                    <a href="#" class="btn btn-cyan btn-sm edit_client" data-id="{{$client->id}}" data-toggle="modal" data-target="#editoKlient">Edito</a>
                                    <a href="{{route('delete_client', ['id' => $client->id])}}" class="btn btn-danger btn-sm" onclick="return delete_product('Klient');">Fshi</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Emri</th>
                        <th>Adresa</th>
                        <th>Numri tel</th>
                        <th>Pershkrimi</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shtoKlient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Klient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('add_client')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Emri</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="client_name" name="emri" placeholder="Emri">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Adresa</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="client_adresa" name="adressa" placeholder="Adresa">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Nr Tel</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="client_phone" name="phone" placeholder="Nr Tel">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Pershkrimi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" id="client_pershkrimi" name="pershkrimi" placeholder="Pershkrimi"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Produktet</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="4" id="client_products" name="produktet" placeholder="Produktet"></textarea>
                                    <span style="font-size: 12px;color: red;">*mbas cdo produkti vendosi presie (,) qe ta njohi sistemi</span>
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

    <div class="modal fade" id="editoKlient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Klient</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('edit_client')}}" method="post">
                        @csrf
                        <input type="hidden" id="client_id" name="id">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Emri</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_client_name" name="emri" placeholder="Emri">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Adresa</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_client_adresa" name="adressa" placeholder="Adresa">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Nr Tel</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_client_phone" name="phone" placeholder="Nr Tel">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Pershkrimi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" id="edit_client_pershkrimi" name="pershkrimi" placeholder="Pershkrimi"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Produktet</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="4" id="edit_client_products" name="produktet" placeholder="Produktet"></textarea>
                                    <span style="font-size: 12px;color: red;">*mbas cdo produkti vendosi presie (,) qe ta njohi sistemi</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Edito</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="clientProducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Produktet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody id="clientProductsBody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
