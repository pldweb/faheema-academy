<form id="simpanData" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" id="nama" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="email" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Role / Hak Akses</label>
        <select class="form-select" name="role" id="role" required>
            <option value="">-- Pilih Role --</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}">{{ $role->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>
    <button type="submit" class="btn btn-primary w-25%">Simpan Data User</button>
</form>
<script>
    $('#simpanData').submit(function (e){
        e.preventDefault();
        const currentForm = this;
        confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
            let formData = new FormData(currentForm);
            ajxProcess('/admin/user/simpan-data', formData, '#message-modal' )
        })
    });
</script>
