export default () => ({

    darkMode:false,

    init(){

        this.darkMode =
            localStorage.getItem('theme') === 'dark'

        this.applyTheme()
    },

    applyTheme(){

        if(this.darkMode){

            document.documentElement
                .classList.add('dark')

        }else{

            document.documentElement
                .classList.remove('dark')
        }
    },

    toggleDarkMode(){

        this.darkMode=!this.darkMode

        localStorage.setItem(
            'theme',
            this.darkMode
                ? 'dark'
                : 'light'
        )

        this.applyTheme()
    }
})