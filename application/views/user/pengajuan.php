                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

                    <div class="row">
                        <div class="col-lg">
                          <?php if(validation_errors()) : ?>
                            <div class="alert alert-danger" role="alert">
                              <?= validation_errors(); ?>
                            </div>
                          <?php endif; ?>

                    <?= $this->session->flashdata('message'); ?>

                        <a href="<?= base_url('pengajuan/tambah');?>" class="btn btn-primary mb-3">Input pengajuan</a>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Cost Element</th>
                                <th scope="col">Cost Elemen Name</th>
                                <th scope="col">Cost Center</th>
                                <th scope="col">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($inputPengajuan as $ip) : ?>
                                <tr>
                                <th scope="row"><?= $i; ?></th>
                                <td><?= $ip['cost_element']; ?></td>
                                <td><?= $ip['cost_element_name']; ?></td>
                                <td><?= $ip['cost_center']; ?></td>
                                <td><?= $ip['value']; ?></td>
                                <td>
                                    <a href="" class="badge badge-success">edit</a>
                                    <a href="" class="badge badge-danger">delete</a>
                                </td>
                                </tr>
                                <?php $i++; ?>
                                <?php endforeach ?>
                        </tbody>
                    </table>
             </div>
        </div>

