@extends('main_layout')


@section('content')

    <h1 class="uc">Upload dictionary</h1>


    <p>Allowed file format - <b>.csv</b></p>

    <p>Allowed format (<span class="text-muted">State: 0 - new, 1 - to study, 2 - known</span>):</p>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th scope="col">Word</th>
            <th scope="col">Translation</th>
            <th scope="col">State</th>
        </tr>
        </thead>
        <tbody>

        <tr>
            <td>Apple</td>
            <td>Яблоко</td>
            <td>0</td>
        </tr>

        <tr>
            <td>Language</td>
            <td>Язык</td>
            <td>1</td>
        </tr>

        <tr>
            <td>Order</td>
            <td>Заказ, заказывать</td>
            <td>2</td>
        </tr>

        </tbody>
    </table>



    <p><b>P.S.</b> You may upload explanatory dictionary.</p>
    <p><b>P.P.S.</b> First row (headers) is skipped.</p>
    <hr>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{route('words_upload')}}" method="POST" enctype="multipart/form-data">

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">File</label>
            <div class="col-sm-10">
                <div class="custom-file">
                    <label class="custom-file-label" for="text_file">Choose file</label>
                    <input type="file" class="custom-file-input" name="text_file" id="text_file" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn w-100 btn-primary noradius"><b>UPLOAD</b></button>

    </form>



@endsection

