async function askAI() {
    const questionField = document.getElementById('userInput');
    const question = questionField.value;
    
    // UI Feedback: "KI tippt..."
    document.getElementById('p_text').value = question;
    document.getElementById('p_text').value =  "AI denkt nach...";

    try {
        // Aufruf an dein lokales PHP Skript
        const response = await fetch('chat.php', {
            method: 'POST',
            body: JSON.stringify({ question: question }),
            headers: { 'Content-Type': 'application/json' }
        });
        console.log(response);
        const ct = response.headers.get('content-type') || '';
        let data;
        if (ct.includes('application/json')) {
            data = await response.json();
        } else {
            const text = await response.text();
            throw new Error('Server lieferte kein JSON: ' + text.slice(0, 200));
        }
        console.log(data);
        
        // Lade-Text entfernen und Antwort anzeigen
        // document.getElementById('loading').remove();
        // document.getElementById('dashboard__chatBox').innerHTML += `<p><strong>AI:</strong> ${data.answer}</p>`;
        document.getElementById('p_text').value += data.answer;

        
    } catch (error) {
        console.error("Fehler:", error);
        const loadingEl = document.getElementById('loading');
        if (loadingEl) loadingEl.remove();
        document.getElementById('dashboard__chatBox').innerHTML += `<p><strong>AI:</strong> Fehler: ${String(error)}</p>`;
    }
}
