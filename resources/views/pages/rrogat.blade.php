@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#shtoRroga" class="btn btn-success btn-sm" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shto +</a>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Punonjesi</th>
                        <th>Vlera</th>
                        <th>Data</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="carProductsBody">
                    @foreach($rrogat as $rroga)
                        <tr>
                            <td>{{$rroga->id}}</td>
                            <td>{{$rroga->punonjesi}}</td>
                            <td>{{$rroga->shuma}}</td>
                            <td>{{$rroga->data}}</td>
                            <td>
                                <p style="text-align: center">
                                    <a href="{{route('delete_rroga', ['id' => $rroga->id])}}" class="btn btn-danger btn-sm" onclick="return delete_product('Rroge');">Fshi</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Punonjesi</th>
                        <th>Vlera</th>
                        <th>Data</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shtoRroga" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Rroge</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('add_rroga')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Punonjesi</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rroga_punonjesi" name="punonjesi" placeholder="Punonjesi">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Shuma</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="rroga_shuma" name="shuma" placeholder="Shuma">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Data</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="rroga_data" name="data" placeholder="Data">
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
