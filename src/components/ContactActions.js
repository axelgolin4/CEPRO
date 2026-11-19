import { MessageCircle, Phone } from "lucide-react";
import { contacto, telLink, whatsappLink } from "@/data/site";

// WhatsApp y llamada con el mismo peso: son las dos formas reales de agendar.
// `dark` es para fondos oscuros, donde el botón de llamar va en blanco.
export default function ContactActions({ mensaje, dark = false, compact = false, className = "" }) {
  const base =
    "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-full px-6 py-3.5 font-semibold transition hover:brightness-110 active:scale-[0.97]";

  return (
    <div className={`grid grid-cols-2 gap-3 sm:inline-grid sm:auto-cols-fr sm:grid-flow-col ${className}`}>
      <a
        href={whatsappLink(mensaje)}
        target="_blank"
        rel="noopener noreferrer"
        className={`${base} bg-accent text-white`}
      >
        <MessageCircle size={20} />
        WhatsApp
      </a>
      <a href={telLink()} className={`${base} ${dark ? "bg-white text-cepro" : "bg-cepro text-white"}`}>
        <Phone size={19} />
        <span>
          Llamar {!compact && <span className="hidden sm:inline">{contacto.telefonos[0]}</span>}
        </span>
      </a>
    </div>
  );
}
