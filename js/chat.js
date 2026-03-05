const chatbox = document.querySelector('.chatbox');
const display = document.querySelector('.chatbox__display');
const toggleButton = document.querySelector('.chatbox__toggle');
const minimizeButton = document.querySelector('.chatbox__minimize');
const userInput = document.querySelector('.chatbox__userInput');
const btn = document.querySelector('.chatbox__btn');
const chatCharCount = document.getElementById('chat-char-count');

console.log("test")

document.addEventListener('DOMContentLoaded', () => {
    const savedHistory = sessionStorage.getItem('chatHistory');
    const savedMinimized = sessionStorage.getItem('chatMinimized');
    if (savedHistory) {
        display.innerHTML = savedHistory;
        display.scrollTop = display.scrollHeight; // Scroll to bottom
        chatbox.style.transition = "none";
    }
    if (savedMinimized === "1" || document.cookie.includes("chatMinimized=1")) {
        chatbox.classList.add('chatbox--minimized');
        minimizeButton.textContent = "Ausklappen";
    }
});

userInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        askAI();
    }
});

btn.addEventListener('click', function () {
    askAI();
});

function toggleChatboxSize() {
    chatbox.classList.toggle('chatbox--open');
    toggleButton.textContent = chatbox.classList.contains('chatbox--open') ? 'Verkleinern' : 'Vergrößern';
}

function minimizeChatBox() {
    chatbox.classList.toggle('chatbox--minimized');
    minimizeButton.textContent = chatbox.classList.contains('chatbox--minimized') ? 'Ausklappen' : 'Einklappen';

    if (chatbox.classList.contains('chatbox--minimized')) {
        sessionStorage.setItem('chatMinimized', 1);
        document.cookie = "chatMinimized=1; path=/; max-age=2592000"; // cookie für PHP für direktes rendern
    } else {
        sessionStorage.setItem('chatMinimized', 0);
        document.cookie = "chatMinimized=0; path=/; max-age=2592000";
    }
}


chatCharCount.textContent = `0/${userInput.maxLength}`;

userInput.addEventListener('input', () => {
    const maxLength = userInput.maxLength;
    const currentLength = userInput.value.length;
    chatCharCount.textContent = `${currentLength}/${maxLength}`;
});


function addThinkingElements() {
    display.innerHTML += `<p id="chatbox_thinking" class="chatbox__message chatbox__message--left">Denke nach...</p>`;
    display.scrollTop = display.scrollHeight;
}

function removeThinkingElements() {
    const thinkingElement = document.getElementById('chatbox_thinking');
    if (thinkingElement) {
        thinkingElement.remove();
    }
}

async function askAI() {
    const question = userInput.value;
    if (question.trim() === "") return;

    display.innerHTML += `<p class="chatbox__message chatbox__message--right">${question}</p>`;
    sessionStorage.setItem('chatHistory', display.innerHTML); // Save after user message

    userInput.value = "";
    addThinkingElements();
    display.scrollTop = display.scrollHeight;

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
        removeThinkingElements();
        // data.answer is now HTML (parsed markdown), so we wrap it in a div with the left class
        display.innerHTML += `<div class="chatbox__message chatbox__message--left">${data.answer}</div>`;
        sessionStorage.setItem('chatHistory', display.innerHTML); // Save after AI response
        display.scrollTop = display.scrollHeight;

    } catch (error) {
        display.innerHTML += `<div class="chatbox__message chatbox__message--left"><strong>AI:</strong> Fehler: ${String(error)}</div>`;
    }
}
