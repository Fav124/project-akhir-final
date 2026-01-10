/**
 * Deisa UI Components
 * Centralized components for SearchableSelect, TagInput, and Alerts
 */

/* =========================
   TAG INPUT
========================= */
class TagInput {
    constructor(containerId, inputId, suggestionsId, searchRoute) {
        this.container = document.getElementById(containerId);
        this.input = document.getElementById(inputId);
        this.suggestions = document.getElementById(suggestionsId);
        this.searchRoute = searchRoute;
        this.tags = [];
        this.init();
    }

    init() {
        if (!this.input) return;

        this.input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                const val = this.input.value.trim();
                if (val) this.addTag(val);
            } else if (e.key === 'Backspace' && !this.input.value && this.tags.length > 0) {
                this.removeTag(this.tags.length - 1);
            }
        });

        this.input.addEventListener('input', () => {
            const val = this.input.value.trim();
            if (val.length >= 2) {
                this.fetchSuggestions(val);
            } else {
                this.hideSuggestions();
            }
        });

        // Prevent closing when clicking inside
        this.container.addEventListener('click', () => this.input.focus());
        document.addEventListener('click', (e) => {
            if (!this.container.contains(e.target) && !this.suggestions.contains(e.target)) {
                this.hideSuggestions();
            }
        });
    }

    async fetchSuggestions(q) {
        try {
            const res = await fetch(`${this.searchRoute}?q=${q}`);
            const data = await res.json();
            this.renderSuggestions(data);
        } catch (e) {
            console.error("Failed to fetch suggestions", e);
        }
    }

    renderSuggestions(items) {
        if (!items.length) {
            this.hideSuggestions();
            return;
        }

        this.suggestions.innerHTML = items.map(item => `
            <div class="px-4 py-2 hover:bg-primary/10 cursor-pointer text-sm font-medium border-b border-gray-100 dark:border-gray-800 last:border-0" data-nama="${item.nama}">
                ${item.nama}
            </div>
        `).join('');

        this.suggestions.querySelectorAll('div').forEach(div => {
            div.addEventListener('click', () => {
                this.addTag(div.dataset.nama);
                this.hideSuggestions();
            });
        });

        this.suggestions.classList.remove('hidden');
    }

    hideSuggestions() {
        this.suggestions.classList.add('hidden');
    }

    addTag(val) {
        if (this.tags.includes(val)) {
            this.input.value = '';
            return;
        }
        this.tags.push(val);
        this.render();
        this.input.value = '';
    }

    removeTag(index) {
        this.tags.splice(index, 1);
        this.render();
    }

    render() {
        // Keep input at the end
        const input = this.input;
        this.container.innerHTML = '';
        this.tags.forEach((tag, index) => {
            const badge = document.createElement('span');
            badge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-primary/10 text-primary text-xs font-bold border border-primary/20';
            badge.innerHTML = `
                ${tag}
                <button type="button" class="hover:text-red-500 flex items-center" onclick="window.removeTagFromGlobal ? window.removeTagFromGlobal(${index}) : console.warn('TagInput: remove function not connected')">
                    <span class="material-symbols-outlined text-[14px]">close</span>
                </button>
            `;
            // Note: removeTag usage might need contextual adjustment per page if 'diagnosisTags' variable name varies.
            // Better to use a class-based approach if possible, but for simplicity we'll handle the click via a global hook if needed.
            // Actually, we can just use the instance itself if we register it.
            badge.querySelector('button').onclick = (e) => {
                e.stopPropagation();
                this.removeTag(index);
            };
            this.container.appendChild(badge);
        });
        this.container.appendChild(input);
        input.focus();
    }

    setTags(tags) {
        this.tags = tags || [];
        this.render();
    }

    getTags() {
        return this.tags;
    }

    clear() {
        this.tags = [];
        this.render();
    }
}

/* =========================
   SEARCHABLE SELECT
========================= */
class SearchableSelect {
    constructor(selectElement, options = {}) {
        this.select = selectElement;
        this.options = options;
        this.placeholder = options.placeholder || 'Cari...';
        this.container = null;
        this.searchInput = null;
        this.dropdown = null;
        this.itemsContainer = null;
        this.isOpen = false;
        this.selectedValue = this.select.value;
        this.selectedLabel = '';

        const activeOption = this.select.options[this.select.selectedIndex];
        if (activeOption && activeOption.value !== "") {
            this.selectedLabel = activeOption.text;
        }

        this.init();
    }

    init() {
        if (!this.select) return;
        this.select.classList.add('hidden');

        this.container = document.createElement('div');
        this.container.className = 'relative custom-searchable-select';
        this.select.parentNode.insertBefore(this.container, this.select.nextSibling);

        this.display = document.createElement('div');
        this.display.className = 'w-full px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary cursor-pointer flex justify-between items-center';
        this.updateDisplayText();
        this.container.appendChild(this.display);

        this.dropdown = document.createElement('div');
        this.dropdown.className = 'absolute z-[60] mt-1 w-full bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-800 rounded-lg shadow-xl hidden overflow-hidden flex flex-col max-h-72';

        const searchWrapper = document.createElement('div');
        searchWrapper.className = 'p-2 border-b border-gray-100 dark:border-gray-700 sticky top-0 bg-surface-light dark:bg-surface-dark';
        this.searchInput = document.createElement('input');
        this.searchInput.type = 'text';
        this.searchInput.placeholder = this.placeholder;
        this.searchInput.className = 'w-full px-3 py-1.5 text-sm border border-gray-100 dark:border-gray-700 rounded-md bg-gray-50 dark:bg-gray-800 text-text-main dark:text-white focus:outline-none focus:ring-2 focus:ring-primary';
        searchWrapper.appendChild(this.searchInput);
        this.dropdown.appendChild(searchWrapper);

        this.itemsContainer = document.createElement('div');
        this.itemsContainer.className = 'overflow-y-auto flex-1';
        this.dropdown.appendChild(this.itemsContainer);

        this.container.appendChild(this.dropdown);

        this.display.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggle();
        });

        this.searchInput.addEventListener('input', (e) => {
            this.filter(e.target.value);
        });

        this.searchInput.addEventListener('click', (e) => e.stopPropagation());
        document.addEventListener('click', () => this.close());

        this.renderItems();
    }

    updateDisplayText() {
        this.display.innerHTML = `
            <span class="${this.selectedValue ? '' : 'text-text-muted'} truncate">
                ${this.selectedLabel || (this.options.emptyText || '-- Pilih --')}
            </span>
            <span class="material-symbols-outlined text-gray-400">expand_more</span>
        `;
    }

    renderItems(filterText = '') {
        this.itemsContainer.innerHTML = '';
        const options = Array.from(this.select.options).filter(opt => opt.value !== "");

        let found = false;
        options.forEach(opt => {
            if (opt.text.toLowerCase().includes(filterText.toLowerCase())) {
                const item = document.createElement('div');
                item.className = `px-4 py-2.5 text-sm cursor-pointer hover:bg-primary/10 transition-colors 
                    ${this.selectedValue == opt.value ? 'bg-primary/5 font-bold text-primary' : 'text-text-main dark:text-gray-300'}`;
                item.textContent = opt.text;
                item.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.selectItem(opt.value, opt.text);
                });
                this.itemsContainer.appendChild(item);
                found = true;
            }
        });

        if (!found) {
            const empty = document.createElement('div');
            empty.className = 'px-4 py-8 text-center text-xs text-text-muted italic';
            empty.textContent = 'Data tidak ditemukan';
            this.itemsContainer.appendChild(empty);
        }
    }

    selectItem(value, label) {
        this.selectedValue = value;
        this.selectedLabel = label;
        this.select.value = value;
        this.select.dispatchEvent(new Event('change', { bubbles: true }));
        this.updateDisplayText();
        this.close();
    }

    filter(text) {
        this.renderItems(text);
    }

    toggle() {
        if (this.isOpen) this.close();
        else this.open();
    }

    open() {
        document.querySelectorAll('.custom-searchable-select .absolute').forEach(d => d.classList.add('hidden'));
        if (this.dropdown) {
            this.dropdown.classList.remove('hidden');
            this.isOpen = true;
            this.searchInput.value = '';
            this.renderItems();
            setTimeout(() => this.searchInput.focus(), 50);
        }
    }

    close() {
        if (this.dropdown) {
            this.dropdown.classList.add('hidden');
            this.isOpen = false;
        }
    }

    setValue(value) {
        this.select.value = value;
        const opt = Array.from(this.select.options).find(o => o.value == value);
        if (opt) {
            this.selectedValue = value;
            this.selectedLabel = opt.text;
        } else {
            this.selectedValue = '';
            this.selectedLabel = '';
        }
        this.updateDisplayText();
    }

    refresh() {
        if (!this.select) return;
        const activeOption = this.select.options[this.select.selectedIndex];
        if (activeOption && activeOption.value !== "") {
            this.selectedValue = activeOption.value;
            this.selectedLabel = activeOption.text;
        } else {
            this.selectedValue = '';
            this.selectedLabel = '';
        }
        this.updateDisplayText();
        this.renderItems();
    }
}

/* =========================
   ALERT
========================= */
function showAlert(message, type = "success") {
    const box = document.getElementById("alertBox");
    if (!box) return;

    const id = "alert-" + Date.now();
    const bgClass = {
        'success': 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 border-green-200 dark:border-green-700',
        'danger': 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 border-red-200 dark:border-red-700',
        'warning': 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 border-orange-200 dark:border-orange-700',
        'info': 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 border-blue-200 dark:border-blue-700',
        'secondary': 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 border-gray-200 dark:border-gray-700'
    }[type] || 'bg-gray-100 text-gray-700 border-gray-200';

    const icon = {
        'success': 'check_circle',
        'danger': 'error',
        'warning': 'warning',
        'info': 'info',
        'secondary': 'info'
    }[type] || 'info';

    const alert = document.createElement("div");
    alert.id = id;
    alert.className = `flex items-center justify-between p-4 mb-3 border rounded-xl animate-slide-in-right shadow-sm ${bgClass}`;
    alert.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined">${icon}</span>
            <span class="text-sm font-medium">${message}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="hover:opacity-70 transition-opacity">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>
    `;

    box.appendChild(alert);
    setTimeout(() => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add("animate-fade-out");
            setTimeout(() => el.remove(), 500);
        }
    }, 5000);
}

// Export for globally accessibility
window.TagInput = TagInput;
window.SearchableSelect = SearchableSelect;
window.showAlert = showAlert;
