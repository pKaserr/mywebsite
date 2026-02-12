const canvas = document.querySelector('.particleCanvas');
const ctx = canvas.getContext('2d');

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particles = [];
// how many     particles
// different particleCount for different screen sizes
let particleCount = 250;

if (window.innerWidth < 480) {
    particleCount = 45;
} else if (window.innerWidth < 768) {
    particleCount = 70;
}

// how far the particles are connected
const maxDistance = 200;
// how far the mouse is connected
const mouse = { x: null, y: null, radius: 250 };

window.addEventListener('mousemove', (event) => {
    mouse.x = event.x;
    mouse.y = event.y;
});

class Particle {
    constructor(x, y, dirX, dirY, size, color) {
        this.x = x;
        this.y = y;
        this.dirX = dirX;
        this.dirY = dirY;
        this.size = size;
        this.color = color;
    }
    draw() {
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
        ctx.fillStyle = this.color;
        ctx.fill();
    }
    update() {
        // borders
        if (this.x > canvas.width + 10 || this.x < -10) this.dirX = -this.dirX;
        if (this.y > canvas.height + 10 || this.y < -10) this.dirY = -this.dirY;

        // movement without mouse repulsion
        this.x += this.dirX;
        this.y += this.dirY;

        this.draw();
    }
}

function init(currentSite) {
    let color = currentSite.includes("index") || currentSite === "" ? "#969595" : "#333333ff";
    particles = [];
    for (let i = 0; i < particleCount; i++) {
        let size = Math.random() * 3 + 1;
        let x = (Math.random() * ((canvas.width - size + 10 * 2) - (size * 2)) + size * 2);
        let y = (Math.random() * ((canvas.height - size + 10 * 2) - (size * 2)) + size * 2);
        let dirX = (Math.random() * 0.6) - 0.3;
        let dirY = (Math.random() * 0.6) - 0.3;

        particles.push(new Particle(x, y, dirX, dirY, size, color));
    }
}

function connect(currentSite) {
    let opacityValue = 1;
    for (let a = 0; a < particles.length; a++) {

        // connections between particles
        for (let b = a; b < particles.length; b++) {
            let dx = particles[a].x - particles[b].x;
            let dy = particles[a].y - particles[b].y;
            let distance = Math.sqrt(dx * dx + dy * dy);
            let strokeStyleColorParticles = currentSite.includes("index") || currentSite === "" ? "100, 100, 100" : "59, 59, 59";

            if (distance < maxDistance) {
                opacityValue = 1 - (distance / maxDistance);
                ctx.strokeStyle = 'rgba(' + strokeStyleColorParticles + ',' + opacityValue + ')';
                ctx.lineWidth = 0.5;
                ctx.beginPath();
                ctx.moveTo(particles[a].x, particles[a].y);
                ctx.lineTo(particles[b].x, particles[b].y);
                ctx.stroke();
            }
        }

        // connections to the mouse
        let dxMouse = particles[a].x - mouse.x;
        let dyMouse = particles[a].y - mouse.y;
        let distanceMouse = Math.sqrt(dxMouse * dxMouse + dyMouse * dyMouse);
        let strokeStyleColorMouse = currentSite.includes("index") || currentSite === "" ? "101, 144, 187" : "59, 59, 59";
        if (distanceMouse < mouse.radius) { // mouse.radius is the range
            opacityValue = 1 - (distanceMouse / mouse.radius);
            ctx.strokeStyle = 'rgba(' + strokeStyleColorMouse + ',' + opacityValue + ')';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(particles[a].x, particles[a].y);
            ctx.lineTo(mouse.x, mouse.y);
            ctx.stroke();
        }
    }
}

function animate() {
    requestAnimationFrame(animate);
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    for (let i = 0; i < particles.length; i++) {
        particles[i].update();
    }
    connect(currentSite);
}

window.addEventListener('resize', () => {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    init();
});

let currentSite = window.location.pathname;

currentSite = currentSite.split("/");
currentSite = currentSite[currentSite.length - 1];

init(currentSite);
animate(currentSite);