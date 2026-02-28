document.addEventListener('DOMContentLoaded', () => {
    // Create tooltip element
    const tooltipElem = document.createElement('div');
    tooltipElem.className = 'custom-tooltip';
    document.body.appendChild(tooltipElem);

    // Track mouse to position tooltip
    document.addEventListener('mousemove', (e) => {
        const target = e.target.closest('.has-tooltip');
        if (target) {
            const text = target.getAttribute('data-tooltip');
            if (text) {
                tooltipElem.textContent = text;
                
                // Position slightly offset from mouse
                let leftPos = e.pageX + 15;
                let topPos = e.pageY + 15;
                
                // Prevent overflowing screen bounds
                const tooltipRect = tooltipElem.getBoundingClientRect();
                if (leftPos + tooltipRect.width > window.innerWidth) {
                    leftPos = e.pageX - tooltipRect.width - 15;
                }
                if (topPos + tooltipRect.height > window.innerHeight + window.scrollY) {
                    topPos = e.pageY - tooltipRect.height - 15;
                }
                
                tooltipElem.style.left = leftPos + 'px';
                tooltipElem.style.top = topPos + 'px';
                tooltipElem.classList.add('visible');
            }
        } else {
            tooltipElem.classList.remove('visible');
        }
    });
});
