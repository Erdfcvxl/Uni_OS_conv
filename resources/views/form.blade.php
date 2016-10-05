
{!! Form::open() !!}

<div class="row">
    <div class="col-lg-4 form" style="margin-bottom: 60px;">
        <div type="button" class="step step-circle">1</div>
        {{ Form::label('input', 'Pradinis skaičius', ['class' => '']) }}
        {{ Form::text('input', isset($model->input)? $model->input : '' , ['class' => 'form-control']) }}

        <hr>

        <div type="button" class="step step-circle">2</div>
        {{ Form::label('type', 'Pradinė skaičiavimo sistema') }}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>2-tainė</td>
                    <td>8-tainė</td>
                    <td>10-tainė</td>
                    <td>16-tainė</td>
                </tr>
            </thead>
            <tr>
                <td>{{ Form::radio('type', '2', (isset($i) && $i == 2) ? true : false) }}</td>
                <td>{{ Form::radio('type', '8', (isset($i) && $i == 8) ? true : false) }}</td>
                <td>{{ Form::radio('type', '10', (isset($i) && $i == 10) ? true : false) }}</td>
                <td>{{ Form::radio('type', '16', (isset($i) && $i == 16) ? true : false) }}</td>
            </tr>
        </table>

        <hr>

        <div type="button" class="step step-circle">3</div>
        {{ Form::label('type', 'Išvesties skaičiavimo sistema') }}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>2-tainė</td>
                    <td>8-tainė</td>
                    <td>10-tainė</td>
                    <td>16-tainė</td>
                </tr>
            </thead>
            <tr>
                <td>{{ Form::radio('r_type', '2', (isset($o) && $o == 2) ? true : false) }}</td>
                <td>{{ Form::radio('r_type', '8', (isset($o) && $o == 8) ? true : false) }}</td>
                <td>{{ Form::radio('r_type', '10', (isset($o) && $o == 10) ? true : false) }}</td>
                <td>{{ Form::radio('r_type', '16', (isset($o) && $o == 16) ? true : false) }}</td>
            </tr>
        </table>

        <br><br>

        {{Form::button('<div type="button" class="step step-inside step-circle">4</div>Konvertuoti', ['type' => 'submit', 'style' => "position: relative;", 'class' => 'btn btn-primary btn-lg btn-block'])}}

        {!! Form::close() !!}

    </div>


    <div class="col-lg-8">

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (isset($model))
            @include('result')
        @endif

    </div>

</div>



