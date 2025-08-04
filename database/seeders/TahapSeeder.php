<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tahap1;
use App\Models\Tahap2;
use Illuminate\Support\Str;

class TahapSeeder extends Seeder
{
    public function run()
    {
        // Buat data dummy Tahap1
        $tahap1 = Tahap1::create([
            'nama_pelaku' => 'Bintang Samudra',
            'produk' => 'Keripik Singkong',
            'klasifikasi' => 'Makanan Ringan',
            'status' => 'Masih Dibina',
            'pembina_1' => 'Dinas Perindustrian',
            'pembina_2' => 'BSN',
            'sinergi' => 'Program Kemitraan',
            'nama_kontak_person' => 'Rani',
            'no_hp' => '081234567890',
            'bulan_pertama_pembinaan' => 'Januari',
            'tahun_dibina' => '2022',
            'riwayat_pembinaan' => 'Pelatihan pengemasan, sertifikasi halal',
            'status_pembinaan' => 'Berlangsung',
            'email' => 'bintang@example.com',
            'media_sosial' => '@keripiksingkong',
            'nama_merek' => 'Singkong Crispy',
            'lspro' => 'LSPro Makanan',
            'jenis_usaha' => 'Pangan',
            'tanda_daftar_merk' => '1234567890ABC',
        ]);

        // Buat data dummy Tahap2 terkait
        Tahap2::create([
            'pelaku_usaha_id' => $tahap1->id,
            'alamat_kantor' => 'Jl. Merdeka No. 123',
            'provinsi_kantor' => 'Jawa Barat',
            'kota_kantor' => 'Bandung',
            'alamat_pabrik' => 'Jl. Industri No. 45',
            'provinsi_pabrik' => 'Jawa Barat',
            'kota_pabrik' => 'Bandung',
            'legalitas_usaha' => 'CV',
            'tahun_pendirian' => '2020',
            'omzet' => 250000000,
            'volume_per_tahun' => 12000,
            'jumlah_tenaga_kerja' => 15,
            'jangkauan_pemasaran' => json_encode(['Lokal', 'Nasional']),
            'link_dokumen' => 'https://example.com/dokumen',
            'foto_produk' => json_encode(['uploads/foto_produk/produk1.jpg']),
            'foto_tempat_produksi' => json_encode(['uploads/foto_tempat_produksi/tempat1.jpg']),
            'instansi' => 'BSN, BPOM',
            'sertifikat' => json_encode(['Sertifikat Halal', 'Sertifikat SNI']),
            'sni_yang_diterapkan' => 'SNI 1234:2021',
            'gruping' => 'Makanan Lokal',
        ]);
    }
}
