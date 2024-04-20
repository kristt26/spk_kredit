<?= $this->extend('layout/admin/layout') ?>
<?= $this->section('content') ?>
<div ng-controller="alternatifController">
    <div class="row">
        <div class="col-md-12" ng-show="!tambah">
            <div class="card">
                <div class="card-header">
                    <h3>Data Alternatif tidak inputkan secara manual tetapi langsung dimport menggunakan format excel. silahkan download format excel di <a href="<?= base_url('format_alternatif.xlsx') ?>">sini</a></h3>
                </div>
                <form ng-submit="save()">
                    <div class="card-body">
                        <div ng-class="{'form-group pmd-textfield pmd-textfield-floating-label': !model.id, 'form-group pmd-textfield': model.id}">
                            <label class="control-label">File Excel</label>
                            <input type="file" class="form-control" name="berkas" ng-change="getData(berkas)" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" id="berkas" ng-model="berkas" base-sixty-four-input required>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12" ng-show="setShow=='data'">
            <div class="card">
                <div class="card-header d-flex justify-content-lg-between">
                    <h3>Matriks Keputusan</h3>
                    <button class="btn btn-secondary btn-sm" ng-click="back()"><i class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table pmd-table table-sm">
                            <thead>
                                <tr>
                                    <th>Alternatif</th>
                                    <th ng-repeat="item in dataExcel[0].nilai">C{{$index+1}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in dataExcel">
                                    <td>{{item.kode}}</td>
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
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" ng-if="tambah">
            <div class="card">
                <div class="card-header">
                    <h3>Tambah Data</h3>
                </div>
                <form ng-submit="save()">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                    <label class="control-label">NIK</label>
                                    <input type="text" class="form-control  form-control-sm" id="nik" ng-model="model.nik" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                    <label class="control-label">Nama Kreditur</label>
                                    <input type="text" class="form-control  form-control-sm" id="nama" ng-model="model.nama" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                    <label class="control-label">Kontak</label>
                                    <input type="text" class="form-control  form-control-sm" id="kontak" ng-model="model.kontak" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                    <label class="control-label">Usia</label>
                                    <input type="text" class="form-control  form-control-sm" id="usia" ng-model="model.usia">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                    <label class="control-label">Penghasilan</label>
                                    <input type="text" class="form-control  form-control-sm" id="penghasilan" ng-model="model.penghasilan" required ui-number-mask='0'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pmd-textfield">
                            <label class="control-label">Alamat</label>
                            <textarea class="form-control  form-control-sm"  id="alamat" ng-model="model.alamat" rows="2"></textarea>
                        </div>
                        <div class="form-group pmd-textfield" ng-repeat="range in kriterias" ng-if="range.nama != 'Penghasilan'" ng-hide="range.nama == 'Usia'">
                            <label class="control-label">{{range.nama}}</label>
                            <select class="form-control  form-control-sm" ng-options="item as item.range for item in range.range" ng-model="range.nilai" ng-change="range.value = range.nilai.bobot; range.nominal = range.nilai.range"></select>
                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button type="submit" class="btn btn-secondary pmd-ripple-effect btn-sm" ng-click="back()">Batal</button>
                        <button type="submit" class="btn btn-primary pmd-ripple-effect btn-sm">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-md-12 mt-3" ng-if="!tambah">
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
                                    <th>Alamat</th>
                                    <th>Kontak</th>
                                    <th>Usia</th>
                                    <th>Penghasilan</th>
                                    <th ng-repeat="item in datas.kriteria" ng-if="item.nama != 'Penghasilan'" ng-hide ="item.nama == 'Usia'">{{item.nama}}</th>
                                    <th><i class="fa fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas.alternatif">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nik}}</td>
                                    <td>{{item.nama}}</td>
                                    <td>{{item.alamat}}</td>
                                    <td>{{item.kontak}}</td>
                                    <td>{{item.usia}} Tahun</td>
                                    <td>{{item.penghasilan | currency: 'Rp. '}}</td>
                                    <td ng-repeat="nilai in item.nilai" ng-if="nilai.nama != 'Penghasilan'" ng-hide="nilai.nama == 'Usia'">{{nilai.range}}</td>
                                    <td>
                                        <button type="submit" class="btn btn-warning pmd-ripple-effect btn-sm" ng-click="edit(item)"><i class="fa fa-edit fa-sm fa-fw"></i></button>
                                        <button type="submit" class="btn btn-danger pmd-ripple-effect btn-sm"><i class="fa fa-trash fa-sm fa-fw"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <div class="modal fade" id="excel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Excel</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Kontak</th>
                                    <th ng-repeat="item in datas.kriteria">{{item.nama}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat = "item in dataExcel">
                                    <th>{{$index+1}}</th>
                                    <th>{{item.nik}}</th>
                                    <th>{{item.nama}}</th>
                                    <th>{{item.alamat}}</th>
                                    <th>{{item.kontak}}</th>
                                    <td ng-repeat="nilai in item.nilai">{{nilai.nama == 'Penghasilan' ? (nilai.range | currency: 'Rp. ') : nilai.range}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm" ng-click="tambahData()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>