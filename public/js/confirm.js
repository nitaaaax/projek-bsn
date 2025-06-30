function confirmDelete(id) {
    Swal.fire({
        title: 'Yakin mau hapus?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}

function showEditModal(a) {

    const id_produk = a.getAttribute('data-id');
    const judul = a.getAttribute('data-judul');
    const kategori = a.getAttribute('data-kategori');
    const harga = a.getAttribute('data-harga');
    const stok = a.getAttribute('data-stok');
    const isi = a.getAttribute('data-isi');
    const gambar = a.getAttribute('data-gambar');
    console.log(a);
    document.getElementById('editId').value = gambar;
    document.getElementById('judul_edit').value = judul;
    document.getElementById('kategori_edit').value = kategori;
    // $('#kategori_edit').val(kategori);
    document.getElementById('harga_edit').value = harga;
    document.getElementById('stok_edit').value = stok;
   // Menampilkan gambar lama jika ada
        if (gambar) {
            console.log(gambar);
            $('#currentImageContainer').html('<img src="'+gambar+'" width="100">');
        } else {
            $('#currentImageContainer').html('');
        }
 // Isi Summernote
    $('textarea[name="isi_edit"]').summernote('code', isi);
    document.getElementById('editForm').action = `/products/${id_produk}`;

    let editModal = new bootstrap.Modal(document.getElementById('modal-edit'));
    editModal.show();
}

// Fungsi untuk konfirmasi saat submit form
function handleFormSubmit(e) {
    e.preventDefault();
    const form = e.target;

    Swal.fire({
        title: 'Yakin ingin menyimpan perubahan?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();  // Kirim form jika konfirmasi dari SweetAlert
        }
    });
}


// Menangani submit form edit
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editForm');
    form.addEventListener('submit', handleFormSubmit);
  
});