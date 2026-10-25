export default () => ({

    isOpen: window.innerWidth >= 1024,

    init() {

        const saved =
            localStorage.getItem('sidebar-open')

        this.isOpen =
            saved === null
                ? window.innerWidth >= 1024
                : saved === 'true'
    },

    toggle() {

        this.isOpen = !this.isOpen

        localStorage.setItem(
            'sidebar-open',
            this.isOpen
        )
    },

    open() {

        this.isOpen = true

        localStorage.setItem(
            'sidebar-open',
            true
        )
    },

    close() {

        if(window.innerWidth < 1024){

            this.isOpen = false

            localStorage.setItem(
                'sidebar-open',
                false
            )
        }
    }
})