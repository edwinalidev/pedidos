// service-worker.js
const staticDevCoffee = "dev-coffee-site-v1"
const assets = [
  "/",
  "/index.php",
]

self.addEventListener("install", installEvent => {
  installEvent.waitUntil(
    caches.open(staticDevCoffee).then(cache => {
      cache.addAll(assets)
    })
  )
})

