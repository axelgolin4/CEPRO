"use client";

import { useState } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { ChevronDown, Menu, X } from "lucide-react";
import Logo from "./Logo";
import { navLinks, servicios, whatsappLink } from "@/data/site";

export default function Navbar() {
  const [open, setOpen] = useState(false);
  const pathname = usePathname();

  const isActive = (href) => (href === "/" ? pathname === "/" : pathname.startsWith(href));

  return (
    <header className="sticky top-0 z-40 bg-white/90 backdrop-blur border-b border-slate-100">
      <nav className="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6">
        <Link href="/" onClick={() => setOpen(false)}>
          <Logo />
        </Link>

        <ul className="hidden items-center gap-8 md:flex">
          {navLinks.map(({ href, label }) => (
            <li key={href} className="group relative">
              <Link
                href={href}
                className={`flex items-center gap-1 py-2 text-sm font-medium transition-colors hover:text-cepro ${
                  isActive(href) ? "text-cepro" : "text-ink/70"
                }`}
              >
                {label}
                {href === "/servicios" && <ChevronDown size={14} className="transition group-hover:rotate-180" />}
              </Link>
              {href === "/servicios" && (
                <div className="invisible absolute left-1/2 top-full w-72 -translate-x-1/2 pt-2 opacity-0 transition group-hover:visible group-hover:opacity-100">
                  <ul className="rounded-2xl bg-white p-2 shadow-xl ring-1 ring-slate-100">
                    {servicios.map((s) => (
                      <li key={s.slug}>
                        <Link
                          href={`/servicios/${s.slug}`}
                          className="block rounded-lg px-3 py-2 text-sm text-ink/80 hover:bg-surface hover:text-cepro"
                        >
                          {s.titulo}
                        </Link>
                      </li>
                    ))}
                  </ul>
                </div>
              )}
            </li>
          ))}
        </ul>

        <a
          href={whatsappLink()}
          target="_blank"
          rel="noopener noreferrer"
          className="hidden rounded-full bg-cepro px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-cepro-dark md:inline-block"
        >
          Agendar cita
        </a>

        <button
          onClick={() => setOpen(!open)}
          className="rounded-lg p-2 text-cepro md:hidden"
          aria-label={open ? "Cerrar menú" : "Abrir menú"}
        >
          {open ? <X size={26} /> : <Menu size={26} />}
        </button>
      </nav>

      {open && (
        <ul className="flex flex-col gap-1 border-t border-slate-100 bg-white px-4 py-4 md:hidden">
          {navLinks.map(({ href, label }) => (
            <li key={href}>
              <Link
                href={href}
                onClick={() => setOpen(false)}
                className={`block rounded-lg px-3 py-2 font-medium ${
                  isActive(href) ? "bg-surface text-cepro" : "text-ink"
                }`}
              >
                {label}
              </Link>
            </li>
          ))}
          <li className="pt-2">
            <a
              href={whatsappLink()}
              target="_blank"
              rel="noopener noreferrer"
              className="block rounded-full bg-cepro px-5 py-3 text-center font-semibold text-white"
            >
              Agendar cita
            </a>
          </li>
        </ul>
      )}
    </header>
  );
}
