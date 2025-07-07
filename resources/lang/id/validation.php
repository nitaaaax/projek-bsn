<?php

return [

    'accepted'             => 'Kolom :attribute harus diterima.',
    'active_url'           => 'Kolom :attribute bukan URL yang valid.',
    'after'                => 'Kolom :attribute harus berisi tanggal setelah :date.',
    'after_or_equal'       => 'Kolom :attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'                => 'Kolom :attribute hanya boleh berisi huruf.',
    'alpha_dash'           => 'Kolom :attribute hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num'            => 'Kolom :attribute hanya boleh berisi huruf dan angka.',
    'array'                => 'Kolom :attribute harus berupa array.',
    'before'               => 'Kolom :attribute harus berisi tanggal sebelum :date.',
    'before_or_equal'      => 'Kolom :attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => 'Kolom :attribute harus antara :min dan :max.',
        'file'    => 'Kolom :attribute harus antara :min dan :max kilobyte.',
        'string'  => 'Kolom :attribute harus antara :min dan :max karakter.',
        'array'   => 'Kolom :attribute harus memiliki antara :min dan :max item.',
    ],
    'boolean'              => 'Kolom :attribute harus bernilai true atau false.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'date'                 => 'Kolom :attribute bukan tanggal yang valid.',
    'date_equals'          => 'Kolom :attribute harus sama dengan tanggal :date.',
    'date_format'          => 'Kolom :attribute tidak cocok dengan format :format.',
    'different'            => 'Kolom :attribute dan :other harus berbeda.',
    'digits'               => 'Kolom :attribute harus :digits digit.',
    'digits_between'       => 'Kolom :attribute harus antara :min dan :max digit.',
    'email'                => 'Kolom :attribute harus berupa alamat email yang valid.',
    'exists'               => 'Kolom :attribute tidak valid.',
    'file'                 => 'Kolom :attribute harus berupa berkas.',
    'filled'               => 'Kolom :attribute wajib diisi.',
    'gt'                   => [
        'numeric' => 'Kolom :attribute harus lebih besar dari :value.',
        'file'    => 'Kolom :attribute harus lebih besar dari :value kilobyte.',
        'string'  => 'Kolom :attribute harus lebih dari :value karakter.',
        'array'   => 'Kolom :attribute harus memiliki lebih dari :value item.',
    ],
    'gte'                  => [
        'numeric' => 'Kolom :attribute harus lebih besar atau sama dengan :value.',
        'file'    => 'Kolom :attribute harus lebih besar atau sama dengan :value kilobyte.',
        'string'  => 'Kolom :attribute harus lebih besar atau sama dengan :value karakter.',
        'array'   => 'Kolom :attribute harus memiliki :value item atau lebih.',
    ],
    'image'                => 'Kolom :attribute harus berupa gambar.',
    'in'                   => 'Kolom :attribute tidak valid.',
    'integer'              => 'Kolom :attribute harus berupa angka bulat.',
    'ip'                   => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'json'                 => 'Kolom :attribute harus berupa JSON string yang valid.',
    'max'                  => [
        'numeric' => 'Kolom :attribute tidak boleh lebih dari :max.',
        'file'    => 'Kolom :attribute tidak boleh lebih dari :max kilobyte.',
        'string'  => 'Kolom :attribute tidak boleh lebih dari :max karakter.',
        'array'   => 'Kolom :attribute tidak boleh lebih dari :max item.',
    ],
    'min'                  => [
        'numeric' => 'Kolom :attribute minimal bernilai :min.',
        'file'    => 'Kolom :attribute minimal berukuran :min kilobyte.',
        'string'  => 'Kolom :attribute minimal :min karakter.',
        'array'   => 'Kolom :attribute minimal memiliki :min item.',
    ],
    'not_in'               => 'Kolom :attribute tidak valid.',
    'numeric'              => 'Kolom :attribute harus berupa angka.',
    'present'              => 'Kolom :attribute harus ada.',
    'regex'                => 'Format kolom :attribute tidak valid.',
    'required'             => 'Kolom :attribute wajib diisi.',
    'required_if'          => 'Kolom :attribute wajib diisi jika :other adalah :value.',
    'required_unless'      => 'Kolom :attribute wajib diisi kecuali :other ada dalam :values.',
    'required_with'        => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_without'     => 'Kolom :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Kolom :attribute wajib diisi bila tidak ada satupun dari :values yang ada.',
    'same'                 => 'Kolom :attribute dan :other harus sama.',
    'size'                 => [
        'numeric' => 'Kolom :attribute harus berukuran :size.',
        'file'    => 'Kolom :attribute harus berukuran :size kilobyte.',
        'string'  => 'Kolom :attribute harus berukuran :size karakter.',
        'array'   => 'Kolom :attribute harus mengandung :size item.',
    ],
    'string'               => 'Kolom :attribute harus berupa teks.',
    'timezone'             => 'Kolom :attribute harus berupa zona waktu yang valid.',
    'unique'               => 'Kolom :attribute sudah digunakan.',
    'url'                  => 'Format kolom :attribute tidak valid.',
    'uuid'                 => 'Kolom :attribute harus UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    */
    'custom' => [
        'nama_pelaku' => [
            'required' => 'Nama pelaku wajib diisi.',
        ],
        'produk' => [
            'required' => 'Nama produk wajib diisi.',
        ],
        'klasifikasi' => [
            'required' => 'Klasifikasi wajib diisi.',
        ],
        'status' => [
            'required' => 'Status wajib diisi.',
        ],
        'provinsi' => [
            'required' => 'Provinsi wajib diisi.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    */
    'attributes' => [
        'nama_pelaku' => 'nama pelaku',
        'produk' => 'produk',
        'klasifikasi' => 'klasifikasi',
        'status' => 'status',
        'provinsi' => 'provinsi',
    ],

];
