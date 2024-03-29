    <div class="container-fluid">
        <div class="alert-wrapper">

        </div>
        <h2 style="margin-top:0px"><span id="tindakan"><?php echo $button ?></span> Pengajuan <?php echo $status_kirim == 0 ? '<span class="badge bg-danger text-white">Draft</span>' : '<span class="badge bg-success text-white">Terkirim</span>'; ?></h2>
        <form id="form_pengajuan">

            <div class="row">
                <div class="col-7">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama_penginput">Nama</label>
                                <input class="form-control disabled" readonly name="nama_penginput" id="nama_penginput" placeholder="Data Pengajuan" type="text" value="<?php echo $nama_penginput ?>" />
                            </div>
                            <div class="form-group">
                                <label for="Fungsi">Fungsi</label>
                                <input class="form-control disabled" readonly name="fungsi" id="fungsi" value="<?php echo $role; ?>" type="text"/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea rows="3" class="form-control" name="keterangan" <?php echo $status_kirim == 1 ? 'disabled' : ''; ?> id="keterangan"><?php echo $keterangan ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="jenis_pengajuan">Jenis Pengajuan</label>
                                <input class="form-control" name="jenis_pengajuan" id="jenis_pengajuan" type="text" <?php echo $status_kirim == 1 ? 'disabled' : ''; ?> value="<?php echo $jenis_pengajuan ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	    <div class="form-group">
                <label for="data_pengajuan">Data Pengajuan <?php echo form_error('data_pengajuan') ?></label>
                <?php
                if ($status_kirim == 0) {
                    ?>
                    <div class="row">
                        <div class="col-2" style="padding: 2px;">
                            <input type="text" id="cost_center" class="form-control" placeholder="Cost Center">
                        </div>
                        <div class="col-2" style="padding: 2px;">
                            <input type="text" id="cost_element_name" class="form-control" placeholder="Cost Element Name">
                        </div>
                        <div class="col-2" style="padding: 2px;">
                            <input type="text" id="cost_element" class="form-control" placeholder="Cost Element">
                        </div>
                        <div class="col-2" style="padding: 2px;">
                            <input type="text" id="work_activity" class="form-control" placeholder="Work Activity">
                        </div>
                        <div class="col-2" style="padding: 2px;">
                            <input type="text" id="value" class="form-control" placeholder="Value">
                        </div>
                        <div class="col-2" style="padding: 2px;">
                            <div class="btn-group" style="width: 100%;">
                                <button class="btn btn-primary btn-add-data" data-idpengajuan="<?php echo $id_pengajuan ?>" type="button">Add</button>
                                
                                <button class="btn btn-success btn-import-excel-local" data-idpengajuan="<?php echo $id_pengajuan ?>" type="button" onclick="fileuploadexcelclick();"><i class="fa fa-file-excel"></i></button>
                                <input type="file" id="file_excel" class="form-control" style="display: none;">


                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="form-group">
                <table class="table table-bordered" id="tabel_pengajuan">
                    <thead>
                        <tr>
                            <th>Cost Center</th>
                            <th>Cost Element Name</th>
                            <th>Cost Element</th>
                            <th>Work Activity</th>
                            <th>Value</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="list_data">
                        <?php
                        if ($data_pengajuan) {
                            $dtpengj = json_decode($data_pengajuan, TRUE);

                            foreach ($dtpengj as $key => $value) {
                                ?>
                                <tr class="datany">
                                    <td><?php echo $value['cost_center'] ?><input type="hidden" value="<?php echo $value['cost_center'] ?>" class="cost_center" name="cost_center[]"/></td>
                                    <td><?php echo $value['cost_element_name'] ?><input type="hidden" value="<?php echo $value['cost_element_name'] ?>" class="cost_element_name" name="cost_element_name[]"/></td>
                                    <td><?php echo $value['cost_element'] ?><input type="hidden" value="<?php echo $value['cost_element'] ?>" class="cost_element" name="cost_element[]"/></td>
                                    <td><?php echo $value['work_activity'] ?><input type="hidden" value="<?php echo $value['work_activity'] ?>" class="work_activity" name="work_activity[]"/></td>
                                    <td><?php echo $value['value'] ?><input type="hidden" value="<?php echo $value['value'] ?>" class="value" name="value[]"/></td>
                                    <td><input type="hidden" value="<?php echo $value['unique_id'] ?>" class="unique_id" name="unique_id[]"/>Edit | Delete</td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <input type="hidden" id="id_pengajuan" name="id_pengajuan" value="<?php echo $id_pengajuan ?>">
            </div>
            <?php
            if ($status_kirim == 0) {
                ?>
                <button type="submit" class="btn btn-primary">KIRIM</button> 
                <button type="button" class="btn btn-warning btn-save-as-draft">Simpan Sebagai Draft</button>
                <?php
            }
            ?>
    	    <a href="<?php echo site_url('pengajuan') ?>" class="btn btn-dark">Kembali</a>
    	</form>
    </div>

    <script>

        function fileuploadexcelclick() {
            $('#file_excel').click();
        }


        $(document).ready(function() {

            function update_data() {
                // create empty array to store data
                var data = [];
                
                var jenis_pengajuan = $('#jenis_pengajuan').val()                

                $('#list_data tr').each(function(index, el) {
                    // get each input from td
                    var cost_center = $(this).find('input.cost_center').val();
                    var cost_element_name = $(this).find('input.cost_element_name').val();
                    var cost_element = $(this).find('input.cost_element').val();
                    var work_activity = $(this).find('input.work_activity').val();
                    var value = $(this).find('input.value').val();
                    var unique_id = $(this).find('input.unique_id').val();

                    // push to array
                    data.push({
                        unique_id: unique_id,
                        cost_center: cost_center,
                        cost_element_name: cost_element_name,
                        cost_element: cost_element,
                        work_activity: work_activity,
                        value: value
                    });
                });
                var id_pengajuan = $('#id_pengajuan').val();
                var keterangan = $('#keterangan').val()
                $.ajax({
                    url: '<?php echo site_url('pengajuan/update_listdata_pengajuan') ?>',
                    type: 'POST',
                    data: {
                        id_pengajuan: id_pengajuan,
                        jenis_pengajuan: jenis_pengajuan,
                        data_pengajuan: data,
                        keterangan: keterangan
                    },
                    success: function(data) {
                        var dt = JSON.parse(data);
                        if (dt.status == 'ok') {
                            if(dt.status == 'using old code') {
                                Toast.fire({
                                    type: 'success',
                                    icon: 'success',
                                    title: 'Data berhasil diupdate'
                                })
                                $('#id_pengajuan').val(dt.id_pengajuan);
                            } else {
                                // replace url bar to pengajuan/update/dt.id_pengajuan without refreshing
                                window.history.replaceState({}, '', '<?php echo site_url('pengajuan/update/') ?>' + dt.id_pengajuan);
                                $('.alert-wrapper').html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                                <strong>Tidak Perlu Khawatir.</strong> Data yang diketik pada pengajuan sudah Tersimpan otomatis
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>`)
                                $('#id_pengajuan').val(dt.id_pengajuan);
                            }
                        } else {
                            Toast.fire({
                                icon: 'error',
                                type: 'error',
                                title: 'Data gagal diupdate'
                            })
                        }
                    }
                });
            }

            // function upload file ajax
            function upload_file_ajax() {
                var formData = new FormData();
                var file = $('#file_excel')[0].files[0];
                formData.append('file_excel', file);
                $.ajax({
                    url: '<?php echo site_url('pengajuan/get_data_excel') ?>',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        var dt = JSON.parse(data);
                        if (dt.status == 'ok') {
                            Toast.fire({
                                type: 'success',
                                icon: 'success',
                                title: 'Berhasil import data'
                            })
                            $('#list_data').append(dt.data);
                            update_data()
                        } else {
                            Toast.fire({
                                icon: 'error',
                                type: 'error',
                                title: 'Data gagal diupload'
                            })
                        }
                    }
                });
                $('#file_excel').val('');
            }

            $(document).on('click','.btn-add-data',function(e) {

                e.preventDefault()

                var cost_center = $('#cost_center').val()
                var cost_element_name = $('#cost_element_name').val()
                var cost_element = $('#cost_element').val()
                var work_activity = $('#work_activity').val()
                var value = $('#value').val()

                var urutan = $('#list_data tr').length + 1;

                $('#list_data').append(`<tr>
                    <td>${cost_center}<input type="hidden" value="${cost_center}" class="cost_center" name="cost_center[]"/></td>
                    <td>${cost_element_name}<input type="hidden" value="${cost_element_name}" class="cost_element_name" name="cost_element_name[]"/></td>
                    <td>${cost_element}<input type="hidden" value="${cost_element}" class="cost_element" name="cost_element[]"/></td>
                    <td>${work_activity}<input type="hidden" value="${work_activity}" class="work_activity" name="work_activity[]"/></td>
                    <td>${value}<input type="hidden" value="${value}" class="value" name="value[]"/></td>
                    <td><input type="hidden" value="${urutan}" class="unique_id" name="unique_id[]"/>Edit | Delete</td>
                </tr>`)

                update_data()
            })

            $(document).on('click','.btn-save-as-draft',function(e) {

                e.preventDefault()
                var thisel = $('this')

                thisel.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

                update_data()

                thisel.html('Simpan Sebagai Draft').removeClass('disabled').removeAttr('disabled')
            })

            $(document).on('submit','#form_pengajuan', function(e) {

                e.preventDefault()

                var btnselected = $(document.activeElement)

                btnselected.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

                    Swal.fire({
                      title: 'Konfirmasi Tindakan',
                      text: "Yakin ingin mengirim pengajuan ini?",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            dataString = $("#form_pengajuan").serialize();
                            $.ajax({
                                type: "POST",
                                url: "<?php echo base_url().'pengajuan/send_pengajuan'?>",
                                data: dataString,
                                success: function(data){

                                    var dt = JSON.parse(data)

                                    if (dt.response == 'ok') {
                                        window.location.href = '<?php echo base_url().'pengajuan/success?thing=Pengajuan&operation=send' ?>'
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: "Oops!",
                                            text: 'Terjadi kesalahan, silahkan coba lagi'
                                        })
                                    }
                                },
                                error: function(error) {
                                    Swal.fire({
                                      icon: 'error',
                                      title: "Oops!",
                                      text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                                    })
                                }
                            });
                        } else {
                            btnselected.html('KIRIM').removeClass('disabled').removeAttr('disabled')
                        }
                })
            })

            $('#file_excel').change(function() {
                upload_file_ajax();
            });
        })

    </script>