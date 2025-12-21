<table class="table align-items-center mb-0" id="tableData">
    <thead class="thead-light">
    <tr>
        <th scope="col" class="text-start">No</th>
        <th scope="col">Aksi</th>
        <th scope="col">Waktu Dilakukan</th>
        <th scope="col" class="text-start">Opsi</th>
    </tr>
    </thead>
    <tbody id="tbody">
    @foreach ($data as $index => $item)
        <tr>
            <td class="text-start">{{$index + 1 }}</td>
            <th scope="row" class="max-500">{{$item->aksi}}</th>
            <th scope="row">{{$item->display_waktu}} WIB</th>
            <td class="text-start d-flex column-gap-1">
                <button onclick="editData({{$item->id}}, '/admin/log-aktivitas/edit-data', 'Detail Data')" class="btn btn-warning w-full">Detail</button>
            </td>
    @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#tableData').DataTable();
    });
</script>
