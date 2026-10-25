import Image from "next/image";
import Link from "next/link";
import { UserRound } from "lucide-react";
import PageHeader from "@/components/PageHeader";
import CtaBanner from "@/components/CtaBanner";
import { equipo } from "@/data/site";

export const metadata = { title: "Equipo" };

export default function EquipoPage() {
  return (
    <>
      <PageHeader
        title="Nuestro equipo"
        subtitle="Profesionales comprometidos con tu recuperación."
        crumbs={[{ label: "Equipo" }]}
      />

      <section className="mx-auto grid max-w-7xl gap-8 px-4 py-20 sm:px-6 md:grid-cols-3">
        {equipo.map((p) => (
          <article key={p.slug} className="flex flex-col overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-100">
            <div className="relative grid aspect-[4/5] place-items-center bg-surface">
              {p.foto ? (
                <Image src={p.foto} alt={p.nombre} fill className="object-cover object-top" />
              ) : (
                <UserRound size={80} className="text-cepro/30" />
              )}
            </div>
            <div className="flex flex-1 flex-col p-6">
              <h2 className="font-display text-lg font-bold">{p.nombre}</h2>
              <p className="text-sm text-ink/60">{p.cargo}</p>
              <ul className="mt-4 flex flex-1 flex-wrap content-start gap-2">
                {p.especialidades.map((e) => (
                  <li key={e} className="rounded-full bg-accent/10 px-3 py-1 text-xs font-medium text-cepro">
                    {e}
                  </li>
                ))}
              </ul>
              <Link
                href={`/equipo/${p.slug}`}
                className="mt-6 rounded-full border border-cepro py-2.5 text-center font-semibold text-cepro transition hover:bg-cepro hover:text-white"
              >
                Ver perfil
              </Link>
            </div>
          </article>
        ))}
      </section>

      <CtaBanner />
    </>
  );
}
