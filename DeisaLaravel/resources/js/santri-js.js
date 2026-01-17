// resources/js/santri-js.js

document.addEventListener('DOMContentLoaded', () => {
    // 1. Generic Form/Modal Trigger (for Create/Edit)
    document.addEventListener('click', async (e) => {
        const formBtn = e.target.closest('[data-form-url]');
        if (formBtn) {
            e.preventDefault();
            const url = formBtn.dataset.formUrl;

            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();

                let modal = document.getElementById('global-form-modal');
                if (!modal) {
                    const modalHtml = `
                        <div id="global-form-modal" class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 hidden">
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
                                <div id="form-modal-content"></div>
                            </div>
                        </div>`;
                    document.body.insertAdjacentHTML('beforeend', modalHtml);
                    modal = document.getElementById('global-form-modal');
                }

                document.getElementById('form-modal-content').innerHTML = html;
                modal.classList.remove('hidden');

                // Initialize Stepper if it's the santri form
                const stepperForm = document.getElementById('santri-stepper-form');
                if (stepperForm) {
                    initSantriStepper(stepperForm);
                } else if (document.getElementById('sakit-form')) {
                    initSakitForm(document.getElementById('sakit-form'));
                } else {
                    // Generic AJAX handler for other forms in modal
                    const modalForm = modal.querySelector('form[data-ajax="true"]');
                    if (modalForm) {
                        initGenericModalForm(modalForm);
                    }
                }

                // Add close logic
                const closeBtns = modal.querySelectorAll('[data-modal-close]');
                closeBtns.forEach(btn => {
                    btn.onclick = () => modal.classList.add('hidden');
                });
                modal.onclick = (e) => { if (e.target === modal) modal.classList.add('hidden'); };

            } catch (error) {
                console.error('Modal Load Error:', error);
                if (typeof showAlert === 'function') showAlert('error', 'Gagal memuat form.');
            }
        }
    });

    function initSantriStepper(form) {
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const nextBtn = document.getElementById('next-step');
        const prevBtn = document.getElementById('prev-step');
        const submitBtn = document.getElementById('submit-form');
        const progress = document.getElementById('step-progress');
        const ind1 = document.getElementById('step-1-indicator');
        const ind2 = document.getElementById('step-2-indicator');

        nextBtn.addEventListener('click', () => {
            // Basic validation for step 1
            const fields = step1.querySelectorAll('input[required], select[required]');
            let valid = true;
            fields.forEach(f => {
                if (!f.value) {
                    f.classList.add('border-red-500');
                    valid = false;
                } else {
                    f.classList.remove('border-red-500');
                }
            });

            if (!valid) {
                if (typeof showAlert === 'function') showAlert('error', 'Mohon lengkapi data yang wajib diisi.');
                return;
            }

            step1.classList.add('hidden');
            step2.classList.remove('hidden');
            nextBtn.classList.add('hidden');
            prevBtn.classList.remove('hidden');
            submitBtn.classList.remove('hidden');

            progress.style.width = '100%';
            ind2.classList.replace('bg-slate-200', 'bg-deisa-blue');
            ind2.classList.replace('text-slate-500', 'text-white');
        });

        prevBtn.addEventListener('click', () => {
            step2.classList.add('hidden');
            step1.classList.remove('hidden');
            nextBtn.classList.remove('hidden');
            prevBtn.classList.add('hidden');
            submitBtn.classList.add('hidden');

            progress.style.width = '0%';
            ind2.classList.replace('bg-deisa-blue', 'bg-slate-200');
            ind2.classList.replace('text-white', 'text-slate-500');
        });

        // Re-attach AJAX handler for the new form
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = submitBtn;
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    if (typeof showAlert === 'function') showAlert('success', data.message);
                    document.getElementById('global-form-modal').classList.add('hidden');
                    // Refresh table logic
                    const searchInput = document.querySelector('input[data-realtime-search="true"]');
                    if (searchInput) {
                        searchInput.dispatchEvent(new Event('input'));
                    } else {
                        window.location.reload();
                    }
                } else {
                    if (data.errors) {
                        let errors = Object.values(data.errors).flat().join('\n');
                        if (typeof showAlert === 'function') showAlert('error', errors);
                    } else {
                        if (typeof showAlert === 'function') showAlert('error', data.message || 'Gagal menyimpan data.');
                    }
                }
            } catch (error) {
                console.error('Submit Error:', error);
                if (typeof showAlert === 'function') showAlert('error', 'Terjadi kesalahan sistem.');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        });
    }

    function initGenericModalForm(form) {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.innerHTML : '';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Menyimpan...';
            }

            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: form.method || 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    if (typeof showAlert === 'function') showAlert('success', data.message);
                    document.getElementById('global-form-modal').classList.add('hidden');

                    // Refresh table
                    const searchInput = document.querySelector('input[data-realtime-search="true"]');
                    if (searchInput) {
                        searchInput.dispatchEvent(new Event('input'));
                    } else {
                        window.location.reload();
                    }
                } else {
                    if (data.errors) {
                        let errors = Object.values(data.errors).flat().join('\n');
                        if (typeof showAlert === 'function') showAlert('error', errors);
                    } else {
                        if (typeof showAlert === 'function') showAlert('error', data.message || 'Gagal menyimpan data.');
                    }
                }
            } catch (error) {
                console.error('Submit Error:', error);
                if (typeof showAlert === 'function') showAlert('error', 'Terjadi kesalahan sistem.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }
        });
    }

    function initSakitForm(form) {
        const container = form.querySelector('#obat-rows-container');
        const template = form.querySelector('#obat-row-template');
        const addButton = form.querySelector('#add-obat-row');

        if (addButton && container && template) {
            addButton.addEventListener('click', () => {
                const clone = template.content.cloneNode(true);
                container.appendChild(clone);
            });

            container.addEventListener('click', (e) => {
                if (e.target.closest('.remove-obat-row')) {
                    e.target.closest('.obat-row').remove();
                }
            });
        }

        initGenericModalForm(form);
    }
});
