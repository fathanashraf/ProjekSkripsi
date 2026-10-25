export default () => ({

    dragging:false,

    files:[],

    dragEnter(){

        this.dragging=true
    },

    dragLeave(){

        this.dragging=false
    },

    drop(event){

        this.dragging=false

        this.files =
            Array.from(event.dataTransfer.files)
    },

    handleInput(event){

        this.files =
            Array.from(event.target.files)
    },

    preview(file){

        return URL.createObjectURL(file)
    },

    remove(index){

        this.files.splice(index,1)
    }
})