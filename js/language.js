/**
 * Language switching system for the website
 * Handles switching between German (de) and English (en)
 * Stores preference in localStorage
 */

class LanguageManager {
    constructor() {
        this.currentLanguage = this.getStoredLanguage() || 'de'; // Default to German
        this.translations = {};
        this.initialized = false;
        
        // Initialize the language system
        this.init();
    }

    /**
     * Initialize the language system
     */
    async init() {
        await this.loadTranslations();
        this.createLanguageSwitcher();
        this.applyTranslations();
        this.initialized = true;
    }

    /**
     * Get stored language from localStorage
     */
    getStoredLanguage() {
        return localStorage.getItem('preferredLanguage');
    }

    /**
     * Store language preference in localStorage
     */
    storeLanguage(language) {
        localStorage.setItem('preferredLanguage', language);
    }

    /**
     * Load translation files for both languages
     */
    async loadTranslations() {
        try {
            // Load German translations
            const deResponse = await fetch('./languages/de.json');
            this.translations.de = await deResponse.json();
            
            // Load English translations
            const enResponse = await fetch('./languages/en.json');
            this.translations.en = await enResponse.json();
            
            console.log('Translations loaded successfully');
        } catch (error) {
            console.error('Error loading translations:', error);
            // Fallback to German if loading fails
            this.currentLanguage = 'de';
        }
    }

    /**
     * Create language switcher in navigation
     */
    createLanguageSwitcher() {
        const nav = document.querySelector('.nav');
        if (!nav) return;

        // Create language switcher container
        const languageSwitcher = document.createElement('div');
        languageSwitcher.className = 'language-switcher';
        
        // Create German flag button
        // const germanFlag = this.createFlagButton('de', '🇩🇪', 'Deutsch');
        
        // Create English flag button
        // const englishFlag = this.createFlagButton('en', '🇬🇧', 'English');

        // import flag png
        const germanFlagPng = document.createElement('img');
        germanFlagPng.src = './assets/img/Flag_of_Germany-128x77.png';
        germanFlagPng.alt = 'Deutsch';
        germanFlagPng.className = 'flag';
        germanFlagPng.title = 'Deutsch';
        germanFlagPng.setAttribute('data-language', 'de');
        germanFlagPng.addEventListener('click', () => this.switchLanguage('de'));

        const englishFlagPng = document.createElement('img');
        englishFlagPng.src = './assets/img/Flag_of_United_Kingdom-128x64.png';
        englishFlagPng.alt = 'English';
        englishFlagPng.className = 'flag';
        englishFlagPng.title = 'English';
        englishFlagPng.setAttribute('data-language', 'en');
        englishFlagPng.addEventListener('click', () => this.switchLanguage('en'));

        germanFlagPng.style.width = '60px';
        germanFlagPng.style.height = '30px';
        englishFlagPng.style.width = '60px';
        englishFlagPng.style.height = '30px';

        languageSwitcher.appendChild(germanFlagPng);
        languageSwitcher.appendChild(englishFlagPng);

        // languageSwitcher.appendChild(germanFlag);
        // languageSwitcher.appendChild(englishFlag);
        
        // Insert at the beginning of nav
        nav.insertBefore(languageSwitcher, nav.firstChild);
        
        // Update active state
        this.updateActiveFlag();
    }

    /**
     * Create individual flag button
     */
    createFlagButton(language, flag, tooltip) {
        const button = document.createElement('button');
        button.className = `language-btn language-btn--${language}`;
        button.innerHTML = `<span class="flag">${flag}</span>`;
        button.title = tooltip;
        button.setAttribute('data-language', language);
        
        // Add click event listener
        button.addEventListener('click', () => this.switchLanguage(language));
        
        return button;
    }

    /**
     * Switch to specified language
     */
    async switchLanguage(language) {
        if (language === this.currentLanguage) return;
        
        this.currentLanguage = language;
        this.storeLanguage(language);
        this.updateActiveFlag();
        this.applyTranslations();
        
        // Update page title if needed
        this.updatePageTitle();
        
        // Dispatch language change event
        document.dispatchEvent(new CustomEvent('languageChanged', { 
            detail: { language: this.currentLanguage } 
        }));
    }

    /**
     * Update active state of flag buttons
     */
    updateActiveFlag() {
        const buttons = document.querySelectorAll('.language-btn');
        buttons.forEach(button => {
            const lang = button.getAttribute('data-language');
            button.classList.toggle('active', lang === this.currentLanguage);
        });
    }

    /**
     * Apply translations to the current page
     */
    applyTranslations() {
        if (!this.translations[this.currentLanguage]) {
            console.error(`Translations for ${this.currentLanguage} not found`);
            return;
        }

        const translations = this.translations[this.currentLanguage];
        
        // Apply translations to elements with data-translate attribute
        document.querySelectorAll('[data-translate]').forEach(element => {
            const key = element.getAttribute('data-translate');
            const translatedText = this.getNestedTranslation(translations, key);
            
            if (translatedText) {
                // Check if element has data-translate-html for HTML content
                if (element.hasAttribute('data-translate-html')) {
                    element.innerHTML = translatedText;
                } else {
                    element.textContent = translatedText;
                }
            }
        });

        // Apply translations to placeholders
        document.querySelectorAll('[data-translate-placeholder]').forEach(element => {
            const key = element.getAttribute('data-translate-placeholder');
            const translatedText = this.getNestedTranslation(translations, key);
            
            if (translatedText) {
                element.placeholder = translatedText;
            }
        });

        // Apply translations to titles/tooltips
        document.querySelectorAll('[data-translate-title]').forEach(element => {
            const key = element.getAttribute('data-translate-title');
            const translatedText = this.getNestedTranslation(translations, key);
            
            if (translatedText) {
                element.title = translatedText;
            }
        });
    }

    /**
     * Get nested translation value from translation object
     */
    getNestedTranslation(translations, key) {
        return key.split('.').reduce((obj, k) => (obj && obj[k]) ? obj[k] : null, translations);
    }

    /**
     * Update page title based on current page
     */
    updatePageTitle() {
        const currentPage = this.getCurrentPage();
        const translations = this.translations[this.currentLanguage];
        
        let title = 'Patrick Kaserer';
        
        // Add page-specific titles
        switch(currentPage) {
            case 'timeline':
                title += ` - ${translations.timeline?.title || 'Timeline'}`;
                break;
            case 'about_me':
                title += ` - ${translations.about_me?.title || 'About Me'}`;
                break;
            case 'experience':
                title += ` - ${translations.experience?.title || 'Experience'}`;
                break;
            case 'dashboard':
                title += ' - Dashboard';
                break;
        }
        
        document.title = title;
    }

    /**
     * Get current page name from URL
     */
    getCurrentPage() {
        const path = window.location.pathname;
        const page = path.split('/').pop().split('.')[0];
        return page || 'index';
    }

    /**
     * Get current language
     */
    getCurrentLanguage() {
        return this.currentLanguage;
    }

    /**
     * Get translation for specific key
     */
    translate(key, variables = {}) {
        if (!this.translations[this.currentLanguage]) return key;
        
        let translation = this.getNestedTranslation(this.translations[this.currentLanguage], key);
        
        if (!translation) return key;
        
        // Replace variables in translation
        Object.keys(variables).forEach(variable => {
            translation = translation.replace(`{${variable}}`, variables[variable]);
        });
        
        return translation;
    }
}

// Initialize language manager when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.languageManager = new LanguageManager();
});

// Helper function for easy access in PHP/HTML
function t(key, variables = {}) {
    if (window.languageManager && window.languageManager.initialized) {
        return window.languageManager.translate(key, variables);
    }
    return key;
}