// Realtime Updates Utility for DEISA
// Provides polling-based realtime updates for dashboard and data tables

class RealtimeUpdater {
    constructor(options = {}) {
        this.interval = options.interval || 30000; // Default: 30 seconds
        this.url = options.url || window.location.href;
        this.selector = options.selector || null;
        this.onUpdate = options.onUpdate || null;
        this.enabled = options.enabled !== false;
        this.timer = null;
        this.isLoading = false;
    }

    start() {
        if (!this.enabled || this.timer) return;
        this.update();
        this.timer = setInterval(() => this.update(), this.interval);
    }

    stop() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null;
        }
    }

    async update() {
        if (this.isLoading) return;
        this.isLoading = true;

        try {
            const response = await fetch(this.url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                cache: 'no-cache'
            });

            if (!response.ok) throw new Error('Update failed');

            const contentType = response.headers.get('content-type');
            
            if (contentType && contentType.includes('application/json')) {
                const data = await response.json();
                if (this.onUpdate) {
                    this.onUpdate(data);
                } else if (this.selector && data.html) {
                    const element = document.querySelector(this.selector);
                    if (element) {
                        this.fadeUpdate(element, data.html);
                    }
                }
            } else {
                const html = await response.text();
                if (this.selector) {
                    const element = document.querySelector(this.selector);
                    if (element) {
                        this.fadeUpdate(element, html);
                    }
                }
            }
        } catch (error) {
            console.error('Realtime update error:', error);
        } finally {
            this.isLoading = false;
        }
    }

    fadeUpdate(element, newHtml) {
        element.style.transition = 'opacity 0.3s';
        element.style.opacity = '0.5';
        
        setTimeout(() => {
            element.innerHTML = newHtml;
            element.style.opacity = '1';
        }, 300);
    }
}

// Dashboard Stats Realtime Updater
class DashboardStatsUpdater {
    constructor() {
        this.statsUpdater = null;
        this.init();
    }

    init() {
        const statsContainer = document.querySelector('[data-realtime-stats]');
        if (!statsContainer) return;

        const url = statsContainer.dataset.realtimeStats || '/admin/dashboard/stats';
        
        this.statsUpdater = new RealtimeUpdater({
            url: url,
            interval: 30000, // 30 seconds
            enabled: true,
            onUpdate: (data) => {
                this.updateStats(data);
            }
        });

        this.statsUpdater.start();
    }

    updateStats(data) {
        if (!data || !data.stats) return;

        // Update each stat card
        Object.entries(data.stats).forEach(([key, value]) => {
            const element = document.querySelector(`[data-stat="${key}"]`);
            if (element) {
                const currentValue = parseInt(element.textContent) || 0;
                if (currentValue !== value) {
                    this.animateValue(element, currentValue, value, 500);
                }
            }
        });
    }

    animateValue(element, start, end, duration) {
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        const timer = setInterval(() => {
            current += increment;
            if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.round(current);
        }, 16);
    }
}

// Table Realtime Updater
class TableRealtimeUpdater {
    constructor(selector, options = {}) {
        this.selector = selector;
        this.tableElement = document.querySelector(selector);
        if (!this.tableElement) return;

        const url = options.url || window.location.href;
        const interval = options.interval || 60000; // 1 minute for tables

        this.updater = new RealtimeUpdater({
            url: url,
            selector: selector,
            interval: interval,
            enabled: options.enabled !== false
        });

        this.updater.start();
    }
}

// Notification Badge Realtime Updater
class NotificationUpdater {
    constructor() {
        this.updater = null;
        this.init();
    }

    init() {
        const notificationUrl = '/admin/notifications/count';
        
        this.updater = new RealtimeUpdater({
            url: notificationUrl,
            interval: 15000, // 15 seconds
            enabled: true,
            onUpdate: (data) => {
                this.updateBadge(data.count || 0);
            }
        });

        this.updater.start();
    }

    updateBadge(count) {
        const badge = document.querySelector('[data-notification-badge]');
        if (badge) {
            if (count > 0) {
                badge.textContent = count > 99 ? '99+' : count;
                badge.classList.remove('hidden');
                badge.classList.add('animate-pulse');
            } else {
                badge.classList.add('hidden');
                badge.classList.remove('animate-pulse');
            }
        }
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize dashboard stats updater
    if (document.querySelector('[data-realtime-stats]')) {
        new DashboardStatsUpdater();
    }

    // Initialize notification updater
    if (document.querySelector('[data-notification-badge]')) {
        new NotificationUpdater();
    }

    // Initialize table updaters for all tables with data-realtime-table
    document.querySelectorAll('[data-realtime-table]').forEach(table => {
        const selector = table.dataset.realtimeTable || `#${table.id}`;
        new TableRealtimeUpdater(selector, {
            url: table.dataset.realtimeUrl || window.location.href,
            interval: parseInt(table.dataset.realtimeInterval) || 60000
        });
    });
});

// Export for use in other scripts
window.RealtimeUpdater = RealtimeUpdater;
window.DashboardStatsUpdater = DashboardStatsUpdater;
window.TableRealtimeUpdater = TableRealtimeUpdater;
window.NotificationUpdater = NotificationUpdater;
