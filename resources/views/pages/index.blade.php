@extends('layouts.app')
@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Kategoria: Detergjent</h5>
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
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>Test</td>
                        <td>5</td>
                        <td>10.2541</td>
                        <td>16.2541</td>
                        <td>51,2705</td>
                        <td>81,2705</td>
                        <td>30.000</td>
                    </tr>
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
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div>

@endsection
