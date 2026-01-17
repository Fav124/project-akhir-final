// resources/js/ajax.js

document.addEventListener('DOMContentLoaded', () => {
    // 1. Generic Form Handler for data-ajax="true"
    const ajaxForms = document.querySelectorAll('form[data-ajax="true"]');

    ajaxForms.forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.innerHTML : '';

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg> Processing...`;
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
                    showAlert('success', data.message || 'Action successful!');
                    if (data.redirect) {
                        setTimeout(() => window.location.href = data.redirect, 1000);
                    } else if (data.reload) {
                        setTimeout(() => window.location.reload(), 1000);
                    } else if (form.hasAttribute('data-reset')) {
                        form.reset();
                    }
                } else {
                    if (data.errors) {
                        showValidationErrors(data.errors);
                    } else {
                        showAlert('error', data.message || 'Something went wrong.');
                    }
                }

            } catch (error) {
                console.error('AJAX Error:', error);
                showAlert('error', 'Network error or server failed to respond.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            }
        });
    });

    // 2. Real-time Search & Filter Handler
    let searchTimeout;
    const setupRealtimeSearch = () => {
        const searchInputs = document.querySelectorAll('input[data-realtime-search="true"]');
        const filterInputs = document.querySelectorAll('[data-realtime-filter="true"]');

        const performUpdate = async (triggerElement) => {
            const url = triggerElement.dataset.searchUrl || window.location.href;
            const targetSelector = triggerElement.dataset.searchTarget || '#table-container';
            const form = triggerElement.closest('form') || document.querySelector('form');

            try {
                const searchURL = new URL(url, window.location.origin);

                // Collect all inputs from the form
                if (form) {
                    const formData = new FormData(form);
                    for (const [key, value] of formData.entries()) {
                        if (value) searchURL.searchParams.set(key, value);
                    }
                } else if (triggerElement.name) {
                    searchURL.searchParams.set(triggerElement.name, triggerElement.value);
                }

                // Show loading state
                const container = document.querySelector(targetSelector);
                if (container) container.style.opacity = '0.5';

                const response = await fetch(searchURL.toString(), {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });

                const html = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector(targetSelector);

                if (container) {
                    if (newContent) {
                        container.innerHTML = newContent.innerHTML;
                    } else {
                        container.innerHTML = html;
                    }
                    container.style.opacity = '1';
                }

                // Update browser URL without reload
                window.history.pushState({}, '', searchURL.toString());
            } catch (error) {
                console.error('Search/Filter Error:', error);
            }
        };

        searchInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                input.classList.add('loading-search');
                searchTimeout = setTimeout(async () => {
                    await performUpdate(input);
                    input.classList.remove('loading-search');
                }, 300);
            });
        });

        filterInputs.forEach(filter => {
            filter.addEventListener('change', async () => {
                await performUpdate(filter);
            });
        });
    };

    setupRealtimeSearch();

    // 3. Global Modal Handler (for Details)
    document.addEventListener('click', async (e) => {
        const detailBtn = e.target.closest('[data-detail-url]');
        if (detailBtn) {
            e.preventDefault();
            const url = detailBtn.dataset.detailUrl;

            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();

                let modal = document.getElementById('global-detail-modal');
                if (!modal) {
                    const modalHtml = `
                        <div id="global-detail-modal" class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 hidden">
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
                                <div id="modal-content"></div>
                            </div>
                        </div>`;
                    document.body.insertAdjacentHTML('beforeend', modalHtml);
                    modal = document.getElementById('global-detail-modal');
                }

                document.getElementById('modal-content').innerHTML = html;
                modal.classList.remove('hidden');

                const closeBtn = modal.querySelector('[data-modal-close]');
                if (closeBtn) {
                    closeBtn.onclick = () => modal.classList.add('hidden');
                }

                modal.onclick = (e) => { if (e.target === modal) modal.classList.add('hidden'); };
            } catch (error) {
                showAlert('error', 'Gagal memuat detail.');
            }
        }
    });

    // 4. Quick AJAX Link/Button Handler (e.g. Set Status)
    document.addEventListener('click', async (e) => {
        const ajaxBtn = e.target.closest('[data-ajax-url]');
        if (ajaxBtn) {
            e.preventDefault();
            const url = ajaxBtn.dataset.ajaxUrl;

            if (ajaxBtn.hasAttribute('onclick') && !confirm('Apakah Anda yakin?')) return;

            try {
                const response = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                const data = await response.json();

                if (response.ok) {
                    showAlert('success', data.message);
                    if (data.reload) {
                        const searchInput = document.querySelector('input[data-realtime-search="true"]');
                        if (searchInput) {
                            searchInput.dispatchEvent(new Event('input'));
                        } else {
                            setTimeout(() => window.location.reload(), 500);
                        }
                    }
                } else {
                    showAlert('error', data.message || 'Gagal mengubah status.');
                }
            } catch (error) {
                console.error('Quick Action Error:', error);
                showAlert('error', 'Terjadi kesalahan sistem.');
            }
        }
    });
});

function showAlert(type, message) {
    const alertId = 'ajax-alert-' + Date.now();
    const colorClass = type === 'success' ? 'bg-emerald-500' : 'bg-red-500';

    const alertHtml = `
        <div id="${alertId}" class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 space-x-4 text-white ${colorClass} rounded-lg shadow-lg transform transition-all duration-300 translate-y-[-100%] opacity-0">
            <div class="text-sm font-bold flex-1">${message}</div>
            <button onclick="document.getElementById('${alertId}').remove()" class="p-1 hover:bg-white/20 rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', alertHtml);

    setTimeout(() => {
        const el = document.getElementById(alertId);
        if (el) el.classList.remove('translate-y-[-100%]', 'opacity-0');
    }, 10);

    setTimeout(() => {
        const el = document.getElementById(alertId);
        if (el) {
            el.classList.add('translate-y-[-100%]', 'opacity-0');
            setTimeout(() => el.remove(), 300);
        }
    }, 4000);
}

function showValidationErrors(errors) {
    let msg = "";
    for (const [key, value] of Object.entries(errors)) {
        msg += `• ${value}\n`;
    }
    showAlert('error', 'Validation Failed:\n' + msg);
}
