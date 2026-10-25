import './bootstrap'
import Alpine from 'alpinejs'
import ApexCharts from 'apexcharts'
import mermaid from 'mermaid'
import Swal from 'sweetalert2'
import AOS from 'aos'
import 'aos/dist/aos.css';


window.Alpine = Alpine
window.ApexCharts = ApexCharts
window.mermaid = mermaid
window.Swal = Swal


// Setup SweetAlert2 dengan Tailwind CSS theme
Swal.mixin({
    customClass: {
        container: 'swal2-container',
        popup: 'rounded-xl shadow-2xl bg-white dark:bg-gray-800',
        header: 'border-b border-gray-200 dark:border-gray-700 px-6 py-4',
        title: 'text-xl font-bold text-gray-900 dark:text-white',
        close: 'text-gray-400 hover:text-gray-600 dark:hover:text-gray-300',
        content: 'text-gray-700 dark:text-gray-300 mt-4 px-6 py-2',
        confirmButton: 'bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-6 py-3 rounded-lg transition',
        cancelButton: 'bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-medium px-6 py-3 rounded-lg transition',
        button: 'mx-2',
        footer: 'border-t border-gray-200 dark:border-gray-700 px-6 py-4',
    },
    iconColor: '#10b981',
    showConfirmButton: true,
    showCancelButton: false,
    confirmButtonText: 'OK',
    cancelButtonText: 'Batal',
    backdrop: 'rgba(0,0,123,0.4)',
    padding: '2rem',
    timerProgressBar: true,
})

// Initialize AOS
AOS.init();

document.addEventListener('alpine:init', () => {
    Alpine.store('sidebar', {
        isOpen: window.innerWidth >= 1024,

        init() {
            if (this._sidebarReady) return
            this._sidebarReady = true

            const saved = localStorage.getItem('sidebar-open')
            this.isOpen = saved === null ? window.innerWidth >= 1024 : saved === 'true'
            this.syncBodyLock()

            // Selaraskan saat ukuran layar berpindah breakpoint
            window.addEventListener('resize', () => this.syncBodyLock(), { passive: true })
        },

        // Kunci scroll body hanya saat sidebar overlay terbuka di layar kecil
        syncBodyLock() {
            const locked = window.innerWidth < 1024 && this.isOpen
            document.body.style.overflow = locked ? 'hidden' : ''
        },

        toggle() {
            this.isOpen = !this.isOpen
            localStorage.setItem('sidebar-open', this.isOpen ? 'true' : 'false')
            this.syncBodyLock()
        },

        close() {
            if (window.innerWidth < 1024) {
                this.isOpen = false
                localStorage.setItem('sidebar-open', 'false')
                this.syncBodyLock()
            }
        },

        open() {
            this.isOpen = true
            localStorage.setItem('sidebar-open', 'true')
            this.syncBodyLock()
        }
    })

    Alpine.store('modal', {
    isOpen: false,
    mode: 'form', // form | detail | confirm
    title: '',
    message: '',
    formAction: '',
    method: 'POST',
    enctype: 'application/x-www-form-urlencoded',

    fields: [],
    form: {},
    detail: {},

    loading: false,
    confirmAction: null,

    open(config = {}) {
        this.isOpen = true
        this.mode = config.mode || 'form'
        this.title = config.title || ''
        this.message = config.message || ''
        this.formAction = config.formAction || ''
        this.method = (config.method || 'POST').toUpperCase()
        this.enctype = config.enctype || 'application/x-www-form-urlencoded'

        this.fields = config.fields || []

        this.form = { ...(config.form || config.data || {}) }
        this.detail = { ...(config.detail || config.data || {}) }

        this.confirmAction = config.action || null
        this.loading = false
    },

    openDetail(payload = {}) {
        this.open({
            mode: 'detail',
            title: payload.title || 'Detail',
            fields: payload.fields || [],
            detail: payload.data || {}
        })
    },

    openForm(payload = {}) {
        this.open({
            mode: 'form',
            title: payload.title || 'Form',
            formAction: payload.action || '',
            method: payload.method || 'POST',
            enctype: payload.enctype || 'application/x-www-form-urlencoded',
            fields: payload.fields || [],
            form: payload.data || {}
        })
    },

    close() {
        this.isOpen = false
        this.mode = 'form'
        this.title = ''
        this.message = ''
        this.formAction = ''
        this.method = 'POST'
        this.enctype = 'application/x-www-form-urlencoded'
        this.fields = []
        this.form = {}
        this.detail = {}
        this.confirmAction = null
        this.loading = false
    },

    confirm() {
        if (typeof this.confirmAction === 'function') {
            this.loading = true
            this.confirmAction()
        }
    },

    // =========================
    // SWEETALERT FIXED VERSION
    // =========================
    showSuccess(message, title = 'Berhasil!') {
        return Swal.fire({
            icon: 'success',
            title,
            text: message,
            confirmButtonText: 'OK',
        })
    },

    showError(message, title = 'Gagal!') {
        return Swal.fire({
            icon: 'error',
            title,
            text: message,
            confirmButtonText: 'OK',
        })
    },

    showWarning(message, title = 'Peringatan!') {
        return Swal.fire({
            icon: 'warning',
            title,
            text: message,
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        })
    },

    showInfo(message, title = 'Info') {
        return Swal.fire({
            icon: 'info',
            title,
            text: message,
            confirmButtonText: 'OK',
        })
    },

    confirmWithSweetAlert(title, message, confirmText = 'Ya', cancelText = 'Batal') {
        return Swal.fire({
            icon: 'question',
            title,
            text: message,
            showCancelButton: true,
            confirmButtonText: confirmText,
            cancelButtonText: cancelText,
        }).then((result) => {
            if (result.isConfirmed) {
                this.confirm()
            }
        })
    }
})

    Alpine.data('layoutApp', () => ({
        // Migrasi preferensi lama dari key 'darkMode' ke key 'theme'
        darkMode: (() => {
            const legacy = localStorage.getItem('darkMode')
            if (legacy !== null && localStorage.getItem('theme') === null) {
                const migrated = legacy === 'true' ? 'dark' : 'light'
                localStorage.setItem('theme', migrated)
                localStorage.removeItem('darkMode')
                return migrated === 'dark'
            }
            return localStorage.getItem('theme') === 'dark'
                || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
        })(),

        init() {
            this.applyTheme()
            this.$watch('darkMode', () => this.applyTheme())
            Alpine.store('sidebar').init()
            this.bindScrollShadow()

            this.$nextTick(() => {
                // Re-initialize AOS after DOM updates
                AOS.refresh()

                if (window.mermaid) {
                    window.mermaid.initialize({
                        startOnLoad: true,
                        securityLevel: 'loose',
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'base',
                        themeVariables: {
                            fontFamily: 'Inter, sans-serif'
                        }
                    })
                }
            })
        },

        applyTheme() {
            const root = document.documentElement
            const dark = this.darkMode

            const before = root.classList.contains('dark')

            if (dark) {
                root.classList.add('dark')
                localStorage.setItem('theme', 'dark')
            } else {
                root.classList.remove('dark')
                localStorage.setItem('theme', 'light')
            }

            /*
             * Transisi halus antar theme.
             * Class `theme-anim` hanya dipasang saat theme benar-benar
             * berubah, sehingga pemuatan halaman awal tetap instan
             * dan tidak ada animasi saat pertama render.
             */
            const actuallyChanged = before !== dark && this._themeReady
            const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches

            // Panggilan pertama (saat halaman dibuka) tidak dianimasikan
            this._themeReady = true

            if (actuallyChanged && !reduced) {
                root.classList.add('theme-anim')
                clearTimeout(this._themeAnimTimer)
                this._themeAnimTimer = setTimeout(() => {
                    root.classList.remove('theme-anim')
                }, 400)
            }
        },

        toggleDarkMode() {
            this.darkMode = !this.darkMode
        },

        // Header / navbar "terangkat" saat halaman di-scroll
        bindScrollShadow() {
            const selector = '.app-header, .navbar'
            let ticking = false

            const update = () => {
                const scrolled = window.scrollY > 8
                document.querySelectorAll(selector).forEach((el) => {
                    el.classList.toggle('is-scrolled', scrolled)
                })
                ticking = false
            }

            const onScroll = () => {
                if (ticking) return
                ticking = true
                window.requestAnimationFrame(update)
            }

            update()
            window.addEventListener('scroll', onScroll, { passive: true })
            window.addEventListener('resize', onScroll, { passive: true })
        }
    }))

    // Notifikasi admin/pembina. Opsional: { endpoint, enabled }
    Alpine.data('notificationComponent', (config = {}) => ({
        endpoint: config.endpoint || '/admin/notifications',
        enabled: config.enabled !== false,
        notificationsOpen: false,
        notifications: [],
        unreadCount: 0,
        loading: false,
        polling: null,
        detailModalOpen: false,
        selectedNotification: null,

        init() {
            if (!this.enabled) return
            this.fetchNotifications()
            this.polling = setInterval(() => this.fetchNotifications(), 30000)
        },

        stopPolling() {
            if (this.polling) {
                clearInterval(this.polling)
                this.polling = null
            }
            this.enabled = false
        },

        async fetchNotifications() {
            if (!this.enabled) return
            this.loading = true
            try {
                const response = await fetch(this.endpoint, {
                    method: 'GET',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })

                // Sesi habis / tidak punya akses: hentikan polling, jangan spam error
                if (response.status === 401 || response.status === 403 || response.status === 419) {
                    this.stopPolling()
                    this.notifications = []
                    this.unreadCount = 0
                    return
                }

                if (!response.ok) throw new Error(`HTTP ${response.status}`)

                const data = await response.json()
                this.notifications = data.notifications || []
                this.unreadCount = data.unread_count || 0
            } catch (error) {
                console.error('Notifications fetch failed:', error)
                this.notifications = []
                this.unreadCount = 0
            } finally {
                this.loading = false
            }
        },

        toggleNotifications() {
            this.notificationsOpen = !this.notificationsOpen
            if (this.notificationsOpen) this.fetchNotifications()
        },

        async markRead(id) {
            try {
                const response = await fetch(`${this.endpoint}/${id}/read`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })

                if (!response.ok) throw new Error('Mark read failed')

                const item = this.notifications.find(n => n.id === id)
                if (item && !item.read_at) {
                    item.read_at = new Date().toISOString()
                    this.unreadCount = Math.max(0, this.unreadCount - 1)
                }
            } catch (error) {
                console.error('Mark read error:', error)
            }
        },

        async markAllRead() {
            try {
                const response = await fetch(`${this.endpoint}/read-all`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    }
                })

                const data = await response.json().catch(() => ({}))

                if (!response.ok) {
                    throw new Error(data.message || 'Mark all read failed')
                }

                this.notifications = this.notifications.map(n => ({
                    ...n,
                    read_at: n.read_at ?? new Date().toISOString()
                }))
                this.unreadCount = 0
                this.notificationsOpen = false
            } catch (error) {
                console.error('Mark all read error:', error)
            }
        },

        openDetail(notification) {
            this.selectedNotification = notification
            this.detailModalOpen = true
            this.notificationsOpen = false
            // Auto mark as read
            if (!notification.read_at) {
                this.markRead(notification.id)
            }
        },

        closeDetail() {
            this.detailModalOpen = false
            this.selectedNotification = null
        },

        notificationIcon(type) {
            const icons = {
                'laporan_baru': 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                'aspirasi_created': 'M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z',
                'acara_created': 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                'pendaftaran_baru': 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                'struktur_created': 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'
            }
            return icons[type] || 'M13 10V3L4 14h7v7l9-11h-7z'
        },

        notificationColor(type) {
            const colors = {
                'laporan_baru': 'from-amber-500 to-orange-600',
                'aspirasi_created': 'from-rose-500 to-pink-600',
                'acara_created': 'from-emerald-500 to-teal-600',
                'pendaftaran_baru': 'from-blue-500 to-indigo-600',
                'struktur_created': 'from-violet-500 to-purple-600'
            }
            return colors[type] || 'from-slate-500 to-slate-600'
        },

        formatDate(dateStr) {
            if (!dateStr) return '-'
            return new Date(dateStr).toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            })
        }
    }))

    Alpine.data('mahasiswaNotificationComponent', (initialSeen = []) => ({
        notificationsOpen: false,
        notifications: [],
        unreadCount: 0,
        loading: false,
        polling: null,
        seenIds: Array.isArray(initialSeen) ? initialSeen : [],
        stopped: false,

        init() {
            this.fetchNotifications()
            this.polling = setInterval(() => this.fetchNotifications(), 15000)
        },

        stopPolling() {
            if (this.polling) {
                clearInterval(this.polling)
                this.polling = null
            }
            this.stopped = true
        },

        async fetchNotifications() {
            if (this.stopped) return
            try {
                const response = await fetch('/mahasiswa/notifications', {
                    method: 'GET',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })

                // Sesi habis / tidak punya akses: hentikan polling, jangan spam error
                if (response.status === 401 || response.status === 403 || response.status === 419) {
                    this.stopPolling()
                    this.notifications = []
                    this.unreadCount = 0
                    return
                }

                if (!response.ok) throw new Error(`HTTP ${response.status}`)

                const data = await response.json()
                const incoming = data.notifications || []

                // Tampilkan notifikasi real-time untuk status yang baru berubah
                incoming.forEach(notification => {
                    if (!this.seenIds.includes(notification.id)) {
                        this.seenIds.push(notification.id)
                        if (this.seenIds.length > 1) {
                            this.showToast(notification)
                        }
                    }
                })

                this.notifications = incoming
                this.unreadCount = data.unread_count || 0
            } catch (error) {
                console.error('Notifikasi mahasiswa gagal dimuat:', error)
            }
        },

        showToast(notification) {
            const isApproved = notification.data?.type === 'pendaftaran_diterima'
            const isRejected = notification.data?.type === 'pendaftaran_ditolak'

            Swal.fire({
                icon: isApproved ? 'success' : isRejected ? 'error' : 'info',
                title: notification.data?.title || 'Notifikasi',
                text: notification.data?.message || 'Ada pembaruan status pendaftaran Anda.',
                confirmButtonText: isApproved ? 'Bayar Sekarang' : 'OK',
                showCancelButton: Boolean(isApproved),
                cancelButtonText: 'Nanti',
            }).then((result) => {
                if (result.isConfirmed && notification.url) {
                    window.location.href = notification.url
                }
            })
        },

        toggleNotifications() {
            this.notificationsOpen = !this.notificationsOpen
            if (this.notificationsOpen) this.fetchNotifications()
        },

        async markRead(id) {
            try {
                await fetch(`/mahasiswa/notifications/${id}/read`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })

                const item = this.notifications.find(n => n.id === id)
                if (item && !item.read_at) {
                    item.read_at = new Date().toISOString()
                    this.unreadCount = Math.max(0, this.unreadCount - 1)
                }
            } catch (error) {
                console.error('Tandai notifikasi gagal:', error)
            }
        },

        async markAllRead() {
            try {
                await fetch('/mahasiswa/notifications/read-all', {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })

                this.notifications = this.notifications.map(n => ({
                    ...n,
                    read_at: n.read_at ?? new Date().toISOString()
                }))
                this.unreadCount = 0
                this.notificationsOpen = false
            } catch (error) {
                console.error('Tandai semua notifikasi gagal:', error)
            }
        },

        notificationTone(type) {
            const tones = {
                pendaftaran_diterima: 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                pembayaran_lunas: 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                pendaftaran_ditolak: 'bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-300',
            }
            return tones[type] || 'bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300'
        },
    }))

    Alpine.data('dashboardChart', (options = {}) => ({
        options,
        chart: null,

        init() {
            const el = this.$refs.chart
            if (!el || !window.ApexCharts) return

            const isDark = document.documentElement.classList.contains('dark')

            this.chart = new window.ApexCharts(el, {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: { show: false },
                    foreColor: isDark ? '#cbd5e1' : '#334155'
                },
                series: [
                    { name: 'Pendaftaran', data: this.options.pendaftaran || [] },
                    { name: 'Keuangan', data: this.options.keuangan || [] },
                    { name: 'Acara', data: this.options.acara || [] }
                ],
                stroke: { curve: 'smooth', width: 3 },
                colors: ['#10b981', '#ef4444', '#3b82f6'],
                dataLabels: { enabled: false },
                grid: {
                    borderColor: isDark ? '#334155' : '#e2e8f0'
                },
                xaxis: {
                    type: 'category',
                    categories: this.options.labels || []
                },
                yaxis: {
                    labels: {
                        formatter: value => Math.round(value)
                    }
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light'
                },
                legend: {
                    position: 'top'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                }
            })

            this.chart.render()
        }
    }))

    Alpine.store('mobileNav', {
        isOpen: false,
        aboutOpen: false,
        infoOpen: false,
        docsOpen: false,

        // Kunci scroll body selama drawer mobile terbuka
        syncBodyLock() {
            document.body.style.overflow = this.isOpen ? 'hidden' : ''
        },

        toggle() {
            this.isOpen = !this.isOpen
            if (!this.isOpen) {
                this.aboutOpen = false
                this.infoOpen = false
                this.docsOpen = false
            }
            this.syncBodyLock()
        },

        close() {
            this.isOpen = false
            this.aboutOpen = false
            this.infoOpen = false
            this.docsOpen = false
            this.syncBodyLock()
        },

        toggleAbout() {
            this.aboutOpen = !this.aboutOpen
            this.infoOpen = false
            this.docsOpen = false
        },

        toggleInfo() {
            this.infoOpen = !this.infoOpen
            this.aboutOpen = false
            this.docsOpen = false
        },

        toggleDocs() {
            this.docsOpen = !this.docsOpen
            this.aboutOpen = false
            this.infoOpen = false
        }
    })

    Alpine.data('keuanganChart', (options = {}) => ({
        options,
        chart: null,

        init() {
            const el = this.$refs.chart
            if (!el || !window.ApexCharts) return

            const isDark = document.documentElement.classList.contains('dark')

            this.chart = new window.ApexCharts(el, {
                chart: {
                    type: 'area',
                    height: 320,
                    toolbar: { show: false },
                    foreColor: isDark ? '#cbd5e1' : '#334155'
                },
                series: [
                    { name: 'Pemasukan', data: this.options.pemasukan || [] }
                ],
                stroke: { curve: 'smooth', width: 3 },
                colors: ['#3b82f6'],
                dataLabels: { enabled: false },
                grid: {
                    borderColor: isDark ? '#334155' : '#e2e8f0'
                },
                xaxis: {
                    type: 'category',
                    categories: this.options.labels || []
                },
                yaxis: {
                    labels: {
                        formatter: value => Math.round(value)
                    }
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light'
                },
                legend: {
                    position: 'top'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.35,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                }
            })

            this.chart.render()
        },

        destroy() {
            if (this.chart) {
                this.chart.destroy()
                this.chart = null
            }
        }
    }))
})

// Support file multiple + folder upload pada modal
document.addEventListener('alpine:init', () => {
    Alpine.store('fileUploadHelper', {
        handleFileInput(event, field, modalStore) {
            const files = Array.from(event.target.files || [])

            if (field.multiple) {
                modalStore.form[field.name] = files
            } else {
                modalStore.form[field.name] = files[0] || null
            }
        }
    })
})

Alpine.start()