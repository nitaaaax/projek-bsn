document.addEventListener('DOMContentLoaded', function () {
    const actionButtons = document.querySelectorAll('.btn-action');

    actionButtons.forEach(button => {
        button.addEventListener('click', function () {
            const action = this.dataset.action; // Ambil aksi (delete, update, dll)
            const entityId = this.dataset.id;  // Ambil id entity (produk, kategori, dll)
            const rowId = this.dataset.rowId;  // Id baris untuk dihapus dari DOM (jika hapus)

            let message = '';
            let url = '';

            // Tentukan message dan URL berdasarkan aksi
            if (action === 'delete') {
                message = "Data akan dihapus secara permanen.";
                url = this.dataset.url; // Gunakan URL yang diteruskan lewat data-attributes
            } else if (action === 'update') {
                message = "Apakah Anda ingin mengupdate data ini?";
                url = this.dataset.url;
            }

            // Konfirmasi menggunakan SweetAlert
            Swal.fire({
                title: `Yakin ingin ${action === 'delete' ? 'menghapus' : 'mengupdate'}?`,
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: action === 'delete' ? 'Ya, hapus!' : 'Ya, update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirim request menggunakan fetch API
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ _method: action === 'delete' ? 'DELETE' : 'PUT' })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Jika hapus, hilangkan baris dari DOM
                            if (action === 'delete') {
                                document.getElementById(rowId).remove();
                            }

                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                           // window.location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: data.message,
                            });
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat melakukan aksi.',
                        });
                    });
                }
            });
        });
    });
});

