
    <div class="container-fluid">
        <h2 style="margin-top:0px">Pengajuan List</h2>
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('pengajuan/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('pengajuan/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('pengajuan'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Jenis Pengajuan</th>
		<th>Pengimput</th>
		<th>Status Kirim</th>
		<th>Tanggal</th>
		<th>Action</th>
            </tr><?php
            foreach ($pengajuan_data as $pengajuan)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $pengajuan->jenis_pengajuan ?></td>
			<td><?php echo $classnyak->get_data_user($pengajuan->user_id)->name ?></td>
			<td><?php 

            echo $pengajuan->status_kirim == 0 ? '<span class="badge bg-danger text-white">Draft</span>' : '<span class="badge bg-success text-white">Terkirim</span>';

            ?></td>
			<td><?php echo $pengajuan->tanggal ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('pengajuan/read/'.$pengajuan->id_pengajuan),'Read'); 
				echo ' | '; 
				echo anchor(site_url('pengajuan/update/'.$pengajuan->id_pengajuan),'Update'); 
				echo ' | '; 
				echo anchor(site_url('pengajuan/delete/'.$pengajuan->id_pengajuan),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
		<?php echo anchor(site_url('pengajuan/excel'), 'Excel', 'class="btn btn-primary"'); ?>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    </div>