import { MessageCircle, Phone } from "lucide-react";
import { contacto, telLink, whatsappLink } from "@/data/site";

export default function CtaBanner({ mensaje }) {
  const boton =
    "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-full bg-white px-7 py-3.5 font-semibold text-cepro transition hover:bg-surface active:scale-[0.97]";

  return (
    <section className="bg-gradient-to-r from-cepro to-accent">
      <div className="mx-auto flex max-w-7xl flex-col items-center gap-6 px-4 py-16 text-center sm:px-6">
        <h2 className="max-w-2xl font-display text-3xl font-bold text-white sm:text-4xl">
          Tu recuperación comienza con una evaluación profesional
        </h2>
        <div className="grid w-full max-w-md grid-cols-2 gap-3 sm:w-auto sm:max-w-none">
          <a href={whatsappLink(mensaje)} target="_blank" rel="noopener noreferrer" className={boton}>
            <MessageCircle size={20} /> WhatsApp
          </a>
          <a href={telLink()} className={boton}>
            <Phone size={19} /> Llamar <span className="hidden sm:inline">{contacto.telefonos[0]}</span>
          </a>
        </div>
      </div>
    </section>
  );
}
