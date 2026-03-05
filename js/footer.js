const textarea = document.getElementById('footer-contact-message');
const charCount = document.getElementById('char-count');

charCount.textContent = `0/${textarea.maxLength}`;

textarea.addEventListener('input', () => {
    const maxLength = textarea.maxLength;
    const currentLength = textarea.value.length;
    charCount.textContent = `${currentLength}/${maxLength}`;
});

const cookieBannerBtn = document.getElementById('cookie-banner-btn');
const cookieBanner = document.querySelector('.cookie-banner');

if (cookieBannerBtn && cookieBanner) {
    cookieBannerBtn.addEventListener('click', () => {
        // Dauer: z.B. 30 Tage (30 * 24 * 60 * 60 = 2592000 Sekunden)
        document.cookie = "cookieConsent=1; path=/; max-age=2592000; SameSite=Lax";
        cookieBanner.style.display = 'none';
    });
}
