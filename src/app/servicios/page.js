import { Zap } from "lucide-react";
import PageHeader from "@/components/PageHeader";
import ServiceCard from "@/components/ServiceCard";
import { servicios, tecnologias, whatsappLink } from "@/data/site";

export const metadata = { title: "Servicios" };

export default function ServiciosPage() {
  return (
    <>
      <PageHeader
        title="Nuestros servicios"
        subtitle="Tratamientos personalizados para recuperar tu movilidad, tu fuerza y tu calidad de vida."
        crumbs={[{ label: "Servicios" }]}
      />

      <section className="bg-surface py-20">
        <div className="mx-auto grid max-w-7xl gap-6 px-4 sm:grid-cols-2 sm:px-6 lg:grid-cols-3">
          {servicios.map((s, i) => (
            <ServiceCard key={s.slug} servicio={s} numero={i + 1} />
          ))}
        </div>
      </section>

      <section className="bg-cepro-dark py-20 text-white">
        <div className="mx-auto max-w-7xl px-4 sm:px-6">
          <p className="text-sm font-semibold uppercase tracking-widest text-accent">Equipamiento</p>
          <h2 className="mt-3 max-w-xl font-display text-3xl font-bold sm:text-4xl">Tecnología que complementa tu tratamiento</h2>
          <p className="mt-4 max-w-2xl text-white/70">
            Combinamos el ejercicio terapéutico y las técnicas manuales con recursos tecnológicos, que se incorporan
            a tu plan solo cuando están indicados.
          </p>
          <ul className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            {tecnologias.map((t) => (
              <li key={t.nombre} className="rounded-2xl border border-white/10 bg-white/5 p-5">
                <Zap size={22} className="text-accent" />
                <h3 className="mt-3 font-display font-bold">{t.nombre}</h3>
                <p className="mt-2 text-sm leading-relaxed text-white/65">{t.texto}</p>
              </li>
            ))}
          </ul>
        </div>
      </section>

      <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
        <div className="flex flex-col gap-8 rounded-3xl bg-gradient-to-r from-cepro to-accent p-8 text-white sm:p-12 lg:flex-row lg:items-center lg:justify-between">
          <div className="max-w-xl">
            <h2 className="font-display text-3xl font-bold">¿No estás seguro de qué tratamiento necesitas?</h2>
            <p className="mt-3 text-white/85">
              Escríbenos y nuestro equipo te orientará hacia el servicio más adecuado para tu recuperación.
            </p>
          </div>
          <a
            href={whatsappLink("Hola, no sé qué tratamiento necesito. ¿Me pueden orientar?")}
            target="_blank"
            rel="noopener noreferrer"
            className="shrink-0 rounded-full bg-white px-7 py-3.5 text-center font-semibold text-cepro transition hover:bg-surface"
          >
            Consultar por WhatsApp
          </a>
        </div>
      </section>
    </>
  );
}
