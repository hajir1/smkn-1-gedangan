import './bootstrap';

import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Swal from 'sweetalert2';

window.Swal = Swal;
window.Alpine = Alpine;

const brand = '#1b315c';

/* -------------------------------------------------------------------------
 | Notifikasi flash dari session (dibaca dari <meta name="flash-*">),
 | menggantikan script inline window.Laravel di setiap view.
 * ---------------------------------------------------------------------- */
function showFlash() {
    const read = (name) => document.querySelector(`meta[name="flash-${name}"]`)?.content;
    const toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
    });

    if (read('success')) toast.fire({ icon: 'success', title: read('success') });
    if (read('error')) toast.fire({ icon: 'error', title: read('error') });
    if (read('info')) toast.fire({ icon: 'info', title: read('info') });
}

/* -------------------------------------------------------------------------
 | Konfirmasi hapus: <form data-confirm="Hapus data ini?">
 * ---------------------------------------------------------------------- */
document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement) || !form.dataset.confirm || form.dataset.confirmed) return;

    event.preventDefault();
    Swal.fire({
        title: 'Yakin?',
        text: form.dataset.confirm,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#e11d48',
        cancelButtonColor: brand,
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            form.dataset.confirmed = '1';
            form.submit();
        }
    });
});

/* -------------------------------------------------------------------------
 | Pratinjau gambar sebelum upload: <input type="file" data-preview="#img">
 * ---------------------------------------------------------------------- */
document.addEventListener('change', (event) => {
    const input = event.target;
    if (!(input instanceof HTMLInputElement) || !input.dataset.preview || !input.files?.[0]) return;

    const target = document.querySelector(input.dataset.preview);
    if (target) {
        target.src = URL.createObjectURL(input.files[0]);
        target.classList.remove('hidden');
        target.nextElementSibling?.classList?.add('hidden');
    }
});

document.addEventListener('DOMContentLoaded', () => {
    showFlash();
    AOS.init({ once: true, duration: 700, easing: 'ease-out-cubic', offset: 40 });
});

Alpine.start();
