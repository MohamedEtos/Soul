  // ===== Canvas setup (2 layers) =====
  const fx = document.getElementById("fx");
  const gxf = document.getElementById("glowFx");
  const ctx = fx.getContext("2d");
  const gctx = gxf.getContext("2d");

  function resize() {
    const dpr = devicePixelRatio || 1;
    [fx, gxf].forEach(c=>{
      c.width = innerWidth * dpr;
      c.height = innerHeight * dpr;
      c.style.width = innerWidth + "px";
      c.style.height = innerHeight + "px";
    });
    ctx.setTransform(dpr,0,0,dpr,0,0);
    gctx.setTransform(dpr,0,0,dpr,0,0);
  }
  addEventListener("resize", resize);
  resize();

  const rand = (a,b)=>Math.random()*(b-a)+a;

  const palette = ["#22c55e","#fbbf24","#fb7185","#22d3ee","#a78bfa","#ffffff"];

  // ===== Particles =====
  class Confetti {
    constructor(x,y){
      this.x=x; this.y=y;
      this.vx = rand(-7,7);
      this.vy = rand(-12,-5);
      this.g  = rand(0.18,0.32);
      this.w  = rand(6,12);
      this.h  = rand(3,7);
      this.rot = rand(0,Math.PI*2);
      this.vrot = rand(-0.22,0.22);
      this.life = rand(70,120);
      this.alpha = 1;
      this.color = palette[(Math.random()*palette.length)|0];
    }
    step(){
      this.life--;
      this.vy += this.g;
      this.x += this.vx;
      this.y += this.vy;
      this.rot += this.vrot;
      if(this.life < 28) this.alpha = Math.max(0, this.life/28);
    }
    draw(){
      ctx.save();
      ctx.globalAlpha = this.alpha;
      ctx.translate(this.x,this.y);
      ctx.rotate(this.rot);
      ctx.fillStyle = this.color;
      ctx.fillRect(-this.w/2, -this.h/2, this.w, this.h);
      ctx.restore();
    }
  }

  class Star {
    constructor(x,y){
      this.x=x; this.y=y;
      this.vx = rand(-6,6);
      this.vy = rand(-14,-7);
      this.g  = rand(0.12,0.22);
      this.r  = rand(4,8);
      this.rot = rand(0,Math.PI*2);
      this.vrot = rand(-0.18,0.18);
      this.life = rand(65,110);
      this.alpha = 1;
      this.color = palette[(Math.random()*palette.length)|0];
    }
    step(){
      this.life--;
      this.vy += this.g;
      this.x += this.vx;
      this.y += this.vy;
      this.rot += this.vrot;
      if(this.life < 28) this.alpha = Math.max(0, this.life/28);
    }
    draw(){
      ctx.save();
      ctx.globalAlpha = this.alpha;
      ctx.translate(this.x,this.y);
      ctx.rotate(this.rot);
      drawStar(0,0,5,this.r*1.9,this.r*0.9,this.color);
      ctx.restore();
    }
  }

  class Spark {
    constructor(x,y,angle){
      const sp = rand(6,11);
      this.x=x; this.y=y;
      this.vx = Math.cos(angle)*sp + rand(-1.5,1.5);
      this.vy = Math.sin(angle)*sp + rand(-1.5,1.5);
      this.g  = rand(0.10,0.18);
      this.life = rand(28,45);
      this.alpha = 1;
      this.color = "#ffffff";
      this.size = rand(1.2,2.4);
    }
    step(){
      this.life--;
      this.vy += this.g;
      this.x += this.vx;
      this.y += this.vy;
      this.alpha = Math.max(0, this.life/45);
    }
    draw(){
      ctx.save();
      ctx.globalAlpha = this.alpha;
      ctx.beginPath();
      ctx.arc(this.x,this.y,this.size,0,Math.PI*2);
      ctx.fillStyle = this.color;
      ctx.fill();
      ctx.restore();
    }
  }

  // Streamers = long ribbons
  class Streamer{
    constructor(x,y){
      this.x=x; this.y=y;
      this.vx = rand(-4,4);
      this.vy = rand(-18,-10);
      this.g = rand(0.20,0.34);
      this.life = rand(95,150);
      this.alpha = 1;
      this.color = palette[(Math.random()*palette.length)|0];
      this.len = rand(90,160);
      this.th = rand(2.2,4.2);
      this.phase = rand(0,Math.PI*2);
      this.amp = rand(10,18);
      this.freq = rand(0.10,0.16);
      this.drag = rand(0.985,0.993);
    }
    step(){
      this.life--;
      this.vy += this.g;
      this.vx *= this.drag;
      this.x += this.vx;
      this.y += this.vy;

      this.phase += this.freq;
      if(this.life < 35) this.alpha = Math.max(0, this.life/35);
    }
    draw(){
      ctx.save();
      ctx.globalAlpha = this.alpha;
      ctx.lineWidth = this.th;
      ctx.strokeStyle = this.color;
      ctx.lineCap = "round";

      // wavy ribbon path
      ctx.beginPath();
      const segments = 10;
      for(let i=0;i<=segments;i++){
        const t = i/segments;
        const yy = this.y + t*this.len;
        const xx = this.x + Math.sin(this.phase + t*6.0)*this.amp*(1-t);
        if(i===0) ctx.moveTo(xx,yy);
        else ctx.lineTo(xx,yy);
      }
      ctx.stroke();

      // little highlight
      ctx.globalAlpha = this.alpha * 0.35;
      ctx.strokeStyle = "#ffffff";
      ctx.lineWidth = Math.max(1.1, this.th-1.2);
      ctx.stroke();

      ctx.restore();
    }
  }

  function drawStar(cx, cy, spikes, outerRadius, innerRadius, color){
    let rot = Math.PI / 2 * 3;
    let x = cx;
    let y = cy;
    const step = Math.PI / spikes;

    ctx.beginPath();
    ctx.moveTo(cx, cy - outerRadius);
    for (let i = 0; i < spikes; i++) {
      x = cx + Math.cos(rot) * outerRadius;
      y = cy + Math.sin(rot) * outerRadius;
      ctx.lineTo(x, y);
      rot += step;

      x = cx + Math.cos(rot) * innerRadius;
      y = cy + Math.sin(rot) * innerRadius;
      ctx.lineTo(x, y);
      rot += step;
    }
    ctx.closePath();
    ctx.fillStyle = color;
    ctx.fill();
  }

  let parts = [];
  let raf = null;

  // ===== Glow pulse at burst point =====
  function glowPulse(x,y){
    const start = performance.now();
    const dur = 650;
    function gloop(now){
      const t = Math.min(1, (now-start)/dur);
      gctx.clearRect(0,0,innerWidth,innerHeight);

      const r = 20 + t*180;
      const a = (1-t) * 0.75;
      const grad = gctx.createRadialGradient(x,y,0,x,y,r);
      grad.addColorStop(0, `rgba(34,197,94,${a})`);
      grad.addColorStop(0.35, `rgba(34,211,238,${a*0.55})`);
      grad.addColorStop(0.7, `rgba(167,139,250,${a*0.35})`);
      grad.addColorStop(1, `rgba(0,0,0,0)`);

      gctx.fillStyle = grad;
      gctx.beginPath();
      gctx.arc(x,y,r,0,Math.PI*2);
      gctx.fill();

      if(t<1) requestAnimationFrame(gloop);
      else gctx.clearRect(0,0,innerWidth,innerHeight);
    }
    requestAnimationFrame(gloop);
  }

  function burst(x,y){
    // streamers (الشرايط)
    for(let i=0;i<18;i++) parts.push(new Streamer(x + rand(-10,10), y + rand(-6,6)));

    // wave 1
    for(let i=0;i<140;i++) parts.push(new Confetti(x,y));
    for(let i=0;i<26;i++) parts.push(new Star(x,y));

    // spark ring
    for(let i=0;i<60;i++){
      const ang = (Math.PI*2) * (i/60);
      parts.push(new Spark(x,y,ang));
    }

    // wave 2 (delayed bigger pop)
    setTimeout(()=>{
      for(let i=0;i<120;i++){
        const c = new Confetti(x,y);
        c.vx *= 1.15;
        c.vy *= 1.15;
        parts.push(c);
      }
      for(let i=0;i<20;i++) parts.push(new Star(x,y));
      if(!raf) loop();
    }, 120);

    glowPulse(x,y);
  }

  function loop(){
    ctx.clearRect(0,0,innerWidth,innerHeight);

    for(let i=parts.length-1;i>=0;i--){
      const p = parts[i];
      p.step();
      p.draw();
      if(p.life<=0 || p.y > innerHeight + 200) parts.splice(i,1);
    }

    if(parts.length){
      raf = requestAnimationFrame(loop);
    } else {
      cancelAnimationFrame(raf);
      raf = null;
    }
  }

  // ===== UI =====
  const gift = document.getElementById("gift");
  const msg  = document.getElementById("msg");
//   const btnReplay = document.getElementById("btnReplay");
  const btnGo = document.getElementById("btnGo");
//   const btnTrack = document.getElementById("btnTrack");

  function play(){
    gift.classList.remove("idle");
    gift.classList.add("open");
    gift.classList.add("shake");
    setTimeout(()=>gift.classList.remove("shake"), 450);

    msg.classList.add("show");

    const rect = gift.getBoundingClientRect();
    const x = rect.left + rect.width/2;
    const y = rect.top + 44;

    burst(x,y);
    if(!raf) loop();
  }

  function reset(){
    gift.classList.remove("open","shake");
    msg.classList.remove("show");
    setTimeout(()=>gift.classList.add("idle"), 120);

    parts = [];
    ctx.clearRect(0,0,innerWidth,innerHeight);
    gctx.clearRect(0,0,innerWidth,innerHeight);
    if(raf){ cancelAnimationFrame(raf); raf=null; }
  }

  gift.addEventListener("click", ()=>{
    if(!gift.classList.contains("open")) play();
    else {
      // extra mini-burst when clicking again
      const rect = gift.getBoundingClientRect();
      burst(rect.left + rect.width/2, rect.top + 44);
      if(!raf) loop();
    }
  });

//   btnReplay.addEventListener("click", ()=>{ reset(); setTimeout(play, 220); });

//   btnGo.addEventListener("click", ()=> alert("حط هنا لينك متابعة التسوق ✅"));
//   btnTrack.addEventListener("click", ()=> alert("حط هنا لينك تتبع الطلب ✅"));

  // demo order number
//   document.getElementById("orderNo").textContent = "#ORD-2026-" + Math.floor(1000 + Math.random()*9000);

  // auto play
  setTimeout(play, 650);

    let seconds = 7;
    const counter = document.getElementById('counter');

    const timer = setInterval(() => {
        seconds--;
        counter.textContent = seconds;

        if (seconds <= 0) {
        clearInterval(timer);
        window.location.href = "/";
        }
    }, 1000);




