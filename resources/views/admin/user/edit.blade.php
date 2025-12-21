<form id="simpanData" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    {{-- Input Nama dll tetap sama --}}
    <div class="mb-3">
        <label for="user" class="form-label">Nama</label>
        <input type="text" class="form-control" id="user" name="nama" value="{{$data->nama}}">
    </div>
    <div class="mb-3">
        <label for="user" class="form-label">Email</label>
        <input type="text" class="form-control" id="user" name="email" value="{{$data->email}}">
    </div>

    {{-- TAMBAHAN: PILIH ROLE --}}
    <div class="mb-3">
        <label for="role" class="form-label">Role / Hak Akses</label>
        <select class="form-select" name="role" id="role" required>
            <option value="">-- Pilih Role --</option>
            @foreach($roles as $role)
                <option value="{{ $role->name }}"
                    {{-- Cek apakah user punya role ini? Jika ya, select --}}
                    {{ $data->hasRole($role->name) ? 'selected' : '' }}>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
    </div>
    {{-- END TAMBAHAN --}}

    <div class="mb-3">
        <label for="user" class="form-label">No Telp (+62)</label>
        <div class="input-group">
            <div class="input-group-text">+62</div>
            <input type="text" class="form-control" id="user" name="no_telp" value="{{$data->no_telp}}">
        </div>
    </div>
    <input type="hidden" class="form-control" id="id" name="id" value="{{$data->id}}">

    {{-- Tombol tetap sama --}}
    <button type="submit" class="btn btn-primary w-25%">Simpan Data User</button>
    <button onclick="editData({{$data->id}}, '/admin/user/edit-password', 'Edit Password')" class="btn btn-secondary w-25%">Edit Password User</button>
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
