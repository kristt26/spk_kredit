angular.module('adminctrl', [])
    // Admin
    .controller('dashboardController', dashboardController)
    .controller('periodeController', periodeController)
    .controller('kriteriaController', kriteriaController)
    .controller('alternatifController', alternatifController)
    .controller('penilaianController', penilaianController)
    .controller('hasilController', hasilController)
    .controller('laporanController', laporanController)
    ;

function dashboardController($scope) {
    $scope.$emit("SendUp", "Dashboard");
    $scope.datas = {};
    $scope.title = "Dashboard";
    // dashboardServices.get().then(res=>{
    //     $scope.datas = res;
    // })
}

function periodeController($scope, periodeServices, pesan, helperServices) {
    $scope.setTitle = { header: 'Periode Penilaian', sub: null };
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    periodeServices.get().then((res) => {
        $scope.datas = res;
    })
    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                periodeServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                periodeServices.post($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
        document.getElementById("periode").focus();
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            klasifikasiServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }

    $scope.subKlasifikasi = (param) => {
        document.location.href = helperServices.url + "admin/sub_klasifikasi/data/" + param.id;
    }
}

function kriteriaController($scope, kriteriaServices, pesan, helperServices, RangeServices) {
    $scope.setTitle = { header: 'Kriteria', sub: null };
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    $scope.setTitle = 'Kriteria'
    kriteriaServices.get().then((res) => {
        $scope.datas = res;
    })
    $scope.convert = (param) => {
        console.log(param.charAt(0));
        if (param.charAt(0) == ">" || param.charAt(0) == "<") {
            var data = param.split(" ");
        }
        else {
            var data = param.split(" - ");
            data[0] = parseFloat(data[0]);
        }
        data[1] = parseFloat(data[1]);
        return data;
        // console.log(data);
    }
    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                kriteriaServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                kriteriaServices.post($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        item.bobot = parseInt(item.bobot);
        $scope.model = angular.copy(item);
        // document.getElementById("nama").focus();
    }

    $scope.showRange = (param) => {
        $.LoadingOverlay("show");
        $scope.setTitle = { header: 'Kriteria', sub: 'Sub Kriteria' };
        $scope.$emit("SendUp", $scope.setTitle);
        setTimeout(() => {
            $.LoadingOverlay("hide");
            $scope.$applyAsync(x => {
                $scope.kriteria = param;
                $scope.model.kriteria_id = $scope.kriteria.id;
                $scope.setTitle = "Range";
            })
        }, 200);
    }

    // $scope.back = ()=>{
    //     $.LoadingOverlay("show");
    //     $scope.setTitle = { header: 'Kriteria', sub: null };
    //     $scope.model = {};
    // }

    $scope.saveRange = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                RangeServices.put($scope.model).then(res => {
                    var data = $scope.kriteria.range.find(x => x.id == $scope.model.id);
                    if (data) {
                        data.range = $scope.model.range;
                        data.bobot = $scope.model.bobot;
                    }
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                RangeServices.post($scope.model).then(res => {
                    $scope.model.id = res;
                    $scope.kriteria.range.push($scope.model);
                    $scope.model = {};
                    $scope.model.kriteria_id = $scope.kriteria.id;
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            kriteriaServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }
    $scope.deleteRange = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            RangeServices.deleted(param).then(res => {
                var index = $scope.kriteria.range.indexOf(param);
                $scope.kriteria.range.splice(index, 1);
                pesan.Success("Berhasil menghapus data");
            })
        });
    }
    $scope.back = () => {
        $.LoadingOverlay("show");
        $scope.setTitle = { header: 'Kriteria', sub: null };
        $scope.$emit("SendUp", $scope.setTitle);
        setTimeout(() => {
            $.LoadingOverlay("hide");
            $scope.$applyAsync(x => {
                $scope.kriteria = {};
                $scope.setTitle = "Kriteria";
            })
        }, 200);
    }
}

function alternatifController($scope, alternatifServices, pesan, helperServices) {
    $scope.setTitle = { header: 'Calon Kreditur', sub: null };
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    alternatifServices.get().then((res) => {
        $scope.datas = res;
        console.log(res);
    })
    $scope.convert = (param) => {
        var data = param.split(" - ");
        console.log(data);
    }
    $scope.showTambah = () => {
        $scope.tambah = true;
        $scope.kriterias = angular.copy($scope.datas.kriteria);
    }

    $scope.back = () => {
        $scope.tambah = false;
        $scope.model = {};
    }

    $scope.getData = (param) => {
        alternatifServices.setData(param).then(res => {
            $scope.dataExcel = res;
            $scope.dataExcel.forEach(element => {
                element.kriteria = angular.copy($scope.datas.kriteria);
                element.kriteria.forEach(kriteria => {
                    var set = element.nilai.find(x => x.kode == kriteria.kode);
                    if (set.nama == 'Penghasilan') {
                        element.penghasilan = parseFloat(set.range);
                        kriteria.range.forEach(range => {
                            if (range.range.charAt(0) == "<") {
                                var item = range.range.split(" ");
                                if (element.penghasilan <= parseFloat(item[1])) {
                                    kriteria.nilai = range;
                                }
                            } else if (range.range.charAt(0) == ">") {
                                var item = range.range.split(" ");
                                if (element.penghasilan >= parseFloat(item[1])) {
                                    kriteria.nilai = range;
                                }
                            } else {
                                var item = range.range.split(" - ");
                                if (element.penghasilan >= parseFloat(item[0]) && element.penghasilan <= parseFloat(item[1])) {
                                    kriteria.nilai = range;
                                }
                            }
                        });

                        // kriteria.nilai = angular.copy(kriteria.range.find(x=>x.range == set.range));
                    }
                    else if (set.nama == 'Usia') {
                        element.usia = parseInt(set.range);
                        kriteria.range.forEach(range => {
                            var item = range.range.split(" - ");
                            if (element.usia >= parseFloat(item[0]) && element.usia <= parseFloat(item[1])) {
                                kriteria.nilai = range;
                            }
                        });
                    }
                    else {
                        kriteria.nilai = angular.copy(kriteria.range.find(x => x.range == set.range));
                    }
                    kriteria.value = kriteria.nilai.bobot;
                    kriteria.nominal = kriteria.nilai.range;
                });
            });
            console.log(res);
            $("#excel").modal('show');
        })
    }

    $scope.tambahData = () => {
        alternatifServices.tambah($scope.dataExcel).then(res => {
            $scope.model = {};
            pesan.Success("Berhasil mengubah data");
            $("#excel").modal('hide');
            $scope.tambah = false;
        })
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {

            if ($scope.model.id) {
                alternatifServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                    $scope.tambah = false;
                })
            } else {
                $scope.model.kriteria = $scope.kriterias;
                var penghasilan = $scope.model.kriteria.find(x=>x.nama =='Penghasilan');
                if(penghasilan){
                    penghasilan.range.forEach(element => {
                        if (element.range.charAt(0) == "<") {
                            var item = element.range.split(" ");
                            if (parseFloat($scope.model.penghasilan) <= parseFloat(item[1])) {
                                penghasilan.value = element.bobot;
                            }
                        } else if (element.range.charAt(0) == ">") {
                            var item = element.range.split(" ");
                            if (parseFloat($scope.model.penghasilan) >= parseFloat(item[1])) {
                                penghasilan.value = element.bobot;
                            }
                        } else {
                            var item = element.range.split(" - ");
                            if (parseFloat($scope.model.penghasilan) >= parseFloat(item[0]) && parseFloat($scope.model.penghasilan) <= parseFloat(item[1])) {
                                penghasilan.value = element.bobot;
                            }
                        }
                    });
                }

                var usia = $scope.model.kriteria.find(x=>x.nama =='Usia');
                if(usia){
                    usia.range.forEach(element => {
                        if (element.range.charAt(0) == "<") {
                            var item = element.range.split(" ");
                            if (parseFloat($scope.model.usia) <= parseFloat(item[1])) {
                                usia.value = element.bobot;
                            }
                        } else if (element.range.charAt(0) == ">") {
                            var item = element.range.split(" ");
                            if (parseFloat($scope.model.usia) >= parseFloat(item[1])) {
                                usia.value = element.bobot;
                            }
                        } else {
                            var item = element.range.split(" - ");
                            if (parseFloat($scope.model.usia) >= parseFloat(item[0]) && parseFloat($scope.model.usia) <= parseFloat(item[1])) {
                                usia.value = element.bobot;
                            }
                        }
                    });
                }

                alternatifServices.post($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                    $scope.tambah = false;
                })
            }
            // alternatifServices.post($scope.model).then(res => {
            // })
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
        $scope.tambah = true;
        document.getElementById("periode").focus();
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            klasifikasiServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }

    $scope.subKlasifikasi = (param) => {
        document.location.href = helperServices.url + "admin/sub_klasifikasi/data/" + param.id;
    }
}

function penilaianController($scope, penilaianServices, pesan, helperServices) {
    $scope.setTitle = "Penilaian";
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    $scope.setShow = "client";
    penilaianServices.get().then((res) => {
        $scope.datas = res;
    })
    $scope.nilai = (param) => {
        $scope.peserta = angular.copy(param);
        penilaianServices.getNilai(param.id).then(res => {
            console.log(res);
            console.log($scope.peserta);
            $scope.model = {};
            $scope.model.kriteria = res;
            $scope.model.client = $scope.peserta;
            if ($scope.peserta.statusNilai) {
                $scope.model.kriteria.forEach(element => {
                    element.value = element.sub.find(x => x.bobot == element.nilai);
                });
            }
            $scope.setShow = "penilaian";
        })
    }
    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.peserta.statusNilai) {
                penilaianServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $scope.setShow = "client";
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                penilaianServices.post($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                    $scope.setShow = "client";
                    var item = $scope.datas.find(x => x.id == $scope.peserta.id);
                    item.statusNilai = "2";
                })
            }
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
        document.getElementById("periode").focus();
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            penilaianServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }
    $scope.back = () => {
        $scope.setShow = "client";
    }
}

function hasilController($scope, hasilServices, pesan, helperServices) {
    $scope.setTitle = { header: 'Hasil Rekomendasi', sub: null };
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.model = {};
    $scope.setShow = "client";
    hasilServices.get().then((res) => {
        $scope.datas = res;
        console.log(res);
    })

    // $scope.filter = () => {
    //     // var data = $scope.datas.alternatif.filter(x=>parseFloat(x.harga)<= parseFloat($scope.model.harga));
    //     $scope.alternatif = [];
    //     console.log($scope.kriterias);
    //     var filter = $scope.model.harga ? $scope.datas.alternatif.filter(x => parseFloat(x.harga) <= parseFloat($scope.model.harga)) : $scope.datas.alternatif;
    //     filter.forEach(element => {
    //         var cek = true;
    //         element.nilai.forEach(nilai => {
    //             $scope.kriterias.forEach(kriteria => {
    //                 if (kriteria.nilai) {
    //                     if (nilai.kriteria_id == kriteria.id) {
    //                         if (kriteria.type == 'Cost') {
    //                             if (parseInt(nilai.value) > parseInt(kriteria.nilai.bobot)) {
    //                                 cek = false
    //                             }
    //                         } else {
    //                             if (parseInt(nilai.value) < parseInt(kriteria.nilai.bobot)) {
    //                                 cek = false
    //                             }
    //                         }
    //                     }
    //                 }
    //             });
    //         });
    //         if (cek) {
    //             $scope.alternatif.push(element);
    //         }
    //     });

    //     hasilServices.hitung($scope.alternatif).then(res => {
    //         $scope.hasil = res
    //         console.log(res);
    //     })

    // }
    // $scope.reset = () => {
    //     $scope.hasil = undefined;

    // }
}

function laporanController($scope, periodeServices, pesan, helperServices, laporanServices) {
    $scope.setTitle = { header: 'History', sub: null };
    $scope.$emit("SendUp", $scope.setTitle);
    $scope.datas = {};
    $scope.periodes = {};
    $scope.model = {};
    periodeServices.get().then((res) => {
        $scope.periodes = res;
    })
    $scope.hitung = (param) => {
        laporanServices.hitung(param).then(res=>{
            $scope.datas = res;
            console.log(res);
        });
    }
}
