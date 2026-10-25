import { MapPin, MessageCircle } from "lucide-react";
import { contacto, whatsappLink } from "@/data/site";

export default function FloatingButtons() {
  return (
    <div className="fixed bottom-5 left-5 z-50 flex flex-col gap-3">
      <a
        href={whatsappLink()}
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Escríbenos por WhatsApp"
        className="grid h-13 w-13 place-items-center rounded-full bg-accent text-white shadow-lg transition hover:scale-105"
      >
        <MessageCircle size={26} />
      </a>
      <a
        href={contacto.mapsUrl}
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Ver ubicación"
        className="grid h-13 w-13 place-items-center rounded-full bg-cepro text-white shadow-lg transition hover:scale-105"
      >
        <MapPin size={24} />
      </a>
    </div>
  );
}
