<x-front-layout title="Order Details">

    @push('scriptsabove')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script type="module">
        let map;

        async function initMap() {
            // The location of Uluru
            const position = {
                lat: parseFloat("{{ $delivery->lat }}"),
                lng: parseFloat("{{ $delivery->lng }}"),
            };
            // Request needed libraries.
            // @ts-ignore
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            map = new Map(document.getElementById("map"), {
                zoom: 15,
                // center: { lat: parseFloat(lat), lng: parseFloat(lng) ,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Uluru
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Uluru",
            });
        }

        initMap();
    </script>
    @endpush

    <section class="checkout-wrapper section">
        <div class="container">
            <div id="map" style="
                height: 400px; 
                width: 100%; 
            ">
            </div>
        </div>
    </section>
    @push('scripts')
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
    
        var pusher = new Pusher('f6bd1afe857e47443677', {
          cluster: 'ap2'
        });
    
        var channel = pusher.subscribe('deliveries');
        channel.bind('location-updated', function(data) {
          alert(JSON.stringify(data));
        });
      </script>
        <script>
            (g => {
                var h, a, k, p = "The Google Maps JavaScript API",
                    c = "google",
                    l = "importLibrary",
                    q = "__ib__",
                    m = document,
                    b = window;
                b = b[c] || (b[c] = {});
                var d = b.maps || (b.maps = {}),
                    r = new Set,
                    e = new URLSearchParams,
                    u = () => h || (h = new Promise(async (f, n) => {
                        await (a = m.createElement("script"));
                        e.set("libraries", [...r] + "");
                        for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                        e.set("callback", c + ".maps." + q);
                        a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                        d[q] = f;
                        a.onerror = () => h = n(Error(p + " could not load."));
                        a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                        m.head.append(a)
                    }));
                d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() =>
                    d[l](f, ...n))
            })
            ({
                key: "AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg",
                v: "weekly"
            });
        </script>
    @endpush

</x-front-layout>
