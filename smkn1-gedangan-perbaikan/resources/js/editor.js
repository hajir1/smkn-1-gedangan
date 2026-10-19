// Editor konten (Quill) — dibundel lewat Vite, hanya dimuat di halaman form admin.
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

document.querySelectorAll('[data-quill]').forEach((el) => {
    const input = document.getElementById(el.dataset.quill);
    const quill = new Quill(el, {
        theme: 'snow',
        placeholder: 'Tulis konten di sini...',
        modules: {
            toolbar: [
                [{ header: [2, 3, 4, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ align: [] }],
                [{ color: [] }, { background: [] }],
                [{ indent: '-1' }, { indent: '+1' }],
                ['blockquote', 'link'],
                ['clean'],
            ],
        },
    });

    el.closest('form').addEventListener('submit', () => {
        input.value = quill.getText().trim().length ? quill.root.innerHTML : '';
    });
});
