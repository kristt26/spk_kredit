<?= $this->extend('layout/admin/layout') ?>
<?= $this->section('content') ?>
<div ng-controller="hasilController">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card">
                <!-- <div class="card-header d-flex justify-content-end">
                    </div> -->
                <div class="card-body">
                    <div class="text-right">
                        <button class="btn btn-primary btn-sm" ng-click="showTambah()"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Usia</th>
                                    <th>Penghasilan</th>
                                    <th ng-repeat="item in datas.kriteria" ng-if="item.nama != 'Penghasilan'" ng-hide="item.nama == 'Usia'">{{item.nama}}</th>
                                    <th>Hasil Perhitungan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas.alternatif">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nik}}</td>
                                    <td>{{item.nama}}</td>
                                    <td>{{item.usia}} Tahun</td>
                                    <td>{{item.penghasilan | currency: 'Rp. '}}</td>
                                    <td ng-repeat="nilai in item.nilai" ng-if="nilai.nama != 'Penghasilan'" ng-hide="nilai.nama == 'Usia'">{{nilai.range}}</td>
                                    <td>{{item.preferensi}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-lg-between">
                    <h3>Matriks Keputusan</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm">
                            <thead>
                                <tr>
                                    <th>Alternatif</th>
                                    <th ng-repeat="item in datas.alternatif[0].nilai">C{{$index+1}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas.alternatif">
                                    <td>{{item.nama}}</td>
                                    <td ng-repeat="nilai in item.nilai">{{nilai.bobot}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <button type="button" ng-click="save()" class="btn btn-primary pmd-ripple-effect btn-sm"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </div> -->
    </div>

</div>
<?= $this->endSection() ?>