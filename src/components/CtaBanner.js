import { whatsappLink } from "@/data/site";

export default function CtaBanner({ mensaje }) {
  return (
    <section className="bg-gradient-to-r from-cepro to-accent">
      <div className="mx-auto flex max-w-7xl flex-col items-center gap-6 px-4 py-16 text-center sm:px-6">
        <h2 className="max-w-2xl font-display text-3xl font-bold text-white sm:text-4xl">
          Tu recuperación comienza con una evaluación profesional
        </h2>
        <a
          href={whatsappLink(mensaje)}
          target="_blank"
          rel="noopener noreferrer"
          className="rounded-full bg-white px-8 py-3.5 font-semibold text-cepro transition hover:bg-surface"
        >
          Agenda por WhatsApp
        </a>
      </div>
    </section>
  );
}
