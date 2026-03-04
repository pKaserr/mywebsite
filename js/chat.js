const userInput = document.querySelector('.chatbox__userInput');
const display = document.querySelector('.chatbox__display');

// Load chat history from sessionStorage on page load
document.addEventListener('DOMContentLoaded', () => {
    const savedHistory = sessionStorage.getItem('chatHistory');
    if (savedHistory) {
        display.innerHTML = savedHistory;
        display.scrollTop = display.scrollHeight; // Scroll to bottom
    }
});

userInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        const question = userInput.value;
        if (question.trim() === "") return;
        
        display.innerHTML += `<p class="chatbox__message chatbox__message--right">${question}</p>`;
        sessionStorage.setItem('chatHistory', display.innerHTML); // Save after user message
        
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
        const ct = response.headers.get('content-type') || '';
        let data;

        if (ct.includes('application/json')) {
            data = await response.json();

        } else {
            const text = await response.text();
            throw new Error('Server lieferte kein JSON: ' + text.slice(0, 200));
        }

        // data.answer is now HTML (parsed markdown), so we wrap it in a div with the left class
        display.innerHTML += `<div class="chatbox__message chatbox__message--left">${data.answer}</div>`;
        sessionStorage.setItem('chatHistory', display.innerHTML); // Save after AI response
        display.scrollTop = display.scrollHeight;
        
    } catch (error) {
        display.innerHTML += `<div class="chatbox__message chatbox__message--left"><strong>AI:</strong> Fehler: ${String(error)}</div>`;
    }
}
