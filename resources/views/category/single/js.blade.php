<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    var start_date = '';
    var end_date = '';
    var data_per_fetch = 500;
    var data_fetched = 0;

    $(document).ready(function() {
    $('#table').DataTable({
        searching: false,
        order: [[0, 'desc']]
    });

    getData();
});

function getData() {
    $('#loading-filter').show();

    var dataTableObj = $('#table').DataTable();

    dataTableObj.clear().draw();

    $.ajax({
        url: '{{ url("category/item") }}',
        dataType: 'json',
        data: {
            jenis: '{{ $data->nama }}'
        },

        success: function(results) {
            var data = results.data;

            $.each(data, function(index, item) {
                var array_temp = [];

                var harga_jual =
                    item.harga_beli +
                    item.harga_beli * item.laba / 100;

                harga_jual = Math.round(harga_jual);

                var html = `
                    <a href="{{ url('master-items/view') }}/${item.kode}"
                       class="btn btn-primary">
                        View
                    </a>
                `;

                array_temp.push(item.kode);
                array_temp.push(item.nama);
                array_temp.push(item.jenis);
                array_temp.push(item.harga_beli);
                array_temp.push(harga_jual);
                array_temp.push(item.supplier);
                array_temp.push(html);

                dataTableObj.row.add(array_temp).draw(false);
            });

            $('#loading-filter').hide();
        },

        error: function(xhr) {
            console.log(xhr.responseText);
            alert('Terjadi kesalahan server');
            $('#loading-filter').hide();
        }
    });
}
</script>