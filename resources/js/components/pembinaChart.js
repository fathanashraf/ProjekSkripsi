export default () => ({

    canvas: null,
    ctx: null,

    labels: [],

    datasets: {
        acara: [],
        pengurus: [],
        keuangan: [],
        laporan: []
    },

    colors: {
        acara: '#2563eb',
        pengurus: '#10b981',
        keuangan: '#f59e0b',
        laporan: '#ef4444'
    },

    init() {

        this.canvas = document.getElementById('acaraChart')

        if (!this.canvas) return

        this.ctx = this.canvas.getContext('2d')

        // from backend (Laravel)
        this.labels = window.chartLabels || []

        this.datasets = {
            acara: window.chartData?.acara || [],
            pengurus: window.chartData?.pengurus || [],
            keuangan: window.chartData?.keuangan || [],
            laporan: window.chartData?.laporan || [],
        }

        this.draw()

        window.addEventListener('resize', () => {
            this.draw()
        })
    },

    draw() {

        const canvas = this.canvas
        const ctx = this.ctx

        const wrapper = canvas.parentElement

        canvas.width = wrapper.clientWidth
        canvas.height = 350

        const width = canvas.width
        const height = canvas.height

        ctx.clearRect(0, 0, width, height)

        const padding = 50

        // ambil max dari SEMUA dataset
        const allData = [
            ...this.datasets.acara,
            ...this.datasets.pengurus,
            ...this.datasets.keuangan,
            ...this.datasets.laporan
        ]

        const maxValue = Math.max(...allData, 1)

        const chartWidth = width - padding * 2
        const chartHeight = height - padding * 2

        const stepX = chartWidth / (this.labels.length - 1)

        // GRID
        ctx.strokeStyle = '#e5e7eb'
        ctx.lineWidth = 1

        for (let i = 0; i <= 5; i++) {

            const y =
                padding +
                ((chartHeight) / 5) * i

            ctx.beginPath()
            ctx.moveTo(padding, y)
            ctx.lineTo(width - padding, y)
            ctx.stroke()
        }

        // DRAW LINE FUNCTION
        const drawLine = (data, color) => {

            ctx.beginPath()

            data.forEach((value, index) => {

                const x = padding + stepX * index

                const y =
                    height -
                    padding -
                    ((value / maxValue) * chartHeight)

                if (index === 0) ctx.moveTo(x, y)
                else ctx.lineTo(x, y)
            })

            ctx.strokeStyle = color
            ctx.lineWidth = 3
            ctx.stroke()
        }

        // DRAW POINT FUNCTION
        const drawPoints = (data, color) => {

            data.forEach((value, index) => {

                const x = padding + stepX * index

                const y =
                    height -
                    padding -
                    ((value / maxValue) * chartHeight)

                ctx.beginPath()
                ctx.arc(x, y, 4, 0, Math.PI * 2)
                ctx.fillStyle = color
                ctx.fill()
            })
        }

        // AREA FUNCTION (optional, pakai acara saja biar clean)
        const drawArea = (data, color) => {

            const gradient =
                ctx.createLinearGradient(0, padding, 0, height)

            gradient.addColorStop(0, color + '40')
            gradient.addColorStop(1, color + '05')

            ctx.beginPath()

            data.forEach((value, index) => {

                const x = padding + stepX * index

                const y =
                    height -
                    padding -
                    ((value / maxValue) * chartHeight)

                if (index === 0) ctx.moveTo(x, y)
                else ctx.lineTo(x, y)
            })

            ctx.lineTo(width - padding, height - padding)
            ctx.lineTo(padding, height - padding)
            ctx.closePath()

            ctx.fillStyle = gradient
            ctx.fill()
        }

        // =========================
        // DRAW ALL LINES
        // =========================

        drawArea(this.datasets.acara, this.colors.acara)

        drawLine(this.datasets.acara, this.colors.acara)
        drawLine(this.datasets.pengurus, this.colors.pengurus)
        drawLine(this.datasets.keuangan, this.colors.keuangan)
        drawLine(this.datasets.laporan, this.colors.laporan)

        drawPoints(this.datasets.acara, this.colors.acara)
        drawPoints(this.datasets.pengurus, this.colors.pengurus)
        drawPoints(this.datasets.keuangan, this.colors.keuangan)
        drawPoints(this.datasets.laporan, this.colors.laporan)

        // =========================
        // LABEL X
        // =========================

        ctx.fillStyle = '#64748b'
        ctx.font = '12px sans-serif'

        this.labels.forEach((label, index) => {

            const x = padding + stepX * index

            ctx.fillText(label, x - 10, height - 15)
        })

        // =========================
        // LABEL Y
        // =========================

        for (let i = 0; i <= 5; i++) {

            const value =
                Math.round(maxValue - (maxValue / 5 * i))

            const y =
                padding + ((chartHeight) / 5) * i

            ctx.fillText(value, 10, y + 5)
        }
    }
})