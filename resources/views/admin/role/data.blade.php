<table class="table align-items-center mb-0">
    <thead class="thead-light">
    <tr>
        <th scope="col" class="text-start" width="5%">No</th>
        <th scope="col">Nama Role</th>
        <th scope="col" class="text-center">Jumlah Permission</th>
        <th scope="col" class="text-start">Opsi</th>
    </tr>
    </thead>
    <tbody id="tbody">
    @foreach ($data as $index => $item)
        <tr>
            <td class="text-start">{{ $data->firstItem() + $index }}</td>
            <td class="text-start fw-bold">{{ $item->name }}</td>
            <td class="text-center">
                <span class="badge bg-info">{{ $item->permissions_count }} Hak Akses</span>
            </td>
            <td class="text-start d-flex column-gap-1">
                @if(Auth::user()->hasRole('administrator'))
                    <button onclick="editData({{$item->id}}, '/admin/role/edit-data', 'Edit Role')" class="btn btn-warning btn-sm">Edit</button>
                    @if($item->name !== 'administrator' && $item->name !== 'super-admin')
                        <button onclick="deleteData({{$item->id}}, '/admin/role/delete-data', '#message-modal')" class="btn btn-danger btn-sm">Delete</button>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="py-2 px-3">
    {{ $data->links() }}
</div>
