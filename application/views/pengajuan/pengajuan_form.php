<style>
/*    #tabel_pengajuan {
        counter-reset: rowNumber;
    }

    #tabel_pengajuan tr::before {
        display: table-cell;
        counter-increment: rowNumber;
        content: counter(rowNumber) ".";
        padding-right: 0.3rem;
        text-align: left;
    }*/
</style>



    <div class="container-fluid">
        <h2 style="margin-top:0px">Pengajuan <?php echo $button ?> <?php echo $status_kirim == 0 ? '<span class="badge bg-danger text-white">Draft</span>' : '<span class="badge bg-success text-white">Terkirim</span>'; ?></h2>
        <form action="<?php echo $action; ?>" method="post">

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
                                <textarea rows="3" class="form-control" name="keterangan" id="keterangan"><?php echo $keterangan ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="jenis_pengajuan">Jenis Pengajuan</label>
                                <input class="form-control" name="jenis_pengajuan" id="jenis_pengajuan" type="text" value="<?php echo $jenis_pengajuan ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    	    <div class="form-group">
                <label for="data_pengajuan">Data Pengajuan <?php echo form_error('data_pengajuan') ?></label>
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
                        <button class="btn btn-primary btn-block btn-add-data" data-idpengajuan="<?php echo $id_pengajuan ?>" type="button">Add</button>
                    </div>
                </div>
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
                                <tr>
                                    <td><?php echo $value['cost_center'] ?><input type="hidden" value="<?php echo $value['cost_center'] ?>" name="cost_center[]"/></td>
                                    <td><?php echo $value['cost_element_name'] ?><input type="hidden" value="<?php echo $value['cost_element_name'] ?>" name="cost_element_name[]"/></td>
                                    <td><?php echo $value['cost_element'] ?><input type="hidden" value="<?php echo $value['cost_element'] ?>" name="cost_element[]"/></td>
                                    <td><?php echo $value['work_activity'] ?><input type="hidden" value="<?php echo $value['work_activity'] ?>" name="work_activity[]"/></td>
                                    <td><?php echo $value['value'] ?><input type="hidden" value="<?php echo $value['value'] ?>" name="value[]"/></td>
                                    <td>Edit | Delete</td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
    	    <input type="hidden" name="id_pengajuan" value="<?php echo $id_pengajuan; ?>" /> 
    	    <button type="submit" class="btn btn-primary">KIRIM</button> 
    	    <a href="<?php echo site_url('pengajuan') ?>" class="btn btn-default">Kembali</a>
            <button class="btn btn-success">Import</button>
    	</form>
    </div>

    <script>
        window.onbeforeunload = function() {
          return "Data pada halam ini akan hilang dan tersimpan otomatis sebagai draft, yakin ingin melanjutkaan?";
        };

        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })

        $(document).ready(function() {
            $(document).on('click','.btn-add-data',function(e) {

                e.preventDefault()

                var jenis_pengajuan = $('#jenis_pengajuan').val()

                var cost_center = $('#cost_center').val()
                var cost_element_name = $('#cost_element_name').val()
                var cost_element = $('#cost_element').val()
                var work_activity = $('#work_activity').val()
                var value = $('#value').val()

                var thisel = $(this)

                thisel.html('<i class="fas fa-sync fa-spin"></i>').addClass('disabled').attr('disabled')

                var id_pengajuan = $(this).attr('data-idpengajuan')
                var keterangan = $('#keterangan').val()

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'Pengajuan/auto_save_pengajuan'?>",
                    data: {
                        id_pengajuan: id_pengajuan,
                        jenis_pengajuan: jenis_pengajuan,
                        cost_center: cost_center,
                        cost_element_name: cost_element_name,
                        cost_element: cost_element,
                        work_activity: work_activity,
                        value: value,
                        keterangan: keterangan
                    },
                    success: function(data){
                        var dt = JSON.parse(data)
                            
                        if (dt.status == 'ok') {
                            if (dt.message == 'using old code') {
                                thisel.attr('data-idpengajuan',dt.id_pengajuan)
                                Toast.fire({
                                  icon: 'success',
                                  title: 'Berhasil menyimpan'
                                })
                            }

                            if (dt.message == 'new code') {
                                thisel.attr('data-idpengajuan',dt.id_pengajuan)
                                Toast.fire({
                                  icon: 'success',
                                  title: 'Disimpan otomatis'
                                })
                            }

                            $('#list_data').append(`<tr>
                                <td>${cost_center}<input type="hidden" value="${cost_center}" name="cost_center[]"/></td>
                                <td>${cost_element_name}<input type="hidden" value="${cost_element_name}" name="cost_element_name[]"/></td>
                                <td>${cost_element}<input type="hidden" value="${cost_element}" name="cost_element[]"/></td>
                                <td>${work_activity}<input type="hidden" value="${work_activity}" name="work_activity[]"/></td>
                                <td>${value}<input type="hidden" value="${value}" name="value[]"/></td>
                                <td>Edit | Delete</td>
                            </tr>`)
                        }

                        //getAllKuesioner()
                        thisel.html('Add').removeClass('disabled').removeAttr('disabled')
                    },
                    error: function(error) {
                        Swal.fire({
                          icon: 'error',
                          title: "Oops!",
                          text: 'Tidak dapat tersambung dengan server, pastikan koneksi anda aktif, jika masih terjadi hubungi admin IT'
                        })
                        thisel.html('Add').removeClass('disabled').removeAttr('disabled')
                    }
                });

            })
        })

    </script>