<div class="main-panel">
                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                <?php echo $this->session->flashdata('pesan') ?>
                                    <h4 class="card-title">Daftar Alternatif</h4>
                                    <a class="btn btn-sm btn-info" href="<?php echo base_url('alternatif/tambahAlternatif') ?>">Tambah Alternatif</a>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Alternatif</th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach($alternatif as $a) : ?>
                                                <tr>
                                                    <td><?php echo $no++ ?></td>
                                                    <td><?php echo $a->alternatif ?></td>
                                                    <td><?php echo $a->keterangan ?></td>
                                                    <td>
                                                        <a class="btn btn-sm btn-info" href="<?php echo base_url('NilaiKeputusan/tampilNilai/'.$a->alternatif) ?>">Open</a>
                                                        <a class="btn btn-sm btn-warning" href="<?php echo base_url('alternatif/editAlternatif/'.$a->id) ?>">Edit</a>
                                                        <a onclick="return confirm('Yakin Hapus?')" class="btn btn-sm btn-danger" href="<?php echo base_url('alternatif/deleteAlternatif/'.$a->alternatif) ?>">Delete</a>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                
                                    <h4 class="card-title">Membentuk Matriks Keputusan</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <?php foreach($kriteria as $k) : ?>
                                                    <th><?php echo $k->kode ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($alternatif as $a) : ?>
                                                    <?php $mmk = $this->db->query("SELECT * FROM membentuk_matriks_keputusan WHERE alternatif = '$a->alternatif' ORDER BY id ASC")->result(); ?>
                                                    
                                                <tr>
                                                    <td><?php echo $a->alternatif ?></td>
                                                <?php foreach($mmk as $m) : ?> 

                                                    <td><?php echo $m->nilai ?></td>
                                                    <?php endforeach; ?>
                                                </tr>
                                                
                                               
                                               <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                
                                    <h4 class="card-title">Normalisasi Matriks Keputusan</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                        <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <?php foreach($kriteria as $k) : ?>
                                                    <th><?php echo $k->kode ?></th>
                                                    <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($alternatif as $a) : ?>
                                                <tr>
                                                    <td><?php echo $a->alternatif ?></td>
                                                    <?php foreach($kriteria as $k) : ?>
                                                        <?php $mmk2 = $this->db->query("SELECT membentuk_matriks_keputusan.nilai AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode' && alternatif = '$a->alternatif'")->result(); ?>
                                                        <?php $mmk3 = $this->db->query("SELECT MAX(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>

                                                        <?php foreach($mmk2 as $mk2) : ?>
                                                            <?php foreach($mmk3 as $mk3) : ?>
                                                                <td><?php echo round($mk2->nilai/$mk3->nilai,3) ?></td>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">

                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                
                                    <h4 class="card-title">Analisis Peringkat</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                        <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>G-</th>
                                                    <th>G+</th>
                                                    <th>Jumlah Interval</th>
                                                    <th>Perbedaan Interval</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($kriteria as $k) : ?>
                                                <tr>
                                                
                                                    <td><?php echo $k->kode ?></td>

                                                    <?php $mmk2 = $this->db->query("SELECT MIN(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>
                                                    <?php $mmk3 = $this->db->query("SELECT MAX(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>

                                                    <?php foreach($mmk2 as $mk2) : ?>
                                                        <?php foreach($mmk3 as $mk3) : ?>
                                                            <td><?php echo round(($mk2->nilai/$mk3->nilai),3) ?></td>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>

                                                    <?php $mmk4 = $this->db->query("SELECT MAX(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>
                                                    <?php $mmk5 = $this->db->query("SELECT MAX(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>

                                                    <?php foreach($mmk4 as $mk4) : ?>
                                                        <?php foreach($mmk5 as $mk5) : ?>
                                                            <td><?php echo round(($mk4->nilai/$mk5->nilai),3) ?></td>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>

                                                    <td><?php echo (float)$k->bobot/100 ?></td>

                                                    <?php $mmk6 = $this->db->query("SELECT MIN(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>
                                                    <?php $mmk7 = $this->db->query("SELECT MAX(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>
                                                    <?php $mmk8 = $this->db->query("SELECT MAX(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>

                                                    <?php foreach($mmk6 as $mk6) : ?>
                                                        <?php foreach($mmk7 as $mk7) : ?>
                                                            <?php foreach($mmk8 as $mk8) : ?>
                                                                <td><?php echo round((($mk7->nilai/$mk8->nilai)-($mk6->nilai/$mk7->nilai))/((float)$k->bobot/100),3) ?></td>
                                                           <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>
                                                
                                                    
                                            </tr>
                                            <?php endforeach; ?>
                                        
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                </div>

                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                
                                    <h4 class="card-title">Menentukan Nilai Score</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                        <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <?php foreach($kriteria as $k) : ?>
                                                    <th><?php echo $k->kode ?></th>
                                                    <?php endforeach; ?>
                                                    <th>Total Score</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach($alternatif as $a) : ?>
                                                <tr>
                                                    <td><?php echo $a->alternatif ?></td>
                                                    <?php $nl=0; foreach($kriteria as $k) : ?>
                                                        <?php $mmk2 = $this->db->query("SELECT membentuk_matriks_keputusan.nilai AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode' && alternatif = '$a->alternatif'")->result(); ?>
                                                        <?php $mmk3 = $this->db->query("SELECT MAX(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>
                                                        <?php $mmk4 = $this->db->query("SELECT MIN(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>

                                                        <?php foreach($mmk2 as $mk2) : ?>
                                                            <?php foreach($mmk3 as $mk3) : ?>
                                                                <?php foreach($mmk4 as $mk4) : ?>
                                                                    <td><?php echo round(($mk2->nilai/$mk3->nilai)*(($mk3->nilai/$mk3->nilai)-($mk4->nilai/$mk3->nilai))/((float)$k->bobot/100),3) ?></td>
                                                                    <?php $nl += ($mk2->nilai/$mk3->nilai)*(($mk3->nilai/$mk3->nilai)-($mk4->nilai/$mk3->nilai))/((float)$k->bobot/100) ?>
                                                                <?php endforeach; ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                        
                                                    <?php endforeach; ?>
                                                    <td><?php echo round($nl,3) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                
                                    <h4 class="card-title">Menentukan Peringkat</h4>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                        <thead>
                                                <tr>
                                                    <th>Alternatif</th>
                                                    <th>Nama</th>
                                                    <th>Score</th>
                                                    <th>Rank</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php $nl=array(); $nl1=array(); $nl3=array(); foreach($alternatif as $aa => $a) : ?>
                                                <?php $nl[$aa]=0; $nl1[$aa]=0; foreach($kriteria as $k) : ?>
                                                    <?php $mmk2 = $this->db->query("SELECT membentuk_matriks_keputusan.nilai AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode' && alternatif = '$a->alternatif'")->result(); ?>
                                                    <?php $mmk3 = $this->db->query("SELECT MAX(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>
                                                    <?php $mmk4 = $this->db->query("SELECT MIN(membentuk_matriks_keputusan.nilai) AS nilai FROM membentuk_matriks_keputusan WHERE  kode = '$k->kode'")->result(); ?>

                                                    <?php foreach($mmk2 as $mk2) : ?>
                                                        <?php foreach($mmk3 as $mk3) : ?>
                                                            <?php foreach($mmk4 as $mk4) : ?>
                                                                
                                                                <?php $nl[$aa] += ($mk2->nilai/$mk3->nilai)*(($mk3->nilai/$mk3->nilai)-($mk4->nilai/$mk3->nilai))/((float)$k->bobot/100) ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>
                                                    
                                                <?php endforeach; ?>
                                                <?php $nl1[$aa] = $a->keterangan; ?>
                                                <?php $nl3[$aa] = $a->alternatif; ?>   
                                                    
                                            <?php endforeach; ?>
                                            <?php $nl2=array(); $nl4=array(); foreach($alternatif as $al => $ll) : ?>

                                                <?php 
                                                    $nl2["$nl[$al]"] = $nl1[$al];
                                                    krsort($nl2);
                                                    $nl4["$nl[$al]"] = $nl3[$al];
                                                    krsort($nl4);
                                                ?>

                                            <?php endforeach; ?>
                                            <?php $no=1; foreach($nl2 as $n => $nn) : ?>
                                                <tr>
                                                    <td><?php print_r($nl4[$n]) ?></td>
                                                    <td><?php print_r($nl2[$n]) ?></td>
                                                    <td><?php print_r(round($n,3)) ?></td>
                                                    <td><?php print_r($no++) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                



                
                <!-- content-wrapper ends -->