<form id="simpanData" enctype="multipart/form-data" method="POST" onsubmit="return false;">
    <div class="mb-3">
        <label for="kategori-produk" class="form-label required">Nama Kategori Buku</label>
        <input type="text" class="form-control" id="kategori-produk" name="kategori-produk">
    </div>
    <button type="submit" class="btn btn-primary w-25%">Simpan Data Kategori Buku</button>
</form>

<script>
    $('#simpanData').submit(function (e){
        e.preventDefault();
        const currentForm = this;
        confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
            let formData = new FormData(currentForm);
            ajxProcess('/admin/kategori-produk/simpan-data', formData, '#message-modal' )
        })
    });
</script>
