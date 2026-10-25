import Link from "next/link";

export default function PageHeader({ title, subtitle, crumbs = [] }) {
  return (
    <section className="bg-gradient-to-br from-cepro-dark to-cepro py-16 text-white sm:py-20">
      <div className="mx-auto max-w-7xl px-4 sm:px-6">
        <nav className="text-sm text-white/60">
          <Link href="/" className="hover:text-white">
            Inicio
          </Link>
          {crumbs.map((c) => (
            <span key={c.label}>
              {" / "}
              {c.href ? (
                <Link href={c.href} className="hover:text-white">
                  {c.label}
                </Link>
              ) : (
                <span className="text-white">{c.label}</span>
              )}
            </span>
          ))}
        </nav>
        <h1 className="mt-4 font-display text-4xl font-extrabold sm:text-5xl">{title}</h1>
        {subtitle && <p className="mt-4 max-w-2xl text-lg text-white/80">{subtitle}</p>}
      </div>
    </section>
  );
}
