import Link from "next/link";
import { Building2, Eye, Target, Video } from "lucide-react";
import PageHeader from "@/components/PageHeader";
import CtaBanner from "@/components/CtaBanner";
import { contacto } from "@/data/site";

export const metadata = { title: "Nosotros" };

const enfoque = ["Evaluación fisioterapéutica", "Ejercicio terapéutico dosificado", "Tecnología complementaria"];

export default function NosotrosPage() {
  return (
    <>
      <PageHeader title="Nosotros" crumbs={[{ label: "Nosotros" }]} />

      <section className="mx-auto max-w-4xl px-4 py-20 sm:px-6">
        <h2 className="font-display text-3xl font-bold text-cepro">¿Quiénes somos?</h2>
        <div className="mt-6 space-y-4 leading-relaxed text-ink/80">
          <p>
            CEPRO es un centro especializado en fisioterapia, rehabilitación física y optimización del rendimiento
            deportivo, comprometido con mejorar la calidad de vida de las personas a través de una atención
            profesional y personalizada.
          </p>
          <p>
            Trabajamos con pacientes que presentan lesiones musculoesqueléticas, dolor, limitaciones de movimiento,
            procesos de recuperación postoperatoria y necesidades de acondicionamiento físico o retorno deportivo.
          </p>
          <p>
            Creemos que la rehabilitación debe ir más allá de aliviar las molestias: buscamos recuperar capacidades
            físicas y funcionales que permitan a cada persona desenvolverse con mayor confianza e independencia.
          </p>
        </div>
      </section>

      <section className="bg-surface py-20">
        <div className="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 md:grid-cols-2">
          <article className="rounded-3xl bg-white p-8 shadow-sm">
            <Target className="text-accent" size={32} />
            <h3 className="mt-4 font-display text-2xl font-bold text-cepro">Misión</h3>
            <p className="mt-3 leading-relaxed text-ink/80">
              Brindar servicios de fisioterapia y rehabilitación integral mediante una atención profesional,
              individualizada y basada en la evaluación clínica, el ejercicio terapéutico y la aplicación de recursos
              tecnológicos complementarios, con el propósito de mejorar la movilidad, recuperar la funcionalidad y
              favorecer la reintegración de nuestros pacientes a sus actividades cotidianas, laborales y deportivas.
            </p>
          </article>
          <article className="rounded-3xl bg-white p-8 shadow-sm">
            <Eye className="text-accent" size={32} />
            <h3 className="mt-4 font-display text-2xl font-bold text-cepro">Visión</h3>
            <p className="mt-3 leading-relaxed text-ink/80">
              Ser un centro de referencia en fisioterapia, rehabilitación y optimización del rendimiento físico en el
              occidente de Guatemala, reconocido por la calidad de sus servicios, la atención personalizada, la
              innovación terapéutica y el compromiso con la recuperación funcional y el bienestar de cada paciente.
            </p>
          </article>
        </div>
      </section>

      <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
        <h2 className="text-center font-display text-3xl font-bold text-cepro">Nuestro enfoque</h2>
        <ol className="mt-12 grid gap-6 md:grid-cols-3">
          {enfoque.map((paso, i) => (
            <li key={paso} className="rounded-2xl border border-slate-100 p-6 text-center">
              <span className="font-display text-4xl font-extrabold text-accent">0{i + 1}</span>
              <p className="mt-3 font-display font-bold">{paso}</p>
            </li>
          ))}
        </ol>
      </section>

      <section className="bg-surface py-20">
        <div className="mx-auto max-w-7xl px-4 sm:px-6">
          <h2 className="font-display text-3xl font-bold text-cepro">Modalidades de atención</h2>
          <div className="mt-10 grid gap-6 md:grid-cols-2">
            <article className="rounded-3xl bg-white p-8 shadow-sm">
              <Building2 className="text-accent" size={32} />
              <h3 className="mt-4 font-display text-xl font-bold">Atención presencial en Quetzaltenango</h3>
              <p className="mt-3 leading-relaxed text-ink/80">
                Evaluación y tratamiento fisioterapéutico en nuestras instalaciones, con programas adaptados a las
                necesidades de cada paciente.
              </p>
              <a
                href={contacto.mapsUrl}
                target="_blank"
                rel="noopener noreferrer"
                className="mt-5 inline-block font-semibold text-cepro"
              >
                Cómo llegar a la clínica →
              </a>
            </article>
            <article className="rounded-3xl bg-white p-8 shadow-sm">
              <Video className="text-accent" size={32} />
              <h3 className="mt-4 font-display text-xl font-bold">Fisioterapia y orientación en línea</h3>
              <p className="mt-3 leading-relaxed text-ink/80">
                Orientación, seguimiento y ejercicios terapéuticos para realizar en casa, según tu condición y la
                pertinencia de la atención remota.
              </p>
              <Link href="/servicios/fisioterapia-en-linea" className="mt-5 inline-block font-semibold text-cepro">
                Conocer más →
              </Link>
            </article>
          </div>
        </div>
      </section>

      <section className="bg-cepro-dark py-20 text-white">
        <blockquote className="mx-auto max-w-4xl px-4 text-center font-display text-2xl font-semibold leading-snug sm:text-3xl">
          “En CEPRO creemos que recuperar el movimiento significa recuperar oportunidades para vivir mejor.”
        </blockquote>
      </section>

      <CtaBanner />
    </>
  );
}
