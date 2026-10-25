export default (options={}) => ({

    chart:null,

    options,

    init(){

        if(!window.ApexCharts) return

        this.chart =
            new ApexCharts(
                this.$refs.chart,
                {
                    chart:{
                        type:'bar',
                        height:320
                    },

                    series:[
                        {
                            name:'Keuangan',
                            data:
                            this.options.data || []
                        }
                    ],

                    xaxis:{
                        categories:
                        this.options.labels || []
                    }
                }
            )

        this.chart.render()
    }
})