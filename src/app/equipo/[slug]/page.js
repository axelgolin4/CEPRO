import Image from "next/image";
import { notFound } from "next/navigation";
import { Briefcase, GraduationCap, UserRound } from "lucide-react";
import PageHeader from "@/components/PageHeader";
import { equipo, whatsappLink } from "@/data/site";

export function generateStaticParams() {
  return equipo.map((p) => ({ slug: p.slug }));
}

export async function generateMetadata({ params }) {
  const { slug } = await params;
  const persona = equipo.find((p) => p.slug === slug);
  return { title: persona?.nombre ?? "Equipo" };
}

export default async function PerfilPage({ params }) {
  const { slug } = await params;
  const persona = equipo.find((p) => p.slug === slug);
  if (!persona) notFound();

  const primerNombre = persona.nombre.replace(/^Licda?\.\s/, "").split(" ")[0];

  return (
    <>
      <PageHeader
        title={persona.nombre}
        subtitle={persona.cargo}
        crumbs={[{ label: "Equipo", href: "/equipo" }, { label: persona.nombre }]}
      />

      <section className="mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 md:grid-cols-5">
        <div className="relative grid aspect-[4/5] place-items-center overflow-hidden rounded-3xl bg-surface md:col-span-2">
          {persona.foto ? (
            <Image src={persona.foto} alt={persona.nombre} fill className={`object-cover ${persona.fotoPos ?? "object-top"}`} />
          ) : (
            <UserRound size={100} className="text-cepro/30" />
          )}
        </div>

        <div className="space-y-10 md:col-span-3">
          <div>
            <h2 className="flex items-center gap-2 font-display text-xl font-bold text-cepro">
              <GraduationCap className="text-accent" /> Formación académica
            </h2>
            <ul className="mt-4 space-y-2 text-ink/80">
              {persona.formacion.map((f) => (
                <li key={f}>• {f}</li>
              ))}
            </ul>
          </div>

          <div>
            <h2 className="flex items-center gap-2 font-display text-xl font-bold text-cepro">
              <Briefcase className="text-accent" /> Experiencia
            </h2>
            <ul className="mt-4 space-y-2 border-l-2 border-accent/30 pl-5 text-ink/80">
              {persona.experiencia.map((e) => (
                <li key={e}>{e}</li>
              ))}
            </ul>
          </div>

          <div>
            <h2 className="font-display text-xl font-bold text-cepro">Áreas de especialización</h2>
            <ul className="mt-4 flex flex-wrap gap-2">
              {persona.especialidades.map((e) => (
                <li key={e} className="rounded-full bg-accent/10 px-4 py-1.5 text-sm font-medium text-cepro">
                  {e}
                </li>
              ))}
            </ul>
          </div>

          <blockquote className="rounded-3xl bg-cepro-dark p-8 text-white">
            <p className="text-sm font-semibold uppercase tracking-widest text-accent">Mi objetivo en CEPRO</p>
            <p className="mt-3 leading-relaxed text-white/85">{persona.objetivo}</p>
          </blockquote>

          <a
            href={whatsappLink(`Hola, quiero agendar una cita con ${primerNombre}.`)}
            target="_blank"
            rel="noopener noreferrer"
            className="inline-block rounded-full bg-cepro px-7 py-3.5 font-semibold text-white transition hover:bg-cepro-dark"
          >
            Agendar cita con {primerNombre}
          </a>
        </div>
      </section>
    </>
  );
}
