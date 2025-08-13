<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function forbidden()
    {
        // Simpan URL sebelumnya supaya bisa kasih tombol "Kembali"
        if (url()->previous() !== url()->current()) {
            session(['last_non_error_url' => url()->previous()]);
        }

        return response()->view('errors.custom.403', [], 403);
    }

    public function notFound()
    {
        if (url()->previous() !== url()->current()) {
            session(['last_non_error_url' => url()->previous()]);
        }

        return response()->view('errors.404', [], 404);
    }
}
