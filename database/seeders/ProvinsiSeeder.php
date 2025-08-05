<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provinsi;
use App\Models\Kota;

class ProvinsiSeeder extends Seeder
{
    public function run(): void
    {
        $riau = Provinsi::create(['nama' => 'Riau']);
        $sumbar = Provinsi::create(['nama' => 'Sumatera Barat']);

        $kotaRiau = [
            'Pekanbaru', 'Dumai', 'Kampar', 'Indragiri Hulu', 'Indragiri Hilir',
            'Pelalawan', 'Kuantan Singingi', 'Rokan Hulu', 'Rokan Hilir',
            'Bengkalis', 'Siak', 'Kepulauan Meranti'
        ];

        $kotaSumbar = [
            'Padang', 'Padang Panjang', 'Bukittinggi', 'Payakumbuh', 'Pariaman',
            'Sawahlunto', 'Solok', 'Kabupaten Agam', 'Kabupaten Lima Puluh Kota',
            'Kabupaten Padang Pariaman', 'Kabupaten Pasaman', 'Kabupaten Pasaman Barat',
            'Kabupaten Pesisir Selatan', 'Kabupaten Sijunjung', 'Kabupaten Solok',
            'Kabupaten Solok Selatan', 'Kabupaten Tanah Datar', 'Kabupaten Dharmasraya',
            'Kabupaten Kepulauan Mentawai'
        ];

        foreach ($kotaRiau as $namaKota) {
            Kota::create([
                'provinsi_id' => $riau->id,
                'nama' => $namaKota
            ]);
        }

        foreach ($kotaSumbar as $namaKota) {
            Kota::create([
                'provinsi_id' => $sumbar->id,
                'nama' => $namaKota
            ]);
        }
    }
}
