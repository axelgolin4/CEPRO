import Link from "next/link";
import { Clock, Mail, MapPin, Phone } from "lucide-react";
import Logo from "./Logo";
import { contacto, navLinks, servicios } from "@/data/site";

export default function Footer() {
  return (
    <footer className="bg-cepro-dark text-white/80">
      <div className="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-2 lg:grid-cols-4">
        <div>
          <Logo light />
          <p className="mt-5 max-w-sm text-sm leading-relaxed">
            Recuperar el movimiento significa recuperar oportunidades para vivir mejor. Tu recuperación
            comienza con una evaluación profesional.
          </p>
          <p className="mt-4 text-sm font-semibold text-accent">{contacto.redes}</p>
        </div>

        <div>
          <h3 className="font-display font-bold text-white">Navegación</h3>
          <ul className="mt-4 space-y-2 text-sm">
            {navLinks.map(({ href, label }) => (
              <li key={href}>
                <Link href={href} className="hover:text-accent">
                  {label}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        <div>
          <h3 className="font-display font-bold text-white">Servicios destacados</h3>
          <ul className="mt-4 space-y-2 text-sm">
            {servicios.slice(0, 5).map((s) => (
              <li key={s.slug}>
                <Link href={`/servicios/${s.slug}`} className="hover:text-accent">
                  {s.titulo}
                </Link>
              </li>
            ))}
          </ul>
        </div>

        <div>
          <h3 className="font-display font-bold text-white">Contacto</h3>
          <ul className="mt-4 space-y-3 text-sm">
            <li className="flex gap-2">
              <MapPin size={18} className="shrink-0 text-accent" />
              {contacto.direccion}
            </li>
            <li className="flex gap-2">
              <Phone size={18} className="shrink-0 text-accent" />
              {contacto.telefonos.join(" / ")}
            </li>
            <li className="flex gap-2">
              <Mail size={18} className="shrink-0 text-accent" />
              {contacto.correo}
            </li>
            <li className="flex gap-2">
              <Clock size={18} className="shrink-0 text-accent" />
              <span>
                {contacto.horario.map((h) => (
                  <span key={h.dias} className="block">
                    {h.dias}: {h.horas}
                  </span>
                ))}
              </span>
            </li>
          </ul>
        </div>
      </div>
      <div className="border-t border-white/10">
        <div className="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-5 text-xs text-white/50 sm:px-6 md:flex-row md:justify-between">
          <p>© 2026 CEPRO – Centro Profesional de Rehabilitación en Occidente</p>
          <p className="md:max-w-md md:text-right">
            La información de este sitio es orientativa y no reemplaza una valoración fisioterapéutica profesional.
          </p>
        </div>
      </div>
    </footer>
  );
}
