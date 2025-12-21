<form id="updateRole" method="POST" onsubmit="return false;">
    <input type="hidden" name="id" value="{{ $role->id }}">

    <div class="mb-3">
        <label for="name" class="form-label">Nama Role</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $role->name }}" required>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <label class="form-label fw-bold m-0">Update Hak Akses:</label>

        {{-- TOMBOL PILIH SEMUA --}}
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
                                <input class="form-check-input permission-item" type="checkbox"
                                       name="permissions[]"
                                       value="{{ $perm->name }}"
                                       id="perm_{{ $perm->id }}"
                                    {{ in_array($perm->name, $rolePermissions) ? 'checked' : '' }}>

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
        <button type="submit" class="btn btn-primary">Update Role</button>
    </div>
</form>

<script>
    // 1. Cek status awal (Apakah semua kotak sudah tercentang?)
    // Jumlah total checkbox
    var totalCheckbox = $('.permission-item').length;
    // Jumlah yang dicentang
    var totalChecked = $('.permission-item:checked').length;

    // Kalau jumlahnya sama, nyalakan switch Select All
    if(totalCheckbox === totalChecked) {
        $('#checkAll').prop('checked', true);
    }

    // 2. Logic Klik Select All
    $('#checkAll').change(function() {
        const isChecked = $(this).is(':checked');
        $('.permission-item').prop('checked', isChecked);
    });

    // 3. Logic: Kalau salah satu di-uncheck manual, matikan Select All
    $('.permission-item').change(function() {
        if(false === $(this).prop('checked')) {
            $('#checkAll').prop('checked', false);
        }
        // Kalau user manual centang satu-satu sampai penuh, nyalakan Select All
        if ($('.permission-item:checked').length === $('.permission-item').length) {
            $('#checkAll').prop('checked', true);
        }
    });

    // 4. Submit
    $('#updateRole').submit(function (e){
        e.preventDefault();
        const currentForm = this;
        confirmModal('Update data role ini?', function (){
            let formData = new FormData(currentForm);
            ajxProcess('/admin/role/simpan-data', formData, '#message-modal' )
        })
    });
</script>
