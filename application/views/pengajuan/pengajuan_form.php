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
        <h2 style="margin-top:0px">Pengajuan <?php echo $button ?></h2>
        <form action="<?php echo $action; ?>" method="post">

            <div class="row">
                <div class="col-7">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama_penginput">Nama</label>
                                <input class="form-control disabled" readonly name="nama_penginput" id="nama_penginput" placeholder="Data Pengajuan" type="text" value="<?php echo $user['name']; ?>" />
                            </div>
                            <div class="form-group">
                                <label for="Fungsi">Fungsi</label>
                                <input class="form-control disabled" readonly name="fungsi" id="fungsi" value="<?php echo $role_data->role; ?>" type="text"/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <textarea rows="3" class="form-control" name="keterangan" id="keterangan"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="jenis_pengajuan">Jenis Pengajuan</label>
                                <input class="form-control" name="jenis_pengajuan" id="jenis_pengajuan" type="text"/>
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
                        <button class="btn btn-primary btn-block btn-add-data" type="button">Add</button>
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

                    </tbody>
                </table>
            </div>
    	    <input type="hidden" name="id_pengajuan" value="<?php echo $id_pengajuan; ?>" /> 
    	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
    	    <a href="<?php echo site_url('pengajuan') ?>" class="btn btn-default">Cancel</a>
            <button class="btn btn-success">Import</button>
    	</form>
    </div>

    <script>
        
        $(document).ready(function() {
            $(document).on('click','.btn-add-data',function(e) {

                e.preventDefault()

                var cost_center = $('#cost_center').val()
                var cost_element_name = $('#cost_element_name').val()
                var cost_element = $('#cost_element').val()
                var work_activity = $('#work_activity').val()
                var value = $('#value').val()

                $('#list_data').append(`<tr>
                        <td>${cost_center}<input type="hidden" value="${cost_center}" name="cost_center[]"/></td>
                        <td>${cost_element_name}<input type="hidden" value="${cost_element_name}" name="cost_element_name[]"/></td>
                        <td>${cost_element}<input type="hidden" value="${cost_element}" name="cost_element[]"/></td>
                        <td>${work_activity}<input type="hidden" value="${work_activity}" name="work_activity[]"/></td>
                        <td>${value}<input type="hidden" value="${value}" name="value[]"/></td>
                        <td>Edit | Delete</td>
                    </tr>`)
            })
        })

    </script>