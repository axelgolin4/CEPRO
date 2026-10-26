import Image from "next/image";
import Link from "next/link";
import { ArrowRight, CheckCircle2, Cpu, HeartHandshake, MonitorSmartphone } from "lucide-react";
import CtaBanner from "@/components/CtaBanner";
import ServiceCard from "@/components/ServiceCard";
import { beneficios, equipo, galeria, servicios, whatsappLink } from "@/data/site";

const confianza = [
  { icon: HeartHandshake, label: "Atención personalizada", texto: "Un plan adaptado a tu condición, tu ritmo y tus objetivos." },
  { icon: Cpu, label: "Tecnología avanzada", texto: "Ondas de choque, láser, radiofrecuencia y más, cuando están indicados." },
  { icon: MonitorSmartphone, label: "Presencial y en línea", texto: "En nuestra clínica en Xela o con seguimiento desde casa." },
];

export default function Home() {
  return (
    <>
      <section className="relative isolate overflow-hidden bg-cepro-dark text-white">
        <Image
          src="/fotos/cc652f64-0e9d-41cb-b04e-677f2f2fb7d9.jpg"
          alt="Fisioterapeuta tratando a una paciente en CEPRO"
          fill
          priority
          className="-z-10 object-cover opacity-35"
        />
        <div className="absolute inset-0 -z-10 bg-gradient-to-r from-cepro-dark via-cepro-dark/80 to-transparent" />
        <div className="mx-auto max-w-7xl px-4 py-24 sm:px-6 sm:py-32">
          <p className="text-sm font-semibold uppercase tracking-[0.25em] text-accent">
            Fisioterapia en Quetzaltenango
          </p>
          <h1 className="mt-4 font-display text-6xl font-extrabold tracking-[0.15em] sm:text-8xl">CEPRO</h1>
          <p className="mt-6 max-w-xl text-lg text-white/85 sm:text-xl">
            Recuperar el movimiento es recuperar oportunidades para vivir mejor.
          </p>
          <div className="mt-8 flex flex-wrap gap-4">
            <a
              href={whatsappLink()}
              target="_blank"
              rel="noopener noreferrer"
              className="rounded-full bg-accent px-7 py-3.5 font-semibold text-white transition hover:brightness-110"
            >
              Agendar evaluación
            </a>
            <Link
              href="/servicios"
              className="rounded-full border border-white/40 px-7 py-3.5 font-semibold transition hover:bg-white/10"
            >
              Ver servicios
            </Link>
          </div>
          <div className="mt-14 grid gap-4 sm:grid-cols-3">
            {confianza.map(({ icon: Icon, label, texto }) => (
              <div key={label} className="rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                <div className="flex items-center gap-3">
                  <Icon className="text-accent" />
                  <span className="font-semibold">{label}</span>
                </div>
                <p className="mt-2 text-sm text-white/70">{texto}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="mx-auto grid max-w-7xl items-center gap-12 px-4 py-20 sm:px-6 md:grid-cols-2">
        <div>
          <p className="font-semibold uppercase tracking-widest text-accent">¿Quiénes somos?</p>
          <h2 className="mt-3 font-display text-3xl font-bold text-cepro sm:text-4xl">
            Rehabilitación que va más allá de aliviar molestias
          </h2>
          <p className="mt-5 leading-relaxed text-ink/80">
            Somos un centro especializado en fisioterapia, rehabilitación física y optimización del rendimiento
            deportivo. Integramos evaluación fisioterapéutica, ejercicio terapéutico dosificado y tecnologías
            complementarias para que recuperes tu movilidad con confianza e independencia.
          </p>
          <Link href="/nosotros" className="mt-6 inline-flex items-center gap-2 font-semibold text-cepro hover:gap-3 transition-all">
            Conoce más <ArrowRight size={18} />
          </Link>
        </div>
        <div className="relative aspect-[4/3] overflow-hidden rounded-3xl shadow-xl">
          <Image
            src="/fotos/f02a0538-3ec0-442d-abc3-14c06d0431b0.jpg"
            alt="Instalaciones de CEPRO"
            fill
            className="object-cover"
          />
        </div>
      </section>

      <section className="bg-surface py-20">
        <div className="mx-auto max-w-7xl px-4 sm:px-6">
          <div className="flex flex-wrap items-end justify-between gap-4">
            <h2 className="font-display text-3xl font-bold text-cepro sm:text-4xl">Nuestros servicios</h2>
            <Link href="/servicios" className="inline-flex items-center gap-2 font-semibold text-cepro">
              Ver todos los servicios <ArrowRight size={18} />
            </Link>
          </div>
          <div className="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {servicios.slice(0, 6).map((s, i) => (
              <ServiceCard key={s.slug} servicio={s} numero={i + 1} />
            ))}
          </div>
        </div>
      </section>

      <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
        <h2 className="text-center font-display text-3xl font-bold text-cepro sm:text-4xl">¿Por qué elegir CEPRO?</h2>
        <div className="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
          {beneficios.map((b) => (
            <div key={b.titulo} className="flex gap-4">
              <CheckCircle2 className="mt-1 shrink-0 text-accent" />
              <div>
                <h3 className="font-display font-bold text-ink">{b.titulo}</h3>
                <p className="mt-1 text-sm leading-relaxed text-ink/70">{b.texto}</p>
              </div>
            </div>
          ))}
        </div>
      </section>

      <section className="bg-surface py-20">
        <div className="mx-auto max-w-7xl px-4 text-center sm:px-6">
          <h2 className="font-display text-3xl font-bold text-cepro sm:text-4xl">Nuestro equipo</h2>
          <p className="mx-auto mt-3 max-w-xl text-ink/70">
            Atención humana guiada por fisioterapeutas con formación y experiencia en rehabilitación.
          </p>
          <div className="mt-12 grid gap-6 md:grid-cols-3">
            {equipo.map((p) => (
              <Link
                key={p.slug}
                href={`/equipo/${p.slug}`}
                className="group flex flex-col rounded-3xl bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
              >
                <div className="relative mx-auto h-36 w-36 overflow-hidden rounded-full bg-cepro/10 ring-4 ring-cepro/15 ring-offset-4 transition group-hover:ring-cepro/40">
                  {p.foto && <Image src={p.foto} alt={p.nombre} fill className="object-cover object-top" />}
                </div>
                <p className="mt-5 font-display font-bold group-hover:text-cepro">{p.nombre}</p>
                <p className="mt-1 text-xs font-semibold uppercase tracking-wider text-cepro">{p.cargo}</p>
                <p className="mt-3 flex-1 text-sm text-ink/70">{p.especialidades.slice(0, 2).join(" · ")}</p>
                <span className="mt-5 inline-block text-sm font-semibold text-cepro">Ver perfil →</span>
              </Link>
            ))}
          </div>
          <Link href="/equipo" className="mt-10 inline-flex items-center gap-2 font-semibold text-cepro">
            Conoce al equipo <ArrowRight size={18} />
          </Link>
        </div>
      </section>

      <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
        <div className="flex flex-wrap items-end justify-between gap-4">
          <div>
            <p className="font-semibold uppercase tracking-widest text-accent">Galería</p>
            <h2 className="mt-3 font-display text-3xl font-bold text-cepro sm:text-4xl">Así trabajamos en CEPRO</h2>
          </div>
          <Link href="/galeria" className="inline-flex items-center gap-2 font-semibold text-cepro">
            Ver galería completa <ArrowRight size={18} />
          </Link>
        </div>
        <div className="mt-10 grid grid-cols-2 gap-4 md:grid-cols-4 md:grid-rows-2">
          {galeria.slice(0, 5).map((foto, i) => (
            <Link
              key={foto.src}
              href="/galeria"
              className={`group relative overflow-hidden rounded-2xl bg-surface ${
                i === 0 ? "col-span-2 aspect-[4/3] md:row-span-2 md:aspect-auto" : "aspect-square"
              }`}
            >
              <Image
                src={foto.src}
                alt={foto.alt}
                fill
                sizes={i === 0 ? "(min-width: 768px) 50vw, 100vw" : "(min-width: 768px) 25vw, 50vw"}
                className="object-cover transition duration-500 group-hover:scale-105"
              />
            </Link>
          ))}
        </div>
      </section>

      <CtaBanner />
    </>
  );
}
