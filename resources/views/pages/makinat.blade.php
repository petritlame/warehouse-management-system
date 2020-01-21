@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#shtoMakine" class="btn btn-success btn-sm" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shto +</a>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Targa</th>
                        <th>Sqarim</th>
                        <th>Agjenti</th>
                        <th>Data Krijimit</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($makinat as $makina)
                        <tr>
                            <td>{{$makina->id}}</td>
                            <td>{{$makina->targa}}</td>
                            <td>{{$makina->sqarim}}</td>
                            <td>{{$makina->emri}} {{$makina->mbiemri}}</td>
                            <td>{{$makina->created_at}}</td>
                            <td>
                                <p style="text-align: center">
                                    <a href="{{route('delete_makina', ['id' => $makina->id])}}" class="btn btn-danger btn-sm" onclick="return delete_product('makine');">Fshi</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Targa</th>
                        <th>Sqarim</th>
                        <th>Agjenti</th>
                        <th>Data Krijimit</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="shtoMakine" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Makine te re</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('add_makina')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Targa</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="targa" id="targa" placeholder="Targa">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Sqarim</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="sqarim" name="sqarim" placeholder="Sqarim">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="address" class="col-sm-3 text-right control-label col-form-label">Agjenti</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="agent_id">
                                        <option disabled selected>Zgjidh Agjentin</option>
                                        @foreach($agents as $agent)
                                            <option value="{{$agent->id}}">{{$agent->emri}} {{$agent->mbiemri}}</option>
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
@endsection
