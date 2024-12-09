<!-- Map Section -->
<section class="map-section">
    <div class="map-outer">
        <!-- Contenedor del Mapa -->
        <div id="map-canvas" style="height: 450px; width: 100%;"></div>

        <!-- Información Adicional -->
        <div class="info-area wow fadeInLeft">
            <div class="inner">
                <!-- Información del Venue -->
                <div class="info-block">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-gps"></span></div>
                        <h3><a href="#">Ubicación del Evento</a></h3>
                        <div class="text">
                            <?= esc($congreso['direccion']); ?>
                        </div>
                    </div>
                </div>

                <!-- Información Extra: Hoteles -->
                <div class="info-block">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-sun-umbrella"></span></div>
                        <h3><a href="#">Hoteles Cercanos</a></h3>
                        <div class="text">Consulta alojamiento cercano al lugar del evento.</div>
                    </div>
                </div>

                <!-- Información Extra: Transporte -->
                <div class="info-block">
                    <div class="inner-box">
                        <div class="icon-box"><span class="icon flaticon-airplane-around-earth"></span></div>
                        <h3><a href="#">Transporte</a></h3>
                        <div class="text">Opciones de transporte cercanas.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    section.map-section .info-area {
        z-index: 400;
    }
</style>
<!-- Leaflet CSS y JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // Coordenadas del evento
    var eventLocation = {
        lat: <?= esc($congreso['latitud'] ?? '0.0'); ?>,
        lng: <?= esc($congreso['longitud'] ?? '0.0'); ?>
    };

    // Crear el mapa
    var map = L.map('map-canvas').setView([eventLocation.lat, eventLocation.lng], 14);

    // Capa base de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Marcador del Evento
    L.marker([eventLocation.lat, eventLocation.lng])
        .bindPopup(`<h4><?= esc($congreso['nombre']); ?></h4><p><?= esc($congreso['direccion']); ?></p>`)
        .addTo(map);

    // Marcadores de Hoteles Cercanos
    var hotels = [{
            lat: eventLocation.lat + 0.01,
            lng: eventLocation.lng + 0.01,
            name: "Hotel A",
            address: "Calle 1, Ciudad"
        },
        {
            lat: eventLocation.lat - 0.01,
            lng: eventLocation.lng - 0.01,
            name: "Hotel B",
            address: "Calle 2, Ciudad"
        }
    ];

    hotels.forEach(hotel => {
        L.marker([hotel.lat, hotel.lng], {
                icon: getIcon('hotel')
            })
            .bindPopup(`<h4>${hotel.name}</h4><p>${hotel.address}</p>`)
            .addTo(map);
    });

    // Marcadores de Transporte Cercano
    var transport = [{
            lat: eventLocation.lat + 0.02,
            lng: eventLocation.lng,
            name: "Estación de Tren"
        },
        {
            lat: eventLocation.lat,
            lng: eventLocation.lng - 0.02,
            name: "Aeropuerto Internacional"
        }
    ];

    transport.forEach(t => {
        L.marker([t.lat, t.lng], {
                icon: getIcon('transport')
            })
            .bindPopup(`<h4>${t.name}</h4><p>Opciones de transporte cercanas</p>`)
            .addTo(map);
    });

    // Función para cargar íconos personalizados
    function getIcon(type) {
        let url;
        switch (type) {
            case 'hotel':
                url = 'https://cdn-icons-png.flaticon.com/512/2991/2991225.png'; // Ícono Hotel
                break;
            case 'transport':
                url = 'https://cdn-icons-png.flaticon.com/512/633/633632.png'; // Ícono Transporte
                break;
            default:
                url = 'https://cdn-icons-png.flaticon.com/512/684/684908.png'; // Default
        }
        return L.icon({
            iconUrl: url,
            iconSize: [25, 25],
            iconAnchor: [12, 25],
            popupAnchor: [0, -20]
        });
    }
</script>