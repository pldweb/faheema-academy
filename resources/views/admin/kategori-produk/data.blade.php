<table class="table align-items-center mb-0" id="dataTable">
    <thead class="thead-light">
    <tr>
        <th scope="col" class="text-start">No</th>
        <th scope="col">Nama Kategori Buku</th>
        <th scope="col" class="text-start">Opsi</th>
    </tr>
    </thead>
    <tbody id="tbody">
    @foreach ($data as $index => $item)
        <tr>
            <td class="text-start">{{$index + 1}}</td>
            <th scope="row">{{$item->nama}}</th>
            <td class="text-start d-flex column-gap-1">
                <button onclick="editData({{$item->id}}, '/admin/kategori-produk/edit-data')" class="btn btn-warning w-full">Edit</button>
                <button onclick="deleteData({{$item->id}}, '/admin/kategori-produk/delete-data', '#message-modal')" class="btn btn-danger w-full">Delete</button>
            </td>
    @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
