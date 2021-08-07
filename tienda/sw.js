var CACHE_NAME = 'my-site-cache-v3';
var urlsToCache = [

];

self.addEventListener('install', event => {
    console.log('service worker installed');

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('activate', event => {
    console.log('Sevice worker activate event');

    event.waitUntil(
        caches.keys().then(keys => {
            /* console.log(keys);*/
            return Promise.all(
                keys.filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))
            )
        })
    );
});


self.addEventListener('fetch', event => {
    // console.log('Service Worker fetching', event);
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                    // Cache hit - return response
                    return response || fetch(event.request);
                }
            ).catch(() => caches.match('utils/fallback.html'))
    );
});
