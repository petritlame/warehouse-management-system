@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <select class="form-control" style="width: 20%;position: absolute;left: 165px;top: 20px;" id="makina" name="makina">
                <option value="" selected disabled>Zgjidh Makinen</option>
            </select>
            <a href="javascript:void(0)" class="btn btn-success btn-sm" id="changeCar" style="position: absolute;left: 400px;top: 23px;">Ndrysho</a>
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
                        <th>Hyrjet</th>
                        <th>Daljet</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    {{--@foreach($records as $record)
                        <tr>
                            <td>{{$record->id}}</td>
                            <td>{{$record->data}}</td>
                            <td>{{$record->nr_arketimi}}</td>
                            <td>{{$record->nr_pagese}}</td>
                            <td>{{$record->shpjegmi}}</td>
                            <td style="background-color: #00ca0052">{{$record->hyrjet}}</td>
                            <td style="background-color: #ff00006b">{{($record->daljet)}}</td>
                        </tr>
                    @endforeach--}}
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Data</th>
                        <th>Produkti</th>
                        <th>Makina ID</th>
                        <th>Agjenti</th>
                        <th>Hyrjet</th>
                        <th>Daljet</th>
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
                    <form class="form-horizontal" action="{{route('add_makina')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Kategoria</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="agent_id">
                                        <option disabled selected>Zgjidh Kategorine</option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Produkti</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="agent_id">
                                        <option disabled selected>Zgjidh Produktin</option>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Makinen</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="agent_id">
                                        <option disabled selected>Zgjidh Makinen</option>
                                            <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Hyrjet</label>
                                <div class="col-sm-9">
                                    <input type="number" value="0.00" step="0.01" class="form-control" id="hyrjet" name="hyrjet" placeholder="Hyrjet">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Daljet</label>
                                <div class="col-sm-9">
                                    <input type="number" value="0.00" step="0.01" class="form-control" id="daljet" name="daljet" placeholder="Daljet">
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
                    <h5 class="modal-title" id="exampleModalLabel">Ndrysho Produktin ne Makine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="" method="post">
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
