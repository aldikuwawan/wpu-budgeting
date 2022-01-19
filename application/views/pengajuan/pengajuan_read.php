
    <div class="container-fluid">
        <h2 style="margin-top:0px">Pengajuan Read</h2>
        <table class="table">
		    <tr><td>Data Pengajuan</td><td><?php echo $data_pengajuan; ?></td></tr>
		    <tr><td>Jenis Pengajuan</td><td><?php echo $jenis_pengajuan; ?></td></tr>
		    <tr><td>Pengimput</td><td><?php echo $classnyak->get_data_user($user_id)->name ?></td></tr>
		    <tr><td>Fungsi</td><td><?php echo $role_data->role ?></td></tr>
		    <tr><td>Status Kirim</td><td><?php echo $status_kirim; ?></td></tr>
		    <tr><td>Tanggal</td><td><?php echo $tanggal; ?></td></tr>
		    <tr><td></td><td><a href="<?php echo site_url('') ?>" class="btn btn-success">Kirim</a><a href="<?php echo site_url('pengajuan') ?>" class="btn btn-default">Cancel</a></td></tr>
		</table>
        </div>
</html>