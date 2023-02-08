<script>
    showNew();

    $(document).ready(function() {
        var table = $('#tableNew').DataTable();

        // Select Row
        $('#tableNew tbody').on("click", "tr", function() {
            $(this).toggleClass("selected").siblings().removeClass();;
            return;
        });

        // Nonactive button
        $('#btnReject').click(function() {
            var id = table.row(".selected").id();

            if (id == null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please, select row first!'
                });
            } else {
                confirmReject(id);
            }

            return;
        });

        //Add Kategori List in Insert Form
        $.ajax({
            url: "http://localhost/ArsipAPI/kategori/getKategori.php",
            dataType: "JSON",
            type: "GET",
            success: function(data) {
                var list = "<option value=''>Pilih Kategori</option>";
                for (let index = 0; index < data.length; index++) {
                    list += "<option value='" + data[index].nama_kategori + "'>" + data[index].nama_kategori + "</option>";
                }
                $('#addKategori').html(list);
            }
        });

        // Edit Data
        $('#btnEdit').click(function() {
            var id = table.row(".selected").id();

            if (id == null) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please, select row first!'
                });
            } else {
                showEditModal(id);
            }

            return;
        });
        return;
    });

    /**
     * Reload Table
     * @param
     * @return
     */
    function refresh() {
        var table = $("#tableNew").DataTable();
        table.ajax.reload();
        return;
    }

    /**
     * Show Table
     * @param
     * @return
     */
    function showNew() {
        var table = $("#tableNew").DataTable({
            order: [
                [0, 'desc']
            ],
            destroy: true,
            rowId: 'id',
            ajax: {
                url: "http://localhost/ArsipAPI/suratKeluar/getAll.php",
                dataType: "JSON",
                type: "GET",
                deferRender: true,
                dataSrc: "",
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'nomer'
                },
                {
                    data: 'ditujukan'
                },
                {
                    data: 'keperluan'
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'penerima'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'kategori'
                },
                {
                    data: 'status',
                    render: function(data) {
                        if (data == 1) {
                            return "AKTIF"
                        } else {
                            return "PASIF"
                        }
                    }
                }
            ]
        })
    }

    function insert() {

        var data = {
            'nomer': $('#Nomer').val(),
            'ditujukan': $('#ditujukan').val(),
            'keperluan': $('#Keperluan').val(),
            'keterangan': $('#Keterangan').val(),
            'penerima': $('#Penerima').val(),
            'tanggal': $('#Tanggal').val(),
            'kategori': $('#addKategori').val(),
            'status': 1
        };
        var dataJson = JSON.stringify(data);

        $.ajax({
            url: "http://localhost/ArsipAPI/suratKeluar/post.php",
            contentType: "application/json; charset=utf-8",
            dataType: "JSON",
            type: "POST",
            data: dataJson,
            success: function() {
                console.log("Hore, berhasil!!!");
                refresh();
                $("#formTambah").trigger("reset");
                $("#modalAdd").modal("hide");
            },
            error: function(jqXHR, exception) {
                console.log("error")
                if (jqXHR.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (exception === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    alert('Time out error.');
                } else if (exception === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error.\n' + jqXHR.responseText);
                }
            }
        });
        return;
    }

    /**
     * Show Edit Modal
     * @param id
     * @return
     */
    function showEditModal(id) {
        var id = parseInt(id);
        $.ajax({
            url: "http://localhost/ArsipAPI/suratKeluar/getById.php?id=" + id,
            dataType: "JSON",
            type: "GET",
            success: function(data) {
                // console.log(data)
                var id = data.id
                var nomer = data.nomer
                var ditujukan = data.ditujukan
                var keperluan = data.keperluan;
                var keterangan = data.keterangan;
                var penerima = data.penerima
                var tanggal = data.tanggal;
                var kategori = data.kategori;
                var status = data.status;

                $('#editNomer').val(nomer);
                $('#editDitujukan').val(ditujukan);
                $('#editKeperluan').val(keperluan);
                $('#editKeterangan').val(keterangan);
                $('#editPenerima').val(penerima);
                $('#editTanggal').val(tanggal);
                $.ajax({
                    url: "http://localhost/ArsipAPI/kategori/getKategori.php",
                    dataType: "JSON",
                    type: "GET",
                    success: function(data) {
                        var list = "<option value='"+ kategori + "'>"+ kategori + "</option>";
                        for (let index = 0; index < data.length; index++) {
                            list += "<option value='" + data[index].nama_kategori + "'>" + data[index].nama_kategori + "</option>";
                        }
                        $('#editKategori').html(list);
                    }
                });
                $('#modalEdit').modal('show');
                document.querySelector('#editSurat').addEventListener("click", function() {
                    editSurat(id);
                });

                return;
            }
        });
    }

    /**
     * Edit Data
     * @param id
     * @return
     */
    function editSurat(id) {
        var data = {
            'id': id,
            'nomer': $('#editNomer').val(),
            'ditujukan': $('#editDitujukan').val(),
            'keperluan': $('#editKeperluan').val(),
            'keterangan': $('#editKeterangan').val(),
            'penerima': $('#editPenerima').val(),
            'tanggal': $('#editTanggal').val(),
            'kategori': $('#editKategori').val(),
            'status': 1
        }
        var dataJson = JSON.stringify(data);
        $.ajax({
            url: "http://localhost/ArsipAPI/suratKeluar/put.php",
            contentType: "application/json; charset=utf-8",
            dataType: "JSON",
            type: "PUT",
            data: dataJson,
            success: function() {
                refresh();
                $("#formEdit").trigger("reset");
                $("#modalEdit").modal("hide");
                window.location.reload();
            },
            error: function(jqXHR, exception) {
                console.log("error")
                if (jqXHR.status === 0) {
                    alert('Not connect.\n Verify Network.');
                } else if (jqXHR.status == 404) {
                    alert('Requested page not found. [404]');
                } else if (jqXHR.status == 500) {
                    alert('Internal Server Error [500].');
                } else if (exception === 'parsererror') {
                    alert('Requested JSON parse failed.');
                } else if (exception === 'timeout') {
                    alert('Time out error.');
                } else if (exception === 'abort') {
                    alert('Ajax request aborted.');
                } else {
                    alert('Uncaught Error.\n' + jqXHR.responseText);
                }
            }
        });
        return;
    }

    /**
     * Nonactive Data
     * @param id
     * @return
     */
    function nonaktif(id) {
        var id = parseInt(id);

        $.ajax({
            url: "http://localhost/ArsipAPI/suratKeluar/getById.php?id=" + id,
            dataType: "JSON",
            type: "GET",
            success: function(data) {
                var data = {
                    'id': data.id,
                    'nomer': data.nomer,
                    'ditujukan': data.ditujukan,
                    'keperluan': data.keperluan,
                    'keterangan': data.keterangan,
                    'penerima': data.penerima,
                    'tanggal': data.tanggal,
                    'kategori': data.kategori,
                    'status': 0
                }
                var dataJson = JSON.stringify(data);

                $.ajax({
                    url: "http://localhost/ArsipAPI/suratKeluar/put.php",
                    contentType: "application/json; charset=utf-8",
                    dataType: "JSON",
                    type: "PUT",
                    data: dataJson,
                    success: function() {
                        refresh();
                        windows.location.reload();
                    },
                })
            }
        });
    }

    /**
     * Confirm Nonactive Data
     * @param id
     * @return
     */
    function confirmReject(id) {
        id = parseInt(id);
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger',
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'No, cancel!',
            cancelButtonText: 'Yes, reject it!',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {

                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your Data is safe :)',
                    'error'
                )
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                nonaktif(id);
                swalWithBootstrapButtons.fire(
                    'Rejected!',
                    'Data has been Rejected.',
                    'success'
                )
            }
        })
    }

    function logout(id) {
        // Datetime
        var today = new Date();
        var day = today.getDate() + "";
        var month = (today.getMonth() + 1) + "";
        var year = today.getFullYear() + "";
        var hour = today.getHours() + "";
        var minutes = today.getMinutes() + "";
        var seconds = today.getSeconds() + "";

        day = checkZero(day);
        month = checkZero(month);
        year = checkZero(year);
        hour = checkZero(hour);
        minutes = checkZero(minutes);
        seconds = checkZero(seconds);


        function checkZero(data) {
            if (data.length == 1) {
                data = "0" + data;
            }
            return data;
        }

        last_login = year + "-" + month + "-" + day + " " + hour + ":" + minutes + ":" + seconds;
        // End Datetime

        var data = {
            "id": id,
            "last_login": last_login
        }
        var dataJson = JSON.stringify(data);

        $.ajax({
            url: "http://localhost/ArsipAPI/users/logout.php",
            contentType: "application/json; charset=utf-8",
            dataType: "JSON",
            type: "PUT",
            data: dataJson,
            success: function(data) {
                console.log("Berhasil dongg . . .");
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'See you!',
                    showConfirmButton: false,
                    timer: 5000
                });
                window.location.href = "/logout";
            }
        });

        return;
    }
</script>