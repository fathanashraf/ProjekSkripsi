export default () => ({

    // ========================
    // STATE
    // ========================
    isOpen: false,
    loading: false,

    mode: 'form',

    title: '',
    subtitle: '',
    message: '',

    size: 'sm',

    // ========================
    // FORM
    // ========================
    formAction: '',
    method: 'POST',
    enctype: 'application/x-www-form-urlencoded',

    fields: [],
    form: {},

    // ========================
    // DETAIL
    // ========================
    detail: {},

    // ========================
    // FILE
    // ========================
    fileUrl: '',
    fileName: '',
    fileType: '',

    youtubeUrl: '',
    iframeUrl: '',

    gallery: [],
    galleryIndex: 0,

    confirmAction: null,
    onClose: null,
    onOpen: null,

    // ========================
    // OPEN (FIXED)
    // ========================
    open(config = {}) {

        this.reset()

        // SAFE MERGE (tidak overwrite seluruh state)
        this.mode = config.mode || this.mode
        this.title = config.title || ''
        this.subtitle = config.subtitle || ''
        this.message = config.message || ''

        this.size = config.size || 'sm'

        this.formAction = config.formAction || ''
        this.method = (config.extraMethod || config.method || 'POST').toUpperCase()
        this.enctype = config.enctype || 'application/x-www-form-urlencoded'

        this.fields = config.fields || []
        // view mengirim `data`, form helper mengirim `form`
        this.form = config.form || config.data || {}
        this.detail = config.detail || {}

        this.fileUrl = config.fileUrl || ''
        this.fileType = config.fileType || ''
        this.fileName = config.fileName || ''

        this.youtubeUrl = config.youtubeUrl || ''
        this.iframeUrl = config.iframeUrl || ''

        this.gallery = config.gallery || []
        this.galleryIndex = config.galleryIndex || 0

        // view mengirim `action`, form helper mengirim `confirmAction`
        this.confirmAction = config.confirmAction || config.action || null

        this.isOpen = true

        if (typeof this.onOpen === 'function') {
            this.onOpen()
        }
    },

    // ========================
    // FORM
    // ========================
    openForm(payload = {}) {
        this.open({
            mode: 'form',
            title: payload.title || 'Form',
            formAction: payload.formAction || payload.action || '',
            method: payload.extraMethod || payload.method || 'POST',
            enctype: payload.enctype || 'application/x-www-form-urlencoded',
            fields: payload.fields || [],
            form: payload.form || payload.data || {},
            size: payload.size || 'sm'
        })
    },

    // ========================
    // DETAIL
    // ========================
    openDetail(payload = {}) {
        this.open({
            mode: 'detail',
            title: payload.title || 'Detail',
            detail: payload.data || {},
            fields: payload.fields || [],
            size: payload.size || 'md'
        })
    },

    // ========================
    // CONFIRM
    // ========================
    openConfirm(payload = {}) {
        this.open({
            mode: 'confirm',
            title: payload.title || 'Konfirmasi',
            message: payload.message || '',
            confirmAction: payload.confirmAction || payload.action || null,
            size: 'sm'
        })
    },

    // ========================
    // FILE
    // ========================
    openFile(url, title = 'Preview File') {

        const ext = url.split('.').pop().toLowerCase()

        let type = 'document'

        if (['jpg','jpeg','png','gif','webp','svg'].includes(ext)) type = 'image'
        else if (['mp4','mov','webm','mkv'].includes(ext)) type = 'video'
        else if (['mp3','wav','ogg','m4a'].includes(ext)) type = 'audio'
        else if (ext === 'pdf') type = 'pdf'

        this.open({
            mode: 'preview',
            title,
            fileUrl: url,
            fileType: type,
            fileName: url.split('/').pop(),
            size: type === 'pdf' ? 'xl' : 'md'
        })
    },

    // ========================
    // YOUTUBE
    // ========================
    openYoutube(url, title = 'Video') {
        this.open({
            mode: 'youtube',
            title,
            youtubeUrl: this.convertYoutube(url),
            size: 'md'
        })
    },

    convertYoutube(url) {
        const match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/)
        return match ? `https://www.youtube.com/embed/${match[1]}` : url
    },

    // ========================
    // IFRAME
    // ========================
    openIframe(url, title = 'Preview') {
        this.open({
            mode: 'iframe',
            title,
            iframeUrl: url,
            size: 'xl'
        })
    },

    // ========================
    // GALLERY
    // ========================
    openGallery(images = [], index = 0) {
        this.open({
            mode: 'gallery',
            gallery: images,
            galleryIndex: index,
            size: 'md'
        })
    },

    nextImage() {
        if (this.galleryIndex < this.gallery.length - 1) {
            this.galleryIndex++
        }
    },

    prevImage() {
        if (this.galleryIndex > 0) {
            this.galleryIndex--
        }
    },

    // ========================
    // CONFIRM
    // ========================
    confirm() {
        if (typeof this.confirmAction === 'function') {
            this.loading = true

            Promise.resolve(this.confirmAction())
                .finally(() => {
                    this.loading = false
                })
        }
    },

    // ========================
    // CLOSE
    // ========================
    close() {

        document.querySelectorAll('video').forEach(v => v.pause())
        document.querySelectorAll('audio').forEach(a => a.pause())

        if (typeof this.onClose === 'function') {
            this.onClose()
        }

        this.reset()
    },

    // ========================
    // RESET (SAFE)
    // ========================
    reset() {
        this.isOpen = false
        this.loading = false

        this.mode = 'form'

        this.title = ''
        this.subtitle = ''
        this.message = ''

        this.size = 'sm'

        this.formAction = ''
        this.method = 'POST'
        this.enctype = 'application/x-www-form-urlencoded'

        this.fields = []
        this.form = {}

        this.detail = {}

        this.fileUrl = ''
        this.fileName = ''
        this.fileType = ''

        this.youtubeUrl = ''
        this.iframeUrl = ''

        this.gallery = []
        this.galleryIndex = 0

        this.confirmAction = null
        this.onClose = null
        this.onOpen = null
    }
})