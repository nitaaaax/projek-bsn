<?php

namespace App\Imports;

use App\Models\Tahap1;
use App\Models\Tahap2;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UmkmImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Map Excel headers ke field DB tahap1
            $tahap1Data = [
                'nama_pelaku'         => $row['nama_umkm'] ?? null,
                'produk'              => $row['merk_produk'] ?? null,
                'klasifikasi'         => $row['klasifikasi'] ?? null,
                'status'              => $row['status'] ?? null,
                'pembina_1'           => $row['pembina_1'] ?? null,
                'pembina_2'           => $row['pembina_2'] ?? null,
                'lspro'               => $row['lspro'] ?? null,
                'sinergi'             => $row['sinergi'] ?? null,
                'nama_kontak_person'  => $row['nama_kontak_person'] ?? null,
                'no_hp'               => $this->normalizeNoHp($row['no_hp'] ?? null),
                'bulan_pertama_pembinaan' => $row['bulan_pembinaan_pertama'] ?? null,
                'tahun_dibina'        => $this->normalizeTahun($row['tahun_dibina'] ?? null),
                'jenis_usaha'         => $this->normalizeJenisUsaha($row['jenis_usaha'] ?? null),
                'riwayat_pembinaan'   => json_encode($this->normalizeArray($row['riwayat_pembinaan'] ?? null)),
                'status_pembinaan'    => $row['status_pembinaan'] ?? null,
                'email'               => $row['email'] ?? null,
                'media_sosial'        => $row['media_sosial'] ?? null,
                'nama_merek'          => $row['merk_produk'] ?? null,
                'tanda_daftar_merk'   => $row['tanda_daftar_merek'] ?? null,
            ];

            $tahap1 = Tahap1::create($tahap1Data);

            // Map Excel headers ke field DB tahap2
            foreach ($rows as $row) {
                // Simpan dulu normalisasi link dokumen dan json encode-nya di variabel
                $linkDokumen = $this->normalizeLinkDokumen(
                    $row['upload_legalitas_nib_dan_halal'] ?? null,
                    $row['upload_legalitas_izin_edar'] ?? null
                );

                // Kalau mau simpan satu key gabungan JSON:
                $jsonLinkDokumen = json_encode($linkDokumen);

                // Atau simpan masing-masing di key berbeda (kalau struktur DB memungkinkan):
                $jsonNibHalal = json_encode($linkDokumen['nib_dan_halal'] ?? []);
                $jsonIzinEdar = json_encode($linkDokumen['izin_edar'] ?? []);

                // Setelah itu baru buat array data tahap2
                $tahap2Data = [
                    'pelaku_usaha_id'      => $tahap1->id,
                    'alamat_kantor'        => $row['alamat'] ?? null,
                    'provinsi_kantor'      => $row['provinsi_kantor'] ?? null,
                    'kota_kantor'          => $row['kota_kantor'] ?? null,
                    'alamat_pabrik'        => $row['alamat'] ?? null,
                    'provinsi_pabrik'      => $row['provinsi_pabrik'] ?? null,
                    'kota_pabrik'          => $row['kota_pabrik'] ?? null,
                    'legalitas_usaha'      => json_encode($this->normalizeArray($row['legalitas_usaha_yang_dimiliki'] ?? null)),
                    'tahun_pendirian'      => $this->normalizeTahun($row['tahun_pendirian'] ?? null),
                    'omzet'                => $this->normalizeInteger($row['permodalan'] ?? null),
                    'volume_per_tahun'     => $this->normalizeInteger($row['volume_per'] ?? null),
                    'jumlah_tenaga_kerja'  => $this->normalizeInteger($row['jumlah_tenaga_kerja'] ?? null),
                    'jangkauan_pemasaran'  => json_encode($this->normalizeArray($row['jangkauan_distribusi_dan_pemasaran'] ?? null)),

                    // Contoh kalau mau simpan 1 key gabungan JSON:
                    'link_dokumen'         => $jsonLinkDokumen,

                    // Jika kamu mau simpan terpisah, bisa juga:
                    // 'link_dokumen_nib_dan_halal' => $jsonNibHalal,
                    // 'link_dokumen_izin_edar'     => $jsonIzinEdar,

                    'foto_produk'          => json_encode([]),
                    'foto_tempat_produksi' => json_encode([]),
                    'sni_yang_diterapkan'  => $row['sni_terkait'] ?? null,
                    'instansi'             => json_encode([]),
                    'sertifikat'           => json_encode($this->normalizeSertifikat($row['sertifikat_lain_yang_dimiliki'] ?? null)),
                    'gruping'              => $row['gruping'] ?? null,
                ];

                Tahap2::create($tahap2Data);
            }
        }
    }
    // Helper untuk ambil value dari row dengan key Excel, default null kalau tidak ada
    private function getValue($row, $key)
    {
        if (is_array($row)) {
            return $row[$key] ?? null;
        } elseif ($row instanceof Collection) {
            return $row->get($key, null);
        }
        return null;
    }

    private function normalizeTahun($value)
    {
        if (is_string($value) && preg_match('/\d{4}/', $value, $matches)) {
            return $matches[0];
        }
        return null;
    }

    protected function normalizeSertifikat(?string $input): array
    {
        // Daftar sertifikat valid
        $validSertifikat = ['PIRT', 'MD', 'Halal', 'Lainnya'];

        if (!$input) {
            return [];
        }

        $items = array_map('trim', explode(',', $input));

        $result = [];
        foreach ($items as $item) {
            // Cari yang valid (case insensitive)
            foreach ($validSertifikat as $valid) {
                if (strcasecmp($item, $valid) === 0) {
                    $result[] = $valid;
                    break;
                }
            }
        }

        return array_values(array_unique($result));
    }

        /**
     * Normalize data upload legalitas dokumen.
     * 
     * @param  string|null $nibHalal  Isi dari kolom upload_legalitas_nib_dan_halal
     * @param  string|null $izinEdar  Isi dari kolom upload_legalitas_izin_edar
     * @return array
     */
    private function normalizeLinkDokumen($nibHalal, $izinEdar)
    {
        $result = [];

        // Pisahkan berdasarkan koma dan hilangkan spasi
        $nibHalalList = is_string($nibHalal) ? array_map('trim', explode(',', $nibHalal)) : (array) $nibHalal;
        $izinEdarList = is_string($izinEdar) ? array_map('trim', explode(',', $izinEdar)) : (array) $izinEdar;

        // Gabungkan semua link
        $result = array_merge(
            array_filter($nibHalalList), // buang yang kosong
            array_filter($izinEdarList)
        );

        // Hapus duplikat dan reindex
        return array_values(array_unique($result));
    }


    private function normalizeNoHp($value)
    {
        if (!$value) return null;
        $clean = preg_replace('/\D/', '', $value);
        return substr($clean, 0, 20);
    }

    private function normalizeInteger($value)
    {
        if (!$value) return null;
        $number = preg_replace('/\D/', '', $value);
        return $number !== '' ? (int)$number : null;
    }

    private function normalizeArray($value)
    {
        if (!$value) return [];
        if (is_array($value)) return $value;
        return array_filter(array_map('trim', explode(',', $value)));
    }

    private function normalizeJenisUsaha($value)
    {
        if (!$value) return null;
        $value = strtolower(trim($value));
        if (in_array($value, ['pangan', 'p'])) return 'Pangan';
        if (in_array($value, ['nonpangan', 'non-pangan', 'np'])) return 'Nonpangan';
        return null;
    }
}
