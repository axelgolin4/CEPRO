import { Inter, Montserrat } from "next/font/google";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import FloatingButtons from "@/components/FloatingButtons";
import { contacto, siteUrl } from "@/data/site";
import "./globals.css";

const inter = Inter({
  variable: "--font-inter",
  subsets: ["latin"],
});

const montserrat = Montserrat({
  variable: "--font-montserrat",
  subsets: ["latin"],
  weight: ["600", "700", "800"],
});

const description =
  "Centro Profesional de Rehabilitación en Occidente. Fisioterapia, rehabilitación deportiva, de rodilla y hombro, tecnología avanzada y atención en línea en Quetzaltenango, Guatemala.";

export const metadata = {
  metadataBase: new URL(siteUrl),
  title: {
    default: "CEPRO | Fisioterapia y Rehabilitación en Quetzaltenango",
    template: "%s | CEPRO Xela",
  },
  description,
  keywords: [
    "fisioterapia Quetzaltenango",
    "fisioterapia Xela",
    "rehabilitación Quetzaltenango",
    "fisioterapeuta Xela",
    "rehabilitación deportiva",
    "ondas de choque",
    "CEPRO",
  ],
  alternates: { canonical: "./" },
  openGraph: {
    type: "website",
    locale: "es_GT",
    siteName: "CEPRO Xela",
    url: "./",
    description,
  },
  twitter: { card: "summary_large_image" },
};

// Datos estructurados para que Google entienda que es una clínica local.
const clinicaJsonLd = {
  "@context": "https://schema.org",
  "@type": "Physiotherapy",
  name: contacto.nombre,
  url: siteUrl,
  image: `${siteUrl}/opengraph-image.jpg`,
  logo: `${siteUrl}/icon.png`,
  description,
  telephone: contacto.telefonos.map((t) => `+502 ${t}`),
  email: contacto.correo,
  address: {
    "@type": "PostalAddress",
    streetAddress: "Calle A 23-70, Zona 1, Edificio Andaga, Clínica 104",
    addressLocality: "Quetzaltenango",
    addressCountry: "GT",
  },
  geo: { "@type": "GeoCoordinates", latitude: 14.8409719, longitude: -91.5278376 },
  hasMap: contacto.mapsUrl,
  openingHoursSpecification: [
    {
      "@type": "OpeningHoursSpecification",
      dayOfWeek: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
      opens: "09:00",
      closes: "18:00",
    },
    { "@type": "OpeningHoursSpecification", dayOfWeek: "Saturday", opens: "08:00", closes: "14:00" },
  ],
};

export default function RootLayout({ children }) {
  return (
    <html lang="es" className={`${inter.variable} ${montserrat.variable} h-full antialiased`}>
      <body className="min-h-full flex flex-col font-sans">
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(clinicaJsonLd) }}
        />
        <Navbar />
        <main className="flex-1">{children}</main>
        <Footer />
        <FloatingButtons />
      </body>
    </html>
  );
}
