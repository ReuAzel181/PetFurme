<div class="cookie-consent-wrapper">
    <div id="cookie-consent" class="cookie-banner" style="display: none;">
        <div class="cookie-content">
            <div class="cookie-header">
                <h3>🍪 Cookie Settings</h3>
                <p>We use cookies to improve your experience.</p>
            </div>
            <div class="cookie-actions">
                <button onclick="acceptCookies()" class="cookie-btn accept">
                    Accept All
                </button>
                <button onclick="declineCookies()" class="cookie-btn decline">
                    Essential Only
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.cookie-consent-wrapper {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    z-index: 99999;
    pointer-events: none;
}

#cookie-consent {
    position: relative;
    width: 300px;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.12);
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    pointer-events: auto;
}

#cookie-consent.show {
    transform: translateY(0);
    opacity: 1;
}

.cookie-content {
    padding: 1.5rem;
}

.cookie-header {
    margin-bottom: 1rem;
}

.cookie-header h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
    margin: 0 0 0.5rem 0;
}

.cookie-header p {
    font-size: 0.875rem;
    color: #666;
    margin: 0;
    line-height: 1.4;
}

.cookie-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
}

.cookie-btn {
    width: 100%;
    padding: 0.625rem;
    border: none;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.cookie-btn.accept {
    background: #3b82f6;
    color: white;
}

.cookie-btn.accept:hover {
    background: #2563eb;
}

.cookie-btn.decline {
    background: #f3f4f6;
    color: #4b5563;
}

.cookie-btn.decline:hover {
    background: #e5e7eb;
}

.cookie-link {
    display: block;
    text-align: center;
    font-size: 0.75rem;
    color: #6b7280;
    text-decoration: none;
    transition: color 0.2s ease;
}

.cookie-link:hover {
    color: #3b82f6;
    text-decoration: underline;
}

@media (max-width: 640px) {
    .cookie-consent-wrapper {
        bottom: 1rem;
        right: 1rem;
        left: 1rem;
    }

    #cookie-consent {
        width: 100%;
        max-width: none;
    }

    .cookie-content {
        padding: 1.25rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    #cookie-consent {
        background: rgba(31, 41, 55, 0.98);
    }

    .cookie-header h3 {
        color: #fff;
    }

    .cookie-header p {
        color: #9ca3af;
    }

    .cookie-btn.decline {
        background: #374151;
        color: #e5e7eb;
    }

    .cookie-btn.decline:hover {
        background: #4b5563;
    }

    .cookie-link {
        color: #9ca3af;
    }
}
</style>

<script>
const checkCookieConsent = () => {
    const cookieConsent = document.getElementById('cookie-consent');
    const wrapper = cookieConsent?.closest('.cookie-consent-wrapper');
    if (!cookieConsent || !wrapper) return;

    const hasConsent = localStorage.getItem('cookieConsent') || 
                      document.cookie.split(';').some(c => c.trim().startsWith('cookie_consent='));

    if (!hasConsent) {
        cookieConsent.style.display = 'block';
        requestAnimationFrame(() => {
            cookieConsent.classList.add('show');
        });
    }
};

function acceptCookies() {
    const cookieConsent = document.getElementById('cookie-consent');
    
    setCookie('cookie_consent', 'accepted', 365);
    setCookie('XSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')?.content, 1);
    localStorage.setItem('cookieConsent', 'accepted');
    
    if (cookieConsent) {
        cookieConsent.classList.remove('show');
        setTimeout(() => {
            cookieConsent.style.display = 'none';
        }, 400);
    }

    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').catch(console.error);
    }
}

function declineCookies() {
    const cookieConsent = document.getElementById('cookie-consent');
    
    setCookie('cookie_consent', 'declined', 365);
    setCookie('XSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')?.content, 1);
    localStorage.setItem('cookieConsent', 'declined');
    
    if (cookieConsent) {
        cookieConsent.classList.remove('show');
        setTimeout(() => {
            cookieConsent.style.display = 'none';
        }, 400);
    }
}

function setCookie(name, value, days) {
    const secure = window.location.protocol === 'https:' ? 'Secure;' : '';
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    
    document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/; SameSite=Lax; ${secure}`;
}

// Execute immediately if DOM is ready
if (document.readyState !== 'loading') {
    checkCookieConsent();
} else {
    document.addEventListener('DOMContentLoaded', checkCookieConsent);
}
</script> 