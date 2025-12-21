<table class="table align-items-center mb-0" id="tableData">
    <thead class="thead-light">
    <tr>
        <th scope="col" class="text-start">No</th>
        <th scope="col">Nama User</th>
        <th scope="col">Email</th>
        <th scope="col" class="text-start">Role</th>
        @if(Auth::user() && Auth::user()->hasRole('administrator'))
            <th scope="col" class="text-start">Opsi</th>
        @endif
    </tr>
    </thead>
    <tbody id="tbody">
    @foreach ($data as $index => $item)
        <tr>
            <td class="text-start">{{ $index + 1 }}</td>
            <td class="text-start">{{ $item->nama }}</td>
            <td class="text-start">{{ $item->email }}</td>
            <td class="text-start">{{ $item->getRoleName() }}</td>
            @if(Auth::user() && Auth::user()->hasRole('administrator'))
                <td class="text-start d-flex column-gap-1">
                    <button onclick="editData({{$item->id}}, '/admin/user/edit-data')" class="btn btn-warning w-full">Edit</button>
                    <button onclick="deleteData({{$item->id}}, '/admin/user/delete-data', '#message-modal')" class="btn btn-danger w-full">Delete</button>
                </td>
        @endif
    @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tableData').DataTable();
    });
</script>
