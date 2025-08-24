<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <title>Zegar na tle</title>
  <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
  <link href="https://fonts.cdnfonts.com/css/ds-digital" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      margin: 0;
      display: grid;
      place-items: center;
      background: whitesmoke;
    }

    .container {
      position: relative;
      display: inline-block;
    }

    .background-img {
      width: 300px;
      height: auto;
      border-radius: 12px;
      -webkit-box-reflect: below 2px linear-gradient(to bottom, rgba(0,0,0,0.2), transparent);
    }

    .time {
      position: absolute;
      bottom: 20px;
      right: 20px;
      font-size: 36px;
      font-weight: bold;
      font-family: 'DS-Digital', 'Courier New', monospace;
      background: rgba(0, 0, 0, 0.7);
      color: #39ff14;
      padding: 10px 20px;
      border-radius: 8px;
      text-shadow: 0 0 6px #39ff14, 0 0 12px #39ff14;
      box-shadow: inset 0 2px 6px rgba(255,255,255,0.1),
                  inset 0 -2px 6px rgba(0,0,0,0.6);
    }

    .days {
      position: absolute;
      bottom: -40px;
      right: 20px;
      font-size: 18px;
      font-family: Arial, sans-serif;
      color: #444;
    }
  </style>
</head>
<body>
  <div id="app" class="container">
    <img class="background-img" src="https://images.unsplash.com/photo-1525786138363-b8fb7296cda7?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzMjM4NDZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE3NTU1Mjc0Njl8&ixlib=rb-4.1.0&q=80&w=400" alt="Zegar tło">
    <div class="time">{{ formattedHMS }}</div>
    <div class="days">{{ days }} dni</div>
  </div>

  <script>
    const { createApp } = Vue

    createApp({
      data() {
        return { seconds: 0, timer: null }
      },
      computed: {
        days() { return Math.floor(this.seconds / 86400) },
        formattedHMS() {
          let h = Math.floor((this.seconds % 86400) / 3600)
          let m = Math.floor((this.seconds % 3600) / 60)
          let s = this.seconds % 60
          return `${h.toString().padStart(2,'0')}:${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`
        }
      },
      methods: {
        fetchTime() {
          fetch('time.php?action=get')
            .then(r => r.json())
            .then(d => { this.seconds = d.seconds; this.startTimer() })
        },
        startTimer() {
          this.timer = setInterval(() => {
            this.seconds++
            if (this.seconds % 10 === 0) this.saveTime()
          }, 1000)
        },
        saveTime() {
          fetch('time.php?action=save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ seconds: this.seconds })
          })
        }
      },
      mounted() { this.fetchTime() }
    }).mount('#app')
  </script>
</body>
</html>
