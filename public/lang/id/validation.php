<?php

return [

    'accepted'             => ':attribute harus diterima.',
    'active_url'           => ':attribute bukan URL yang valid.',
    'after'                => ':attribute harus tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus tanggal setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'alpha_num'            => ':attribute hanya boleh berisi huruf dan angka.',
    'array'                => ':attribute harus berupa array.',
    'before'               => ':attribute harus tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':attribute harus antara :min dan :max.',
        'file'    => ':attribute harus antara :min dan :max kilobita.',
        'string'  => ':attribute harus antara :min dan :max karakter.',
        'array'   => ':attribute harus antara :min dan :max item.',
    ],
    'boolean'              => ':attribute harus true atau false.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => ':attribute bukan tanggal yang valid.',
    'date_equals'          => ':attribute harus tanggal yang sama dengan :date.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus :digits digit.',
    'digits_between'       => ':attribute harus antara :min dan :max digit.',
    'dimensions'           => ':attribute memiliki dimensi gambar yang tidak valid.',
    'distinct'             => ':attribute memiliki nilai yang duplikat.',
    'email'                => ':attribute harus berupa alamat email yang valid.',
    'ends_with'            => ':attribute harus diakhiri dengan salah satu dari berikut: :values.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'file'                 => ':attribute harus berupa file.',
    'filled'               => ':attribute harus memiliki nilai.',
    'gt'                   => [
        'numeric' => ':attribute harus lebih besar dari :value.',
        'file'    => ':attribute harus lebih besar dari :value kilobita.',
        'string'  => ':attribute harus lebih besar dari :value karakter.',
        'array'   => ':attribute harus lebih banyak dari :value item.',
    ],
    'gte'                  => [
        'numeric' => ':attribute harus lebih besar atau sama dengan :value.',
        'file'    => ':attribute harus lebih besar atau sama dengan :value kilobita.',
        'string'  => ':attribute harus lebih besar atau sama dengan :value karakter.',
        'array'   => ':attribute harus :value item atau lebih.',
    ],
    'image'                => ':attribute harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => ':attribute tidak ada dalam :other.',
    'integer'              => ':attribute harus berupa bilangan bulat.',
    'ip'                   => ':attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => ':attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => ':attribute harus berupa string JSON yang valid.',
    'lt'                   => [
        'numeric' => ':attribute harus kurang dari :value.',
        'file'    => ':attribute harus kurang dari :value kilobita.',
        'string'  => ':attribute harus kurang dari :value karakter.',
        'array'   => ':attribute harus kurang dari :value item.',
    ],
    'lte'                  => [
        'numeric' => ':attribute harus kurang atau sama dengan :value.',
        'file'    => ':attribute harus kurang atau sama dengan :value kilobita.',
        'string'  => ':attribute harus kurang atau sama dengan :value karakter.',
        'array'   => ':attribute tidak boleh lebih dari :value item.',
    ],
    'max'                  => [
        'numeric' => ':attribute maksimal :max.',
        'file'    => ':attribute maksimal :max kilobita.',
        'string'  => ':attribute maksimal :max karakter.',
        'array'   => ':attribute maksimal :max item.',
    ],
    'mimes'                => ':attribute harus berupa file dengan tipe: :values.',
    'mimetypes'            => ':attribute harus berupa file dengan tipe: :values.',
    'min'                  => [
        'numeric' => ':attribute minimal :min.',
        'file'    => ':attribute minimal :min kilobita.',
        'string'  => ':attribute minimal :min karakter.',
        'array'   => ':attribute minimal :min item.',
    ],
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => ':attribute format tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'present'              => ':attribute harus ada.',
    'regex'                => ':attribute format tidak valid.',
    'required'             => ':attribute wajib diisi.',
    'required_if'          => ':attribute wajib diisi jika :other adalah :value.',
    'required_unless'      => ':attribute wajib diisi kecuali :other adalah :values.',
    'required_with'        => ':attribute wajib diisi jika :values ada.',
    'required_with_all'    => ':attribute wajib diisi jika semua :values ada.',
    'required_without'     => ':attribute wajib diisi jika :values tidak ada.',
    'required_without_all' => ':attribute wajib diisi jika tidak ada :values yang ada.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => ':attribute harus :size.',
        'file'    => ':attribute harus :size kilobita.',
        'string'  => ':attribute harus :size karakter.',
        'array'   => ':attribute harus mengandung :size item.',
    ],
    'starts_with'          => ':attribute harus diawali dengan salah satu dari berikut: :values.',
    'string'               => ':attribute harus berupa string.',
    'timezone'             => ':attribute harus berupa zona waktu yang valid.',
    'unique'               => ':attribute sudah digunakan.',
    'uploaded'             => ':attribute gagal diunggah.',
    'url'                  => ':attribute format tidak valid.',
    'uuid'                 => ':attribute harus berupa UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk mengubah nama atribut menjadi bahasa yang lebih user-friendly
    |
    */

    'attributes' => [
        'nama_produk' => 'nama produk',
        'deskripsi' => 'deskripsi',
        'harga' => 'harga',
        'stok' => 'stok',
        'kategori_id' => 'kategori',
        'nama' => 'nama',
    ],

];
