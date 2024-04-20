<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Alternatif extends BaseController
{
    use ResponseTrait;
    protected $kriteria;
    protected $range;
    protected $decode;
    protected $alternatif;
    protected $preferensi;
    protected $db;
    protected $periode;
    protected $code;
    public function __construct()
    {
        $this->kriteria = new \App\Models\KriteriaModel();
        $this->range = new \App\Models\RangeModel();
        $this->decode = new \App\Libraries\Decode();
        $this->alternatif = new \App\Models\AlternatifModel();
        $this->preferensi = new \App\Models\PreferensiModel();
        $this->db = \Config\Database::connect();
        $this->periode = new \App\Models\PeriodeModel();
        $this->code = new \App\Libraries\Decode();
    }
    public function index()
    {
        return view('alternatif');
    }

    public function set_data()
    {
        try {
            $data= $this->request->getJSON();
            return $this->respond($item = $this->toJson($this->decode->decodebase64($data->base64)));
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
        
    }

    public function range($id = null)
    {
        return view('kriteria');
    }

    public function read()
    {
        try {
            $data['kriteria'] = $this->kriteria->asObject()->findAll();
            $range = $this->range->asObject()->findAll();
            foreach ($data['kriteria'] as $key => $value) {
                $value->range = [];
                foreach ($range as $key => $r) {
                    if($value->id==$r->kriteria_id){
                        $value->range[]= $r;
                    }
                }
            }
            $data['alternatif'] = $this->alternatif->asObject()->select('alternatif.*')->join('periode', 'periode.id = alternatif.periode_id')->where('periode.status', '1')->findAll();
            $preferensi = $this->preferensi
            ->select("preferensi.*, kriteria.nama, sub.range")
            ->join('periode', 'periode.id = preferensi.periode_id')
            ->join('kriteria', 'kriteria.id=preferensi.kriteria_id')
            ->join('sub', 'kriteria.id=sub.kriteria_id')
            ->where("preferensi.value=sub.bobot")
            ->where('status', '1')
            ->findAll();
            foreach ($data['alternatif'] as $key => $value) {
                $value->nilai = [];
                foreach ($preferensi as $key => $pre) {
                    if($value->id == $pre['alternatif_id']){
                        $value->nilai[] = $pre;
                    }
                }
            }
            return $this->respond($data);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->db->transException(true)->transStart();
            $periode = $this->periode->asObject()->where('status', '1')->first();
            $data->periode_id = $periode->id;
            $this->alternatif->insert($data);
            $data->id = $this->alternatif->getInsertID();
            $preferensi = [];
            foreach ($data->kriteria as $key => $value) {
                if($value->nama=='Penghasilan' || $value->nama=='Usia'){
                    $item = ['kriteria_id'=>$value->id, 'alternatif_id'=>$data->id, 'value'=>$value->value, 'bobot'=>$value->bobot, 'nama'=>$value->nama, 'periode_id'=>$periode->id];
                }else{
                    $item = ['kriteria_id'=>$value->id, 'alternatif_id'=>$data->id, 'value'=>$value->value, 'bobot'=>$value->bobot, 'nama'=>$value->nama,  'range'=>$value->nominal, 'periode_id'=>$periode->id];
                }
                $preferensi[] = $item;
            }
            $this->preferensi->insertBatch($preferensi);
            $data->nilai = $preferensi;
            $this->db->transComplete();
            return $this->respondCreated($data);
        } catch (DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function tambah()
    {
        $datas = $this->request->getJSON();
        try {
            $this->db->transException(true)->transStart();
            $periode = $this->periode->asObject()->where('status', '1')->first();
            foreach ($datas as $key => $data) {
                $data->periode_id = $periode->id;
                $this->alternatif->insert($data);
                $data->id = $this->alternatif->getInsertID();
                $preferensi = [];
                foreach ($data->kriteria as $key => $value) {
                    if($value->nama=='Penghasilan' || $value->nama=='Usia'){
                        $item = ['kriteria_id'=>$value->id, 'alternatif_id'=>$data->id, 'value'=>$value->value, 'bobot'=>$value->bobot, 'nama'=>$value->nama, 'periode_id'=>$periode->id];
                    }else{
                        $item = ['kriteria_id'=>$value->id, 'alternatif_id'=>$data->id, 'value'=>$value->value, 'bobot'=>$value->bobot, 'nama'=>$value->nama,  'range'=>$value->nominal, 'periode_id'=>$periode->id];
                    }
                    $preferensi[] = $item;
                }
                $this->preferensi->insertBatch($preferensi);
                $data->nilai = $preferensi;
            }
            $this->db->transComplete();
            return $this->respondCreated($datas);
        } catch (DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
    }

    public function put()
    {
        try {
            $data = $this->request->getJSON();
            $data->gambar = $this->code->decodebase64($data->berkas->base64);
            if ($this->alternatif->update($data->id, $data)) {
                return $this->respondUpdated(true);
            }
            throw new \Exception("Gagal mengubah", 1);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    public function deleted($id = null)
    {
        try {
            if ($this->kriteria->delete($id));
            return $this->respondDeleted(true);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }
    protected function toJson(string $file):array
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);

        // setting nama file yg akan dibaca
        $spreadsheet = $reader->load("berkas/".$file);

        // data worksheet yg akan dibaca ada di active sheet
        $worksheet = $spreadsheet->getActiveSheet();

        // mendapatkan maks nomor baris data
        $highestRow = $worksheet->getHighestRow();
        // mendapatkan maks kolom data
        $highestColumn = $worksheet->getHighestColumn();

        // mendapatkan nama-nama kolom data 
        // membaca value yang ada di cell: A1, B1, ..., E1
        // dan simpan ke dalam array $colsName
        $colsName = array();
        for ($col = 'A'; $col <= "D"; $col++) {
            $colsName[] =  $worksheet->getCell($col . 1)->getValue();
        }
        $colsName[] =  "bobot";

        // inisialisasi array untuk menampung semua data
        $dataAll = array();
        for ($row=1; $row < $highestRow ; $row++) { 
            $item = [
                'nik' => $worksheet->getCell("A" . $row+1)->getValue(),
                'nama' => $worksheet->getCell("B" . $row+1)->getValue(),
                'alamat' => $worksheet->getCell("C" . $row+1)->getValue(),
                'kontak' => $worksheet->getCell("D" . $row+1)->getValue(),
                'nilai' => array()
            ];
            $num = 1;
            for ($col="E"; $col <= $highestColumn ; $col++) { 
                $nilai = [
                    'kode' => "C".$num,
                    'nama' => $worksheet->getCell($col . "1")->getValue(),
                    'range' => $worksheet->getCell($col . $row+1)->getValue(),
                ];
                array_push($item['nilai'], $nilai);
                $num ++;
            }
            array_push($dataAll, $item);
        }

        return $dataAll;
    }
}
