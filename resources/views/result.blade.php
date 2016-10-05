<span class="label label-success">Rezultatas</span>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>
                <div class="result text-center" {!!((strlen($model->input) + strlen($model->output)) > 14) ? 'style="font-size: 18px;"' : '' !!}>
                    <span>{{$model->input}}<small>{{$model->input_type}}</small></span> = <span>{{$model->output}}<small>{{$model->output_type}}</small></span>
                </div>
            </th>
            <th>Skaičius</th>
            <th>Skaičiavimo sistema</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>Pradinis</th>
            <td>{{$model->input}}</td>
            <td>{{$model->input_type}}</td>
        </tr>
        <tr>
            <th>Konvertuotas</th>
            <td><b>{{$model->output}}</b></td>
            <td>{{$model->output_type}}</td>
        </tr>
    </tbody>
</table>

<br><br><br>

