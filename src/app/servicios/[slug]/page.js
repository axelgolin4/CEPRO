import Image from "next/image";
import Link from "next/link";
import { notFound } from "next/navigation";
import { CheckCircle2, Phone } from "lucide-react";
import PageHeader from "@/components/PageHeader";
import ServiceCard from "@/components/ServiceCard";
import { contacto, equipo, pasos, servicios, whatsappLink } from "@/data/site";

export function generateStaticParams() {
  return servicios.map((s) => ({ slug: s.slug }));
}

export async function generateMetadata({ params }) {
  const { slug } = await params;
  const servicio = servicios.find((s) => s.slug === slug);
  return { title: servicio?.titulo ?? "Servicio" };
}

export default async function ServicioPage({ params }) {
  const { slug } = await params;
  const servicio = servicios.find((s) => s.slug === slug);
  if (!servicio) notFound();

  const otros = servicios.filter((s) => s.slug !== slug).slice(0, 3);
  const especialista = equipo.find((p) => p.slug === servicio.especialista);

  return (
    <>
      <PageHeader
        title={servicio.titulo}
        crumbs={[{ label: "Servicios", href: "/servicios" }, { label: servicio.titulo }]}
      />

      <section className="mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-3">
        <div className="lg:col-span-2">
          <p className="text-lg leading-relaxed text-ink/80">{servicio.descripcion}</p>
          <h2 className="mt-10 font-display text-2xl font-bold text-cepro">¿A quién va dirigido?</h2>
          <ul className="mt-5 grid gap-3 sm:grid-cols-2">
            {servicio.dirigidoA.map((item) => (
              <li key={item} className="flex items-center gap-3 rounded-xl bg-surface p-4">
                <CheckCircle2 className="shrink-0 text-accent" size={20} /> {item}
              </li>
            ))}
          </ul>
        </div>

        <aside className="h-fit rounded-3xl bg-cepro-dark p-8 text-white lg:sticky lg:top-24">
          <h3 className="font-display text-xl font-bold">Agenda tu evaluación</h3>
          <p className="mt-2 text-sm text-white/70">{contacto.nota}</p>
          <ul className="mt-5 space-y-2">
            {contacto.telefonos.map((t) => (
              <li key={t} className="flex items-center gap-2">
                <Phone size={16} className="text-accent" /> {t}
              </li>
            ))}
          </ul>
          <a
            href={whatsappLink(`Hola, me interesa el servicio de ${servicio.titulo}.`)}
            target="_blank"
            rel="noopener noreferrer"
            className="mt-6 block rounded-full bg-accent py-3 text-center font-semibold"
          >
            Escribir por WhatsApp
          </a>
        </aside>
      </section>

      <section className="bg-surface py-20">
        <div className="mx-auto max-w-7xl px-4 sm:px-6">
          <h2 className="text-center font-display text-3xl font-bold text-cepro">¿Cómo trabajamos?</h2>
          <ol className="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            {pasos.map((paso, i) => (
              <li key={paso.titulo} className="rounded-2xl bg-white p-6 shadow-sm">
                <span className="font-display text-3xl font-extrabold text-accent">0{i + 1}</span>
                <h3 className="mt-3 font-display font-bold">{paso.titulo}</h3>
                <p className="mt-2 text-sm leading-relaxed text-ink/70">{paso.texto}</p>
              </li>
            ))}
          </ol>
        </div>
      </section>

      {especialista && (
        <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
          <div className="flex flex-col items-center gap-8 rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-100 sm:flex-row">
            <div className="relative h-36 w-36 shrink-0 overflow-hidden rounded-full bg-surface">
              <Image src={especialista.foto} alt={especialista.nombre} fill className={`object-cover ${especialista.fotoPos ?? "object-top"}`} />
            </div>
            <div className="text-center sm:text-left">
              <p className="text-sm font-semibold uppercase tracking-widest text-accent">Especialista a cargo</p>
              <h2 className="mt-2 font-display text-2xl font-bold">{especialista.nombre}</h2>
              <p className="text-ink/60">{especialista.cargo}</p>
              <Link
                href={`/equipo/${especialista.slug}`}
                className="mt-4 inline-block rounded-full bg-cepro px-6 py-2.5 font-semibold text-white transition hover:bg-cepro-dark"
              >
                Ver perfil completo
              </Link>
            </div>
          </div>
        </section>
      )}

      <section className="bg-surface py-20">
        <div className="mx-auto max-w-7xl px-4 sm:px-6">
          <h2 className="font-display text-2xl font-bold text-cepro">Otros servicios</h2>
          <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {otros.map((s) => (
              <ServiceCard key={s.slug} servicio={s} />
            ))}
          </div>
        </div>
      </section>
    </>
  );
}
