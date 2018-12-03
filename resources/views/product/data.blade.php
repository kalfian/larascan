<table class="table table-hover" id="product-table">
    <thead>
        <tr>
            <th class="text-center">*</th>
            <th>Lokasi</th>
            <th>Batch Produksi</th>
            <th>Expired Date</th>
            <th>Jumlah Karton</th>
            <th>Tanggal Dibuat</th>
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($datas as $index => $data)
            <tr>
                <td class="text-center">{{ $index+1 }}</td>
                <td>{{ $data->loc }}</td>
                <td>{{ $data->batch }}</td>
                <td>{{ $data->exp }}</td>
                <td class="text-center">{{ $data->karton }}</td>
                <td>{{ $data->created_at }}</td>
                <td>
                    <a target="_blank" href="{{ route('product.show',$data->id) }}" class="button btn btn-info btn-xs"><i class="fa fa-print"></i></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Data Kosong</td>
            </tr>
        @endforelse
    </tbody>
</table>