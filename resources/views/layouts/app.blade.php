<!DOCTYPE html>
<html lang="id" itemscope itemtype="https://schema.org/LocalBusiness">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Primary --}}
    <title>GETZO. Gym Premium Semarang | Booking Online</title>
    <meta name="description" content="GETZO adalah gym premium di Semarang dengan trainer bersertifikat, peralatan modern, dan fasilitas lengkap. Booking sesi online mudah & cepat. Mulai dari Rp499.000/bulan.">
    <meta name="keywords" content="gym semarang, fitness semarang, personal trainer semarang, membership gym semarang, booking gym online, getzo gym">
    <meta name="author" content="GETZO Gym Semarang">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://getzo.id/">

    {{-- Open Graph (Facebook, WhatsApp, LinkedIn) --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://getzo.id/">
    <meta property="og:title" content="GETZO. Gym Premium Semarang">
    <meta property="og:description" content="Latihan profesional, peralatan modern, dan suasana premium dalam satu tempat di Semarang.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200&q=80">
    <meta property="og:locale" content="id_ID">
    <meta property="og:site_name" content="GETZO Gym">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="GETZO. Gym Premium Semarang">
    <meta name="twitter:description" content="Latihan profesional, peralatan modern, dan suasana premium dalam satu tempat.">
    <meta name="twitter:image" content="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200&q=80">

    {{-- Structured Data: LocalBusiness --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HealthClub",
        "name": "GETZO Gym Semarang",
        "description": "Gym premium di Semarang dengan trainer bersertifikat dan peralatan modern.",
        "url": "https://getzo.id",
        "telephone": "+628130000000",
        "email": "hello@getzo.id",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Jl. Sudirman No. 10",
            "addressLocality": "Semarang",
            "addressRegion": "Jawa Tengah",
            "postalCode": "50134",
            "addressCountry": "ID"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": -6.9930,
            "longitude": 110.4203
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            "opens": "06:00",
            "closes": "23:00"
        },
        "priceRange": "Rp499.000 - Rp1.499.000",
        "image": "https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200&q=80"
    }
    </script>

    {{-- Tailwind CDN (ganti dengan Vite saat production) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { neon: '#CCFF00' },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        html { scroll-behavior: smooth; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #CCFF00; border-radius: 2px; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-white font-sans">

    @include('components.navbar')

    <main id="main-content">
        @yield('content')
    </main>

    @include('components.footer')

</body>
</html>
