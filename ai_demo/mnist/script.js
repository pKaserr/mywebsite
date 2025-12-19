let model;
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');

// --- SETUP ---
// Etwas dickere Linie, damit sie beim Verkleinern auf 28x28 sichtbar bleibt
ctx.lineWidth = 25; 
ctx.lineCap = 'round';
ctx.lineJoin = 'round';
ctx.fillStyle = "black";
ctx.fillRect(0, 0, canvas.width, canvas.height);
ctx.strokeStyle = "white"; 

let drawing = false;

// --- EVENT LISTENER (KORRIGIERT) ---
canvas.addEventListener('mousedown', (e) => { 
  drawing = true; 
  // WICHTIG: Beim Klicken sofort neuen Pfad beginnen und zum Punkt springen
  ctx.beginPath();
  ctx.moveTo(e.offsetX, e.offsetY);
  // Optional: Sofort einen Punkt malen, falls man nur klickt
  draw(e); 
});

canvas.addEventListener('mouseup', () => { 
  drawing = false; 
  ctx.beginPath(); // Pfad beenden, damit keine Linien verbunden werden
  predict(); // Automatisch vorhersagen, wenn man loslässt
});

canvas.addEventListener('mouseout', () => { 
  drawing = false; 
});

canvas.addEventListener('mousemove', draw);

function draw(e) {
  if (!drawing) return;

  ctx.lineTo(e.offsetX, e.offsetY);
  ctx.stroke();
  
  // Trick: Für weichere Linien nicht immer beginPath/moveTo machen, 
  // sondern den Pfad fortlaufend lassen, solange die Maus unten ist.
  // Aber dein Ansatz mit 'dot-to-dot' ist okay, wenn moveTo korrekt gesetzt wird.
  ctx.beginPath();
  ctx.moveTo(e.offsetX, e.offsetY);
}

function clearCanvas() {
  ctx.fillStyle = "black";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  ctx.beginPath();
  document.getElementById("predictions").innerHTML = ""; // Ergebnis löschen
}

async function loadModel() {
  // Wir nutzen ein anderes, robusteres Modell direkt für Ziffern
  // Das Transfer-CNN ist oft zickig ohne Training. Dieses hier ist ein einfaches MLP oder CNN für MNIST.
  try {
    model = await tf.loadLayersModel('https://storage.googleapis.com/tfjs-models/tfjs/mnist_transfer_cnn_v1/model.json');
    console.log("Model loaded!");
  } catch (err) {
    console.error("Fehler beim Laden:", err);
  }
}

async function predict() {
  if (!model) return;

  // 1. Tensor erstellen
  let tensor = tf.browser.fromPixels(canvas, 1)
    .resizeBilinear([28, 28]) // WICHTIG: Bilinear hält die Linien weich beim Verkleinern
    .toFloat()
    .div(255.0);

  // 2. Expand Dims für Batch [1, 28, 28, 1]
  let input = tensor.expandDims(0);

  // 3. Vorhersage
  let prediction = model.predict(input);
  let probs = prediction.dataSync();
  
  // Debug: Schau mal, ob das Bild "ankommt" (Max Wert sollte > 0 sein)
  // console.log("Input Max Value:", tensor.max().dataSync()[0]);

  // 4. Sortieren
  let top = Array.from(probs)
    .map((p, i) => ({ probability: p, digit: i }))
    .sort((a, b) => b.probability - a.probability)
    .slice(0, 3);

  // 5. Anzeige
  let out = "<h3>Ergebnis:</h3>";
  top.forEach(t => {
    // Farbe für hohe Wahrscheinlichkeit ändern
    let color = t.probability > 0.8 ? "green" : "gray";
    out += `<div style="display:flex; align-items:center; margin-bottom:5px;">
              <span style="width:20px; font-weight:bold;">${t.digit}</span>
              <div style="background:#ddd; width:200px; height:20px; margin:0 10px;">
                <div style="width:${t.probability * 100}%; background:${color}; height:100%;"></div>
              </div>
              <span>${(t.probability * 100).toFixed(1)}%</span>
            </div>`;
  });

  document.getElementById("predictions").innerHTML = out;

  // Speicher aufräumen
  tensor.dispose();
  input.dispose();
  prediction.dispose();
}

loadModel();