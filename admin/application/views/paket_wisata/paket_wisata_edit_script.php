<script>
    function add_nama_destinasi(nama_destinasi) {
        var self = this;
        self.nama_destinasi = ko.observable(nama_destinasi);

    }

    function Input_Destinasi_model() {
        var self = this;

        self.destinasi_list = ko.observableArray([]);
        <?php foreach ($destinasi as $row) { ?>
            self.destinasi_list.push(new add_nama_destinasi('<?=$row['nama_destinasi']?>'));
        <?php } ?>

        self.destinasi_input = ko.observable('');
        self.remove = function(row) {
            self.destinasi_list.remove(row);
        }

        self.add_destinasi_list = function() {
            input = self.destinasi_input();
            console.log(input);
            self.destinasi_list.push(new add_nama_destinasi(input));
            self.destinasi_input('');
        }
        // self.edit_form();
    }


    $(document).ready(function() {
        ko.applyBindings(new Input_Destinasi_model(), document.getElementById("input_destinasi_model"));

        format_currency();
        format_number();

        $('#form_1').submit(function(e) {
            e.preventDefault();
            Custom_loading();
            $.ajax({
                url: '<?= base_url('paket_wisata/submit') ?>', // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function(data) // A function to be called if request succeeds
                {
                    if (data.success) {
                        window.location = '<?= base_url('paket_wisata/') ?>';
                    } else {
                        toastr.error(data.message);
                    }
                    // console.log(data);
                    JsLoadingOverlay.hide();
                },
                error: function(err, txt) {
                    JsLoadingOverlay.hide();
                    console.log(err);
                    // console.log('================');
                    // console.log(txt);
                    bootbox.alert({
                        size: "large",
                        title: '<span class="text-danger" >Error ' + err.status + '<span>',
                        message: '<iframe id="bootframe_err"  src="about:blank" style="width:100%;height:500px;border:none" ></iframe>',
                        onShown: function(e) {
                            var doc = document.getElementById('bootframe_err').contentWindow.document;
                            doc.open();
                            doc.write(err.responseText);
                            doc.close();
                        }
                    });
                }
            });
        });

        // $(document).ready(function() {
        $(window).keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        // });

    });
</script>