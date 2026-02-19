const CACHE_NAME = 'sidara-cache-v1';
const OFFLINE_URLS = ['/', '/logo.jpeg', '/manifest.json'];

self.addEventListener('install', function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function (cache) {
      return cache.addAll(OFFLINE_URLS);
    })
  );
  self.skipWaiting();
});

self.addEventListener('activate', function (event) {
  event.waitUntil(
    caches.keys().then(function (keys) {
      return Promise.all(
        keys.map(function (key) {
          if (key !== CACHE_NAME) {
            return caches.delete(key);
          }
          return null;
        })
      );
    })
  );
  self.clients.claim();
});

self.addEventListener('fetch', function (event) {
  if (event.request.method !== 'GET') {
    return;
  }

  try {
    var url = new URL(event.request.url);
    if (url.protocol !== 'http:' && url.protocol !== 'https:') {
      return;
    }
  } catch (e) {
    return;
  }

  event.respondWith(
    caches.match(event.request).then(function (cachedResponse) {
      if (cachedResponse) {
        return cachedResponse;
      }

      return fetch(event.request)
        .then(function (networkResponse) {
          if (
            !networkResponse ||
            networkResponse.status !== 200 ||
            networkResponse.type !== 'basic'
          ) {
            return networkResponse;
          }

          const responseClone = networkResponse.clone();

          caches.open(CACHE_NAME).then(function (cache) {
            cache.put(event.request, responseClone);
          });

          return networkResponse;
        })
        .catch(function () {
          if (event.request.mode === 'navigate') {
            return caches.match('/');
          }
          return caches.match(event.request);
        });
    })
  );
});
