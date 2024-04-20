<?= $this->extend('layout/admin/layout') ?>
<?= $this->section('content') ?>
<div ng-controller="laporanController">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <form ng-submit="save()">
                        <div class="form-group pmd-textfield">
                            <label class="control-label">Periode</label>
                            <select class="form-control" ng-options="item.periode for item in periodes" ng-model="periode" ng-change="hitung(periode)">
                            </select>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive" ng-show="datas.alternatif.length>0">
                        <table class="table pmd-table table-sm">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Usia</th>
                                    <th>Penghasilan</th>
                                    <th>Nilai Optimasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas.alternatif">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nik}}</td>
                                    <td>{{item.nama}}</td>
                                    <td>{{item.usia}} Tahun</td>
                                    <td>{{item.penghasilan | currency: 'Rp. '}}</td>
                                    <td>{{item.preferensi}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>