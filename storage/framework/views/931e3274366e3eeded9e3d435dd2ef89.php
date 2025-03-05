<div id="cookie-consent" class="fixed bottom-0 left-0 right-0 bg-white shadow-lg transform translate-y-full transition-transform duration-300 z-[9999] safe-bottom" style="display: none;">
    <div class="max-w-screen-xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div class="flex-1">
            <h3 class="text-sm font-semibold text-gray-900 mb-1">🍪 Cookie Settings</h3>
            <p class="text-sm text-gray-600">
                We use cookies to improve your experience and analyze site usage. 
                <a href="<?php echo e(route('privacy-policy')); ?>" class="text-blue-600 hover:text-blue-800 underline">Learn more</a>
            </p>
        </div>
        <div class="flex flex-row sm:flex-row gap-2 w-full sm:w-auto">
            <button onclick="acceptCookies()" 
                    class="flex-1 sm:flex-none px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Accept All
            </button>
            <button onclick="declineCookies()" 
                    class="flex-1 sm:flex-none px-4 py-2.5 bg-gray-100 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                Essential Only
            </button>
        </div>
    </div>
</div>

<style>
#cookie-consent {
    transform: translateY(100%);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 -4px 6px -1px rgba(0, 0, 0, 0.1), 0 -2px 4px -1px rgba(0, 0, 0, 0.06);
}

#cookie-consent.show {
    transform: translateY(0);
}

.auth-page #cookie-consent {
    background-color: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(8px);
}

@media (max-width: 640px) {
    #cookie-consent {
        padding-bottom: env(safe-area-inset-bottom);
    }
}
</style>

<script>
// Optimize the cookie check
const checkCookieConsent = () => {
    const cookieConsent = document.getElementById('cookie-consent');
    if (!cookieConsent) return;

    const hasConsent = localStorage.getItem('cookieConsent') || 
                      document.cookie.split(';').some(c => c.trim().startsWith('cookie_consent='));

    if (!hasConsent) {
        cookieConsent.style.display = 'block';
        requestAnimationFrame(() => {
            cookieConsent.classList.add('show');
        });
    }
};

// Execute immediately if DOM is ready
if (document.readyState !== 'loading') {
    checkCookieConsent();
} else {
    document.addEventListener('DOMContentLoaded', checkCookieConsent);
}

// Optimize cookie functions
function acceptCookies() {
    setCookie('cookie_consent', 'accepted', 365);
    setCookie('XSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')?.content, 1);
    
    localStorage.setItem('cookieConsent', 'accepted');
    
    const cookieConsent = document.getElementById('cookie-consent');
    if (cookieConsent) {
        cookieConsent.classList.remove('show');
    }

    // Register service worker after consent
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').catch(console.error);
    }
}

function declineCookies() {
    try {
        // Set only essential cookies
        setCookie('cookie_consent', 'declined', 365);
        setCookie('XSRF-TOKEN', document.querySelector('meta[name="csrf-token"]')?.content, 1);
        
        localStorage.setItem('cookieConsent', 'declined');
        
        // Hide banner with animation
        const cookieConsent = document.getElementById('cookie-consent');
        cookieConsent?.classList.remove('show');
    } catch (error) {
        console.error('Error in declineCookies:', error);
    }
}

function setCookie(name, value, days) {
    const secure = window.location.protocol === 'https:' ? 'Secure;' : '';
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    
    document.cookie = `${name}=${value}; expires=${date.toUTCString()}; path=/; SameSite=Lax; ${secure}`;
}
</script> <?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/components/cookie-consent.blade.php ENDPATH**/ ?>