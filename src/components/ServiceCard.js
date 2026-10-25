import Link from "next/link";
import {
  Activity,
  ArrowRight,
  Bone,
  Dumbbell,
  Footprints,
  Hand,
  HeartPulse,
  MonitorSmartphone,
  Move,
  Trophy,
  Waves,
  Zap,
} from "lucide-react";

export const iconos = {
  "fisioterapia-musculoesqueletica": Bone,
  "rehabilitacion-deportiva": Trophy,
  "rehabilitacion-de-rodilla": Footprints,
  "tecnologia-avanzada": Zap,
  "rehabilitacion-de-hombro": Move,
  "ejercicio-terapeutico": Dumbbell,
  "descargas-musculares": Waves,
  "rehabilitacion-postoperatoria": HeartPulse,
  "masajes-de-espalda": Hand,
  "fisioterapia-en-linea": MonitorSmartphone,
};

export default function ServiceCard({ servicio, numero }) {
  const Icon = iconos[servicio.slug] ?? Activity;

  return (
    <Link
      href={`/servicios/${servicio.slug}`}
      className="group relative flex flex-col overflow-hidden rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-100 transition hover:-translate-y-1 hover:shadow-lg"
    >
      {numero && (
        <span className="absolute -right-4 -top-4 grid h-20 w-20 place-items-end rounded-full bg-surface p-5 text-xs font-semibold text-ink/40">
          {String(numero).padStart(2, "0")}
        </span>
      )}
      <span className="grid h-12 w-12 place-items-center rounded-xl bg-accent/10 text-accent transition group-hover:bg-accent group-hover:text-white">
        <Icon />
      </span>
      <h3 className="mt-5 font-display text-lg font-bold text-ink group-hover:text-cepro">{servicio.titulo}</h3>
      <p className="mt-2 flex-1 text-sm leading-relaxed text-ink/70">{servicio.resumen}</p>
      <span className="mt-4 inline-flex items-center gap-1 text-sm font-semibold text-cepro">
        Ver más <ArrowRight size={16} className="transition group-hover:translate-x-1" />
      </span>
    </Link>
  );
}
