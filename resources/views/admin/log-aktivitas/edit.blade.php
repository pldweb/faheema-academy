<form action="">
    <div class="form-group row mb-3">
        <label for="" class="col-sm-3 ">Aksi</label>
        <div class="col-sm-9">
            <div class="data-form max-500">{{$data->aksi}}</div>
        </div>
    </div>
    <div class="form-group row mb-3">
        <label for="" class="col-sm-3 ">Waktu</label>
        <div class="col-sm-9">
            <div class="data-form">{{$data->display_waktu}} WIB</div>
        </div>
    </div>
    <div class="form-group row mb-3">
        <label for="" class="col-sm-3 ">IP Address</label>
        <div class="col-sm-9">
            <div class="data-form">{{$data->ip_address}}</div>
        </div>
    </div>
    <div class="form-group row">
        <label for="" class="col-sm-3 ">User Agent</label>
        <div class="col-sm-9">
            <div class="data-form">{{$data->user_agent}}</div>
        </div>
    </div>
</form>
