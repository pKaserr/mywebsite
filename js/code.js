const copyCodeBtn = document.querySelectorAll('.code-box__copy-btn');
copyCodeBtn.forEach(btn => {
    btn.addEventListener('click', () => {
        const codebox = btn.closest('.code-box');
        const code = codebox.querySelector('code');
        const textArea = document.createElement('textarea');
        textArea.value = code.innerText;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        addCopiedText();
    });
});


function addCopiedText() {
    const e = window.event;
    const x = e.clientX;
    const y = e.clientY;

    // create copied text
    const copiedText = document.createElement('div');
    copiedText.style.position = 'fixed';
    copiedText.style.left = x + 'px';
    copiedText.style.top = y + 'px';
    copiedText.style.zIndex = '10';
    copiedText.style.backgroundColor = '#2d8551';
    copiedText.style.color = '#fff';
    copiedText.style.padding = '5px 10px';
    copiedText.style.borderRadius = '5px';
    copiedText.style.fontSize = '14px';
    copiedText.style.fontFamily = 'monospace';
    copiedText.style.whiteSpace = 'nowrap';
    copiedText.style.pointerEvents = 'none';
    copiedText.textContent = 'Copied!';
    document.body.appendChild(copiedText);

    // remove copied text
    setTimeout(() => {
        copiedText.remove();
    }, 2000);
}
