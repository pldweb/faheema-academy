<form id="form-photo" enctype="multipart/form-data" onsubmit="return false">
    <div class="mb-3 text-center">
        <img id="preview-photo" src="{{img_url($user->photo)}}" style="width:130px;height:130px;object-fit:cover;border-radius:10px;margin-top:10px;">
    </div>
    <div class="mb-3">
        <label for="photo">Photo (max 1mb)</label>
        <div class="input-group">
            <input type="file" name="photo" class="form-control" id="inputGroupFile02">
            <label class="input-group-text" for="inputGroupFile02">Upload</label>
        </div>
    </div>

    <input type="hidden" name="id" value="{{$user->id}}">
    <button type="submit" class="btn btn-primary">Simpan Photo Profile</button>
</form>
<script>
    $(document).ready(function() {
        $("#form-photo").submit(function(event) {
            event.preventDefault();
            let formData = new FormData(this);
            confirmModal("Apakah photo sudah benar?", function (){
                ajxProcess("/admin/profile/simpan-photo", formData, '#message-modal')
            })
        })
    })

    $(document).on('change', '#inputGroupFile02', function(event) {
        let file = event.target.files[0];
        if (!file) return;

        let reader = new FileReader();

        reader.onload = function(e) {
            $('#preview-photo').attr('src', e.target.result);
        }

        reader.readAsDataURL(file);
    });

</script>
