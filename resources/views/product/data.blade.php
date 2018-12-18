<table class="table table-hover" id="product-table">
    <thead>
        <tr>
            <th><input type="checkbox" onclick="selectAll(this)"></th>
            <th>*</th>
            <th>Barcode</th>
            <th>Nomor Barcode</th>
            <th>Tanggal Dibuat</th>
            {{-- <th>Batch Produksi</th>
            <th>Expired Date</th>
            <th>Jumlah Karton</th>
             --}}
            <th>...</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($datas as $index => $data)
            <tr>
                <td><input onclick="printBatch()" type="checkbox" name="batch" value="{{$data->id}}"></td>
                <td>{{ $index+1 }}</td>
                <td><img style="max-width:100%" src="data:image/png;base64,{{DNS1D::getBarcodePNG($data->barcode, 'I25', 1)}}" alt="Barcode"></td>
                <td>{{ $data->barcode }}</td>
                <td>{{ $data->created_at }}</td>
                {{-- 
                <td>{{ $data->loc }}</td>
                <td>{{ $data->batch }}</td>
                <td>{{ $data->exp }}</td>
                <td>{{ $data->karton }}</td>
                 --}}
                <td>
                    <button target="_blank" onclick="getDetail(this)" href="{{ route('product.show',$data->id) }}" class="button btn btn-info btn-xs"><i class="fa fa-print"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Data Kosong</td>
            </tr>
        @endforelse
    </tbody>
</table>