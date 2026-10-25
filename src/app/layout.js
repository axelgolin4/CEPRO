import { Inter, Montserrat } from "next/font/google";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import FloatingButtons from "@/components/FloatingButtons";
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

export const metadata = {
  title: {
    default: "CEPRO | Fisioterapia y Rehabilitación en Quetzaltenango",
    template: "%s | CEPRO Xela",
  },
  description:
    "Centro Profesional de Rehabilitación en Occidente. Fisioterapia, rehabilitación deportiva, de rodilla y hombro, tecnología avanzada y atención en línea en Quetzaltenango, Guatemala.",
};

export default function RootLayout({ children }) {
  return (
    <html lang="es" className={`${inter.variable} ${montserrat.variable} h-full antialiased`}>
      <body className="min-h-full flex flex-col font-sans">
        <Navbar />
        <main className="flex-1">{children}</main>
        <Footer />
        <FloatingButtons />
      </body>
    </html>
  );
}
