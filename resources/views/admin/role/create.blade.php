<form id="simpanRole" method="POST" onsubmit="return false;">
    {{-- Input Nama Role --}}
    <div class="mb-3">
        <label for="name" class="form-label">Nama Role</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Contoh: Administrator" required>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <label class="form-label fw-bold m-0">Pilih Hak Akses (Permission):</label>

        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="checkAll">
            <label class="form-check-label fw-bold text-primary" for="checkAll">Pilih Semua</label>
        </div>
    </div>

    <div class="row" style="max-height: 400px; overflow-y: auto;">
        @foreach($permissions as $group => $perms)
            <div class="col-md-6 mb-3">
                <div class="card h-100 border-light bg-light">
                    <div class="card-header py-1 fw-bold text-uppercase text-primary" style="font-size: 0.8rem">
                        {{ $group }}
                    </div>
                    <div class="card-body p-2">
                        @foreach($perms as $perm)
                            <div class="form-check">
                                {{-- Class 'permission-item' ditambahkan untuk memudahkan selector JS --}}
                                <input class="form-check-input permission-item" type="checkbox"
                                       name="permissions[]"
                                       value="{{ $perm->name }}"
                                       id="perm_{{ $perm->id }}">

                                <label class="form-check-label" for="perm_{{ $perm->id }}" style="font-size: 0.9rem">
                                    {{ explode('.', $perm->name)[1] ?? $perm->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3 text-end">
        <button type="submit" class="btn btn-primary">Simpan Role</button>
    </div>
</form>

<script>
    $('#checkAll').change(function() {
        const isChecked = $(this).is(':checked');
        $('.permission-item').prop('checked', isChecked);
    });

    $('#simpanRole').submit(function (e){
        e.preventDefault();
        const currentForm = this;
        confirmModal('Simpan role dan permission ini?', function (){
            let formData = new FormData(currentForm);
            ajxProcess('/admin/role/simpan-data', formData, '#message-modal' )
        })
    });
</script>
