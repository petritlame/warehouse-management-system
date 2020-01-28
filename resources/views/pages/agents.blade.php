@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">

            <a href="javascript:void(0)" data-toggle="modal" data-target="#shtoAgent" class="btn btn-success btn-sm" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shto +</a>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Emri</th>
                        <th>Mbiemri</th>
                        <th>Data Rregjistrimit</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($agents as $agent)
                        <tr>
                            <td>{{$agent->id}}</td>
                            <td>{{$agent->emri}}</td>
                            <td>{{$agent->mbiemri}}</td>
                            <td>{{$agent->created_at}}</td>
                           <td>
                                <p style="text-align: center">
                                    <a href="{{route('singleAgent', ['id' => $agent->id])}}" class="btn btn-success btn-sm show_agent">Shiko</a>
                                    <a href="#" class="btn btn-cyan btn-sm edit_agent" data-id="{{$agent->id}}" data-toggle="modal" data-target="#ndryshoAgent">Edito</a>
                                    <a href="{{route('delete_agent', ['id' => $agent->id])}}" class="btn btn-danger btn-sm" onclick="return delete_product('agjent');">Fshi</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Emri</th>
                        <th>Mbiemri</th>
                        <th>Data Rregjistrimit</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shtoAgent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Agjent te ri</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('add_agent')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Emri</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="emri" id="emri" placeholder="Emri">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Mbiemri</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="mbiemri" name="mbiemri" placeholder="Mbiemri">
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

    <div class="modal fade" id="ndryshoAgent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ndrysho Agjentin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('update_agent')}}" method="post">
                        @csrf
                        <input type="hidden" id="adent_id" name="id">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Emri</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="emri" id="edit_emri" placeholder="Emri">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Mbiemri</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_mbiemri" name="mbiemri" placeholder="Mbiemri">
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
