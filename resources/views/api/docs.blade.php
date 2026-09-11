<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doña Ross - API Documentation & Sandbox</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@5.18.2/swagger-ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e11d48;
            --primary-dark: #be123c;
            --bg-body: #0f172a;
            --card-bg: #1e293b;
            --text: #f8fafc;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #1e293b;
        }

        .header-banner {
            background: linear-gradient(135deg, #be123c 0%, #e11d48 50%, #fb7185 100%);
            color: white;
            padding: 2.2rem 2rem;
            box-shadow: 0 10px 25px -5px rgba(225, 29, 72, 0.3);
        }

        .header-content {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 1.5rem;
        }

        .brand-title {
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-badge {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(8px);
            font-size: 0.85rem;
            font-weight: 700;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .header-subtitle {
            margin: 0.5rem 0 0 0;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            max-width: 650px;
            line-height: 1.5;
        }

        .quick-links {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .quick-links a {
            background: white;
            color: #be123c;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0.65rem 1.25rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quick-links a:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.15);
            background: #fff1f2;
        }

        .quick-links a.secondary {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .quick-links a.secondary:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .container-swagger {
            max-width: 1400px;
            margin: 1.5rem auto 3rem auto;
            padding: 0 1rem;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .info-item strong {
            font-size: 0.8rem;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.05em;
        }

        .info-item span, .info-item code {
            font-size: 0.95rem;
            color: #0f172a;
        }

        .info-item code {
            background: #f1f5f9;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            color: #e11d48;
            font-weight: 600;
            font-family: monospace;
            word-break: break-all;
        }

        /* Personalización sutil de Swagger UI */
        .swagger-ui .topbar { display: none !important; }
        .swagger-ui .information-container { padding: 1.5rem 0 !important; }
        .swagger-ui .info .title { font-family: 'Plus Jakarta Sans', sans-serif !important; font-weight: 800 !important; color: #0f172a !important; }
        .swagger-ui .btn.authorize {
            background-color: #e11d48 !important;
            border-color: #e11d48 !important;
            color: white !important;
            border-radius: 8px !important;
            font-weight: 700 !important;
            transition: 0.2s ease !important;
        }
        .swagger-ui .btn.authorize svg {
            fill: white !important;
        }
        .swagger-ui .btn.authorize:hover {
            background-color: #be123c !important;
        }
        .swagger-ui .opblock {
            border-radius: 10px !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
            margin-bottom: 1rem !important;
        }
    </style>
</head>
<body>

    <header class="header-banner">
        <div class="header-content">
            <div>
                <h1 class="brand-title">
                    🍰 Doña Ross
                    <span class="brand-badge">API REST v1.0</span>
                </h1>
                <p class="header-subtitle">
                    Backend de alta velocidad para la aplicación móvil Flutter. Soporta catálogo interactivo, autenticación Bearer Sanctum, compras online, mostrador de ventas y panel administrativo.
                </p>
            </div>
            <div class="quick-links">
                <a href="{{ url('/') }}" target="_blank" class="secondary">
                    🌐 Visitar Sitio Web
                </a>
                <a href="{{ url('/api/docs/openapi.json') }}" target="_blank">
                    📄 Descargar OpenAPI JSON
                </a>
            </div>
        </div>
    </header>

    <main class="container-swagger">
        <div class="info-card">
            <div class="info-item">
                <strong>Base URL de la API:</strong>
                <code>{{ url('/api') }}</code>
            </div>
            <div class="info-item">
                <strong>Autenticación en Flutter:</strong>
                <span>Header <code>Authorization: Bearer {token}</code></span>
            </div>
            <div class="info-item">
                <strong>Header Requerido:</strong>
                <code>Accept: application/json</code>
            </div>
            <div class="info-item">
                <strong>Modo de prueba interactiva:</strong>
                <span>Haz clic en "Authorize", pega tu token y prueba cualquier endpoint directamente.</span>
            </div>
        </div>

        <div id="swagger-ui"></div>
    </main>

    <script src="https://unpkg.com/swagger-ui-dist@5.18.2/swagger-ui-bundle.js" crossorigin></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.18.2/swagger-ui-standalone-preset.js" crossorigin></script>
    <script>
        window.onload = () => {
            window.ui = SwaggerUIBundle({
                url: '{{ url("/api/docs/openapi.json") }}',
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "BaseLayout",
                persistAuthorization: true,
                displayRequestDuration: true,
                docExpansion: "list",
                filter: true,
                defaultModelsExpandDepth: 2,
                defaultModelExpandDepth: 2,
            });
        };
    </script>
</body>
</html>
