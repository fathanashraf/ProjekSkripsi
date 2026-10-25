export default (options = {}) => ({

    chart: null,
    options,

    init() {

        if (!window.ApexCharts) {
            console.error('ApexCharts belum tersedia')
            return
        }

        const el = this.$refs.chart

        if (!el) {
            console.error('x-ref="chart" tidak ditemukan di Blade')
            return
        }

        this.chart = new window.ApexCharts(el, {
            chart: {
                type: 'area',
                height: 320,
                toolbar: { show: false }
            },

            series: [
                {
                    name: 'Pendaftaran',
                    data: this.options.pendaftaran ?? []
                },
                {
                    name: 'Keuangan',
                    data: this.options.keuangan ?? []
                },
                {
                    name: 'Acara',
                    data: this.options.acara ?? []
                }
            ],

            xaxis: {
                categories: this.options.labels ?? []
            },

            stroke: {
                curve: 'smooth',
                width: 3
            },

            dataLabels: {
                enabled: false
            },

            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05
                }
            },

            tooltip: {
                shared: true,
                intersect: false
            }
        })

        this.chart.render()
    }
})