<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="<?= base_url('kendaraan/add') ?>">Add</a>
        <br>
        <br>
        <table id="dtt_tables" class="table table-bordered">
            <thead>
                <tr>
                    <th>id</th>
                    <th>#</th>
                    <th><?= label2("no_urut") ?></th>
                    <th><?= label2("tampilkan di home") ?></th>
                    <th><?= label2("nama_kendaraan") ?></th>
                    <th><?= label2("foto") ?></th>
                    <th><?= label2("harga lepas_kunci") ?></th>
                    <th><?= label2("harga include driver") ?></th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('#dtt_tables').DataTable({
            "columnDefs": [{
                    "targets": 0,
                    "visible": false,
                    "searchable": false,
                },
                {
                    "targets": 1,
                    "searchable": false,
                    "orderable": false
                },
            ],
            // "ordering": false,
            "order": [[2, 'asc']],
            "processing": true,
            "ajax": '<?= base_url('kendaraan/datatables') ?>',
            "buttons": ["copy", "csv", "excel", "pdf"],
            "dom": "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'l><'col-sm-12 col-md-7'p>>",
            "drawCallback": function(settings) {
                delete_handler();
            },
        });

        function delete_handler() {
            $('.delete_btn').click(function(e) {
                e.preventDefault();
                delete_url = $(this).attr('href');
                row_data = $(this).attr('row_data');

                bootbox.dialog({
                    title: 'Delete',
                    message: '<p>Yakin Menghapus Kendaraan <b>"' + row_data + '"</b> ?</p>',
                    onEscape: true,
                    backdrop: true,
                    buttons: {
                        ya: {
                            label: 'Ya',
                            className: 'btn-danger',
                            callback: function(result) {
                                $.get(delete_url, function(data, status) {
                                    table.ajax.reload(null, false);
                                    toastr.success("Data Telah dihapus", "Info");
                                });
                            }
                        },
                        batal: {
                            label: 'Batal',
                            className: 'btn-secondary',
                            callback: function(result) {

                            }
                        },
                    }
                });

            });

        }
    });
</script>