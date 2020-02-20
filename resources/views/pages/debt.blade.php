@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-body">
            <a href="javascript:void(0)" data-toggle="modal" data-target="#shtoBorxh" class="btn btn-success btn-sm" style="margin-left: 10px;margin-bottom: 20px;margin-top: 6px;">Shto +</a>
            <h4 style="float: right">Borxhi OUT Total: <b>{{$totalDebtOut}}</b></h4>
            <h4 style="float: right; padding-right: 20px;">Borxhi IN Total: <b>{{$totalDebtIn}}</b></h4>
            <div class="table-responsive">
                <table id="zero_config" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pershkrimi</th>
                        <th>Vlera</th>
                        <th>Data</th>
                        <th>Statusi</th>
                        <th>Statusi</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="carProductsBody">
                    @foreach($debts as $debt)
                        <tr>
                            <td>{{$debt->id}}</td>
                            <td>{{($debt->pershkrimi) ? $debt->pershkrimi : 'Pa Pershkrim'}}</td>
                            <td>{{$debt->value}}</td>
                            <td>{{$debt->created_at}}</td>
                            <td style="{{($debt->type == 0) ? 'background-color: #ff00006b' : 'background-color: #00ca0052'}}">{{($debt->type == 0) ? 'Borxh OUT' : 'Borxh IN'}}</td>
                            <td style="{{($debt->status == 0) ? 'color: red' : 'color: green    '}}">{{($debt->status == 0) ? 'Jo Shqlyer' : 'Shqlyer'}}</td>
                            <td>
                                <p style="text-align: center">
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#hiqBorxh" data-id="{{$debt->id}}" class="btn btn-cyan btn-sm hiqBorxh_button">Ndrysho</a>
                                    <a href="{{route('delete_debt', ['id'=>$debt->id])}}" class="btn btn-danger btn-sm" onclick="return delete_product('Borxh');">Fshi</a>
                                </p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Pershkrimi</th>
                        <th>Vlera</th>
                        <th>Data</th>
                        <th>Statusi</th>
                        <th>Statusi</th>
                        <th></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="shtoBorxh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Borxh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('add_debt')}}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Vlera</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="debt_value" name="value" placeholder="Vlera">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Pershkrimi</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" id="debt_pershkrimi" name="pershkrimi" placeholder="Pershkrimi"></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Tipi</label>
                                <div class="col-sm-9">
                                   <select class="form-control" name="type">
                                       <option selected disabled>Zgjidh Tipin</option>
                                       <option style="background-color: #00ca0052" value="1">IN</option>
                                       <option style="background-color: #ff00006b" value="0">OUT</option>
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

    <div class="modal fade" id="hiqBorxh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Shto Borxh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('remove_debt')}}" method="post">
                        @csrf
                        <input type="hidden" name="id" id="debt_id">
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Vlera</label>
                                <div class="col-sm-9">
                                    <input type="number" step="0.01" class="form-control" id="debt_value" name="value" placeholder="Vlera">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-sm-3 text-right control-label col-form-label">Tipi</label>
                                <div class="col-sm-9">
                                    <select class="form-control" name="type">
                                        <option selected disabled>Zgjidh Veprimin</option>
                                        <option style="background-color: #00ca0052" value="1">Shto</option>
                                        <option style="background-color: #ff00006b" value="0">Hiq</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Ndrysho Borxh</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Mbyll</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
