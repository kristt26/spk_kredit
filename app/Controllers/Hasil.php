<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use ocs\spklib\Moora as moora;

class Hasil extends BaseController
{
    use ResponseTrait;
    protected $periode;
    protected $kriteria;
    protected $client;
    protected $preferensi;
    protected $alternatif;
    protected $range;
    public function __construct()
    {
        $this->periode = new \App\Models\PeriodeModel();
        $this->kriteria = new \App\Models\KriteriaModel();
        $this->client = new \App\Models\ClientModel();
        $this->preferensi = new \App\Models\PreferensiModel();
        $this->alternatif = new \App\Models\AlternatifModel();
        $this->range = new \App\Models\RangeModel();
    }
    public function index()
    {
        return view('hasil');
    }

    public function read()
    {
        $periode = $this->periode->asObject()->where('status', '1')->first();
        $data['kriteria'] = $this->kriteria->asObject()->findAll();
        $range = $this->range->asObject()->findAll();
        foreach ($data['kriteria'] as $key => $value) {
            $value->range = [];
            foreach ($range as $key => $r) {
                if ($value->id == $r->kriteria_id) {
                    $value->range[] = $r;
                }
            }
        }
        $data['alternatif'] = $this->alternatif->asObject()->where('periode_id', $periode->id)->findAll();
        $preferensi = $this->preferensi
            ->select("preferensi.*, kriteria.nama, sub.range")
            ->join('kriteria', 'kriteria.id=preferensi.kriteria_id')
            ->join('sub', 'kriteria.id=sub.kriteria_id')
            ->where("preferensi.value=sub.bobot")
            ->where('periode_id', $periode->id)
            ->findAll();
        foreach ($data['alternatif'] as $key => $value) {
            $value->nilai = [];
            foreach ($preferensi as $key => $pre) {
                if ($value->id == $pre['alternatif_id']) {
                    $value->nilai[] = $pre;
                }
            }
        }
        $hasil = $this->hitung($data['alternatif']);
        return $this->respond($hasil);
    }

    public function hitung($param)
    {
        try {
            $kriterias = $this->kriteria->findAll();
            $result = [];
            $data = $param;
            foreach ($data as $key => $value) {
                foreach ($value->nilai as $key1=>$nilai) {
                    $value->nilai[$key1]['bobot'] = $nilai['value'];
                    foreach ($kriterias as $key => $kriteria) {
                        if($nilai['kriteria_id'] == $kriteria['id']){
                            $value->nilai[$key]['kode'] = $kriteria['kode'];
                        }
                    }
                }
            }
            $result = json_decode(json_encode($data), true);
            $htg = new moora($kriterias, $result, 7);
            return $htg;
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
}
