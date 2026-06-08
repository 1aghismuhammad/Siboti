<!DOCTYPE html>
<html lang="id" itemscope itemtype="https://schema.org/LocalBusiness">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Siboti - Gym Premium Semarang | Booking Online</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="description" content="Siboti adalah gym premium di Semarang dengan trainer bersertifikat, peralatan modern, dan fasilitas lengkap.">
    <meta name="keywords" content="gym semarang, fitness semarang, personal trainer semarang, membership gym, booking gym online, siboti gym">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://siboti.id/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Siboti - Gym Premium Semarang">
    <meta property="og:description" content="Latihan profesional, peralatan modern, dan suasana premium dalam satu tempat.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=1200&q=80">
    <meta property="og:locale" content="id_ID">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Siboti - Gym Premium Semarang">
    <meta name="twitter:description" content="Latihan profesional, peralatan modern, dan suasana premium dalam satu tempat.">
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "HealthClub",
        "name": "Siboti Gym Semarang",
        "description": "Gym premium di Semarang dengan trainer bersertifikat dan peralatan modern.",
        "url": "https://siboti.id",
        "telephone": "+628893282932",
        "email": "rafakurnia@gmail.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Jl. Sudirman No. 10",
            "addressLocality": "Semarang",
            "addressRegion": "Jawa Tengah",
            "addressCountry": "ID"
        },
        "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            "opens": "06:00",
            "closes": "23:00"
        }
    }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}?v=1.0">
    <link rel="stylesheet" href="{{ asset('css/account.css') }}?v=1.0">
</head>
<body>
    @include('components.navbar')

    @isset($header)
        <header class="page-header">
            {{ $header }}
        </header>
    @endisset

    <main id="main-content">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    @include('components.footer')
</body>
</html>
