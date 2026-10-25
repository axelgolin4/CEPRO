// Logo provisional: wordmark de CEPRO con un símbolo de figura en movimiento.
export default function Logo({ light = false }) {
  const text = light ? "text-white" : "text-cepro";

  return (
    <span className="flex items-center gap-2.5">
      <svg viewBox="0 0 40 40" className="h-9 w-9 shrink-0" aria-hidden="true">
        <circle cx="20" cy="20" r="19" className="fill-accent/15" />
        <circle cx="23" cy="10" r="3.5" className="fill-accent" />
        <path
          d="M12 30c3-6 6-9 10-11l3 5 5-2M21 19l-3 13"
          className="stroke-accent"
          strokeWidth="3"
          strokeLinecap="round"
          strokeLinejoin="round"
          fill="none"
        />
      </svg>
      <span className="flex flex-col leading-none">
        <span className={`font-display text-2xl font-extrabold tracking-[0.2em] ${text}`}>CEPRO</span>
        <span className={`mt-1 text-[0.5rem] font-medium uppercase italic tracking-wide ${light ? "text-white/70" : "text-cepro/80"}`}>
          Centro Profesional de Rehabilitación en Occidente
        </span>
      </span>
    </span>
  );
}
