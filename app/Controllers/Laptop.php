<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;

class Laptop extends BaseController
{
    use ResponseTrait;
    protected $kriteria;
    protected $range;
    protected $decode;
    protected $alternatif;
    protected $preferensi;
    protected $db;
    protected $periode;
    public function __construct()
    {
        $this->kriteria = new \App\Models\KriteriaModel();
        $this->range = new \App\Models\RangeModel();
        $this->decode = new \App\Libraries\Decode();
        $this->alternatif = new \App\Models\AlternatifModel();
        $this->preferensi = new \App\Models\PreferensiModel();
        $this->db = \Config\Database::connect();
        $this->periode = new \App\Models\PeriodeModel();
    }
    public function index()
    {
        $data['alternatif'] = $this->alternatif->asObject()->findAll();
        $preferensi = $this->preferensi
            ->select("preferensi.*, kriteria.nama, sub.range")
            ->join('kriteria', 'kriteria.id=preferensi.kriteria_id')
            ->join('sub', 'kriteria.id=sub.kriteria_id')
            ->where("preferensi.value=sub.bobot")
            ->findAll();
        foreach ($data['alternatif'] as $key => $value) {
            $value->nilai = [];
            foreach ($preferensi as $key => $pre) {
                if ($value->id == $pre['alternatif_id']) {
                    $value->nilai[] = $pre;
                }
            }
        }
        return view('laptop', $data);
    }


    public function read()
    {
        try {
            $data['alternatif'] = $this->alternatif->asObject()->findAll();
            $preferensi = $this->preferensi
                ->select("preferensi.*, kriteria.nama, sub.range")
                ->join('kriteria', 'kriteria.id=preferensi.kriteria_id')
                ->join('sub', 'kriteria.id=sub.kriteria_id')
                ->where("preferensi.value=sub.bobot")
                ->findAll();
            foreach ($data['alternatif'] as $key => $value) {
                $value->nilai = [];
                foreach ($preferensi as $key => $pre) {
                    if ($value->id == $pre['alternatif_id']) {
                        $value->nilai[] = $pre;
                    }
                }
            }
            return $this->respond($data['alternatif']);
        } catch (\Throwable $th) {
            return $this->fail($th->getMessage());
        }
    }

    public function post()
    {
        $data = $this->request->getJSON();
        try {
            $this->db->transException(true)->transStart();
            $this->alternatif->insert($data);
            $data->id = $this->alternatif->getInsertID();
            $preferensi = [];
            foreach ($data->kriteria as $key => $value) {
                if ($value->nama == 'Harga') {
                    $item = ['kriteria_id' => $value->id, 'alternatif_id' => $data->id, 'value' => $value->value, 'bobot' => $value->bobot, 'nama' => $value->nama];
                } else {
                    $item = ['kriteria_id' => $value->id, 'alternatif_id' => $data->id, 'value' => $value->value, 'bobot' => $value->bobot, 'nama' => $value->nama,  'range' => $value->nominal];
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
    public function put()
    {
        try {
            $data = $this->request->getJSON();
            if ($this->kriteria->update($data->id, $data)) {
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
    protected function toJson(string $file): array
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(TRUE);

        // setting nama file yg akan dibaca
        $spreadsheet = $reader->load("berkas/" . $file);

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
        for ($col = 'A'; $col <= "B"; $col++) {
            $colsName[] =  $worksheet->getCell($col . 1)->getValue();
        }
        $colsName[] =  "bobot";

        // inisialisasi array untuk menampung semua data
        $dataAll = array();
        for ($row = 1; $row < $highestRow; $row++) {
            $item = [
                'nama' => $worksheet->getCell("A" . $row + 1)->getValue(),
                'kode' => $worksheet->getCell("B" . $row + 1)->getValue(),
                'nilai' => array()
            ];
            for ($col = "C"; $col <= $highestColumn; $col++) {
                $nilai = [
                    'kode' => $worksheet->getCell($col . "1")->getValue(),
                    'value' => floatval($worksheet->getCell($col . $row + 1)->getValue()),
                ];
                array_push($item['nilai'], $nilai);
            }
            array_push($dataAll, $item);
        }

        return $dataAll;
    }
}
