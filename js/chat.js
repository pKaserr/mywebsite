const userInput = document.querySelector('.chatbox__userInput');
const display = document.querySelector('.chatbox__display');


userInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        const question = userInput.value;
        if (question.trim() === "") return;
        display.innerHTML += `<p class="chatbox__message chatbox__message--right">${question}</p>`;
        userInput.value = "";
        display.scrollTop = display.scrollHeight;
        askAI(question);
    }
});

function toggleChatboxSize() {
    const toggleButton = document.querySelector('.chatbox__toggle');
    const chatbox = document.querySelector('.chatbox');
    chatbox.classList.toggle('chatbox--open');
    toggleButton.textContent = chatbox.classList.contains('chatbox--open') ? 'Verkleinern' : 'Vergrößern';
}

function minimizeChatBox() {
    const chatbox = document.querySelector('.chatbox');
    chatbox.classList.toggle('chatbox--minimized');
    const toggleButton = document.querySelector('.chatbox__minimize');
    toggleButton.textContent = chatbox.classList.contains('chatbox--minimized') ? 'Ausklappen' : 'Einklappen';
}

async function askAI(question) {
    try {
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

        display.innerHTML += `<p class="chatbox__message chatbox__message--left">${data.answer}</p>`;

    } catch (error) {
        display.innerHTML += `<p><strong>AI:</strong> Fehler: ${String(error)}</p>`;
    }
}
