export default () => ({

    notificationsOpen:false,

    notifications:[],

    unreadCount:0,

    loading:false,

    async fetchNotifications(){

        try{

            this.loading=true

            const response =
                await fetch('/admin/notifications')

            const data =
                await response.json()

            this.notifications =
                data.notifications || []

            this.unreadCount =
                data.unread_count || 0

        }catch(error){

            console.error(error)

        }finally{

            this.loading=false
        }
    },

    toggle(){

        this.notificationsOpen =
            !this.notificationsOpen

        if(this.notificationsOpen)
            this.fetchNotifications()
    },

    async markRead(id){

        await fetch(
            `/admin/notifications/${id}/read`,
            {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN':
                    document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content
                }
            }
        )

        this.fetchNotifications()
    }
})