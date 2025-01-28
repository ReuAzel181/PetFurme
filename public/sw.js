const CACHE_NAME = 'petfurme-cache-v1';
const urlsToCache = [
    '/fonts/Inter-Variable.woff2',
    '/favicon.ico',
    '/images/default-avatar.png',
    '/storage/defaults/clinic-logo.png',
    '/storage/defaults/no-avatar.jpg',
    '/dist/css/tabler.min.css',
    '/dist/js/tabler.min.js'
];

// Optimize cookie consent check
let consentStatus = null;

async function checkConsent() {
    if (consentStatus !== null) return consentStatus;
    try {
        const response = await fetch('/api/check-cookie-consent');
        const data = await response.json();
        consentStatus = data.consent === 'accepted';
        return consentStatus;
    } catch {
        return false;
    }
}

self.addEventListener('install', event => {
    event.waitUntil(
        checkConsent().then(hasConsent => {
            if (hasConsent) {
                return caches.open(CACHE_NAME)
                    .then(cache => cache.addAll(urlsToCache));
            }
        })
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        checkConsent().then(hasConsent => {
            if (hasConsent && !event.request.url.includes('/api/')) {
                return caches.match(event.request)
                    .then(response => response || fetch(event.request));
            }
            return fetch(event.request);
        }).catch(() => fetch(event.request))
    );
}); 