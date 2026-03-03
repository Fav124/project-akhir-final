function isImageInput(input) {
    const accept = (input.getAttribute('accept') || '').toLowerCase();
    const name = (input.getAttribute('name') || '').toLowerCase();
    return accept.includes('image') || /(foto|avatar|image|photo)/.test(name);
}

function enhanceImageInput(input) {
    if (!input || input.dataset.imageEnhanced === 'true') return;
    if (input.hasAttribute('data-no-auto-image')) return;
    if (!isImageInput(input)) return;

    input.dataset.imageEnhanced = 'true';

    const zone = document.createElement('div');
    zone.className = 'deisa-upload-dropzone';
    zone.innerHTML = `
        <div class="deisa-upload-copy">
            <div class="deisa-upload-title">Drop gambar di sini atau klik untuk pilih</div>
            <div class="deisa-upload-help">PNG, JPG, JPEG, GIF - Max 2MB</div>
        </div>
        <img class="deisa-upload-preview" alt="Preview gambar" />
        <div class="deisa-upload-filename"></div>
    `;

    const preview = zone.querySelector('.deisa-upload-preview');
    const fileName = zone.querySelector('.deisa-upload-filename');

    input.parentNode.insertBefore(zone, input);
    zone.appendChild(input);
    input.classList.add('deisa-upload-input-hidden');

    const readFile = (file) => {
        if (!file || !file.type.startsWith('image/')) return;

        const url = URL.createObjectURL(file);
        preview.src = url;
        preview.classList.add('is-visible');
        fileName.textContent = file.name;
        zone.classList.add('has-image');
    };

    zone.addEventListener('click', () => input.click());

    input.addEventListener('change', (e) => {
        readFile(e.target.files[0]);
    });

    ['dragenter', 'dragover'].forEach((eventName) => {
        zone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            zone.classList.add('is-dragging');
        });
    });

    ['dragleave', 'drop'].forEach((eventName) => {
        zone.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
            zone.classList.remove('is-dragging');
        });
    });

    zone.addEventListener('drop', (e) => {
        const file = e.dataTransfer?.files?.[0];
        if (!file) return;

        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;
        readFile(file);
    });
}

function initImageUploads(root = document) {
    const inputs = root.querySelectorAll('input[type="file"]');
    inputs.forEach(enhanceImageInput);
}

document.addEventListener('DOMContentLoaded', () => {
    initImageUploads(document);

    const observer = new MutationObserver((mutations) => {
        for (const mutation of mutations) {
            mutation.addedNodes.forEach((node) => {
                if (!(node instanceof HTMLElement)) return;
                initImageUploads(node);
            });
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
});
