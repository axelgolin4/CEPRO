# CEPRO – Sitio web

Sitio web de **CEPRO – Centro Profesional de Rehabilitación en Occidente**, centro de fisioterapia en Quetzaltenango, Guatemala.

Sitio de varias páginas, generado de forma estática, sin backend ni base de datos: todo el contenido vive en un archivo de datos y los contactos se canalizan por WhatsApp.

## Stack

| Tecnología | Versión | Uso |
| --- | --- | --- |
| [Next.js](https://nextjs.org) (App Router) | 16.4 | Framework, rutas y generación estática |
| React | 19.3 | UI |
| Tailwind CSS | 4 | Estilos (configuración CSS-first, sin `tailwind.config`) |
| [lucide-react](https://lucide.dev) | — | Íconos |
| `next/font` | — | Montserrat (títulos) e Inter (texto), autoalojadas |
| `next/image` | — | Optimización y tamaños responsivos de las fotos |
| ESLint | 9 | `eslint-config-next` |

El proyecto está en **JavaScript** (sin TypeScript). El alias `@/*` apunta a `src/*` (ver `jsconfig.json`).

## Requisitos

- Node.js 20.9 o superior (probado con 22.14)
- npm

## Scripts

```bash
npm install       # instalar dependencias
npm run dev       # servidor de desarrollo en http://localhost:3000
npm run build     # build de producción (prerenderiza todas las páginas)
npm run start     # servir el build de producción
npm run lint      # ESLint
```

## Estructura

```
src/
├── app/
│   ├── layout.js               # Layout raíz: fuentes, metadata, Navbar, Footer, botones flotantes
│   ├── globals.css             # Tailwind + tokens de color y fuentes (@theme)
│   ├── icon.png                # Favicon (logo CEPRO, 512×512)
│   ├── apple-icon.png          # Ícono para iOS (180×180)
│   ├── page.js                 # Inicio
│   ├── nosotros/page.js
│   ├── servicios/
│   │   ├── page.js             # Listado de servicios y tecnologías
│   │   └── [slug]/page.js      # Detalle de cada servicio (10 rutas estáticas)
│   ├── equipo/
│   │   ├── page.js             # Listado del equipo
│   │   └── [slug]/page.js      # Perfil de cada especialista (3 rutas estáticas)
│   ├── galeria/page.js
│   └── contacto/page.js
├── components/
│   ├── Navbar.js               # Cliente: menú móvil, dropdown de servicios, enlace activo
│   ├── Footer.js
│   ├── FloatingButtons.js      # WhatsApp y ubicación fijos en pantalla
│   ├── Logo.js                 # Logo provisional en SVG (prop `light` para fondos oscuros)
│   ├── PageHeader.js           # Encabezado de página con breadcrumb
│   ├── ServiceCard.js          # Tarjeta de servicio + mapa de íconos por slug
│   ├── CtaBanner.js            # Banda "Agenda por WhatsApp"
│   ├── ContactForm.js          # Cliente: arma un mensaje y lo abre en WhatsApp
│   └── Gallery.js              # Cliente: filtros por categoría y visor (lightbox)
└── data/
    └── site.js                 # Todo el contenido del sitio
public/
└── fotos/
    ├── equipo/                 # Retratos editados del equipo (800×1000, mismo fondo)
    └── *.jpg                   # Fotos originales de la clínica
```

## Contenido: `src/data/site.js`

Todo el texto editable está centralizado aquí; las páginas solo lo leen.

| Export | Contenido |
| --- | --- |
| `contacto` | Dirección, teléfonos, número de WhatsApp (`502` + número, sin guiones), correo, horario, enlace y embed de Google Maps |
| `whatsappLink(mensaje)` | Construye un enlace `wa.me` con un mensaje prellenado |
| `navLinks` | Enlaces del menú y del footer |
| `servicios` | Los 10 servicios: `slug`, `titulo`, `resumen`, `descripcion`, `dirigidoA` y `especialista` opcional (slug de un miembro del equipo) |
| `tecnologias` | Las 5 tecnologías con su descripción |
| `pasos` | Los 4 pasos de "¿Cómo trabajamos?" |
| `beneficios` | "¿Por qué elegir CEPRO?" |
| `equipo` | Perfiles: `slug`, `nombre`, `cargo`, `foto`, `especialidades`, `formacion`, `experiencia`, `objetivo` |
| `galeria` | Fotos de la galería: `src`, `alt`, `categoria` (`Instalaciones`, `Tratamientos` o `Tecnología`) |

### Tareas comunes

- **Agregar un servicio:** añadir un objeto a `servicios` con un `slug` único. La ruta `/servicios/<slug>` se genera sola. Para darle ícono propio, agregar el slug al mapa `iconos` en `ServiceCard.js` (si no, usa `Activity`).
- **Agregar un miembro del equipo:** añadir un objeto a `equipo` y su retrato en `public/fotos/equipo/`. La ruta `/equipo/<slug>` se genera sola.
- **Agregar fotos a la galería:** copiar la imagen en `public/fotos/` y añadir una entrada a `galeria`. Las primeras 5 aparecen en el mosaico de Inicio.
- **Cambiar el WhatsApp:** editar `contacto.whatsapp`. Todos los botones y el formulario lo usan.

## Rutas y renderizado

Todas las páginas se prerenderizan en el build. Las rutas dinámicas usan `generateStaticParams` a partir de `servicios` y `equipo`, y `generateMetadata` para el `<title>` de cada página.

En Next.js 16, `params` es una **Promise**: en las páginas dinámicas se lee con `const { slug } = await params`. Un slug inexistente llama a `notFound()`.

> Evitar valores que cambian en cada render (por ejemplo `new Date()`) en componentes del servidor: Next 16 rompe el prerender. Por eso el año del footer está escrito a mano.

Los componentes marcados con `"use client"` son solo los que necesitan estado o eventos del navegador: `Navbar`, `ContactForm` y `Gallery`.

## Estilos

Los tokens de diseño están en `src/app/globals.css` dentro de `@theme`, y generan clases de Tailwind como `bg-cepro`, `text-accent` o `font-display`:

| Token | Color | Uso |
| --- | --- | --- |
| `cepro` | `#0B4DA8` | Azul del logo: títulos y botones principales |
| `cepro-dark` | `#0A1F44` | Hero, bandas oscuras y footer |
| `accent` | `#14B8A6` | Turquesa: íconos, detalles, WhatsApp |
| `surface` | `#F4F7FB` | Fondos de secciones alternas |
| `ink` | `#1E293B` | Texto |

Fuentes: `font-display` (Montserrat) para títulos y `font-sans` (Inter) por defecto.

## Imágenes

- Se sirven desde `public/` y se renderizan con `next/image` (`fill` + `object-cover` y `sizes` en la galería).
- Los retratos de `public/fotos/equipo/` se editaron para que los tres tengan el mismo tamaño (800×1000, proporción 4:5), el mismo encuadre y el mismo fondo degradado beige claro (`#F5F0E8` → `#E4DACB`). El fondo original se quitó con [`@imgly/background-removal-node`](https://www.npmjs.com/package/@imgly/background-removal-node) y la composición se hizo con `sharp`. Para un nuevo integrante conviene repetir el mismo proceso, para que todos los retratos se vean iguales.
- Las fotos originales del equipo se conservan en `public/fotos/`.

## Despliegue

Pensado para [Vercel](https://vercel.com):

1. Importar el repositorio `axelgolin4/CEPRO` en Vercel (detecta Next.js automáticamente).
2. Deploy. No hace falta configurar variables de entorno.
3. Cada `git push` a `master` publica una nueva versión.

## Pendientes

- Reemplazar el logo provisional (`Logo.js`) cuando exista la versión final.
- Cualquier cifra (años de experiencia, pacientes atendidos, etc.) debe confirmarse con la clínica antes de publicarse.
