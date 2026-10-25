"use client";

import { useEffect, useState } from "react";
import Image from "next/image";
import { ChevronLeft, ChevronRight, X } from "lucide-react";

const categorias = ["Todas", "Instalaciones", "Tratamientos", "Tecnología"];

export default function Gallery({ fotos }) {
  const [filtro, setFiltro] = useState("Todas");
  const [abierta, setAbierta] = useState(null);

  const visibles = filtro === "Todas" ? fotos : fotos.filter((f) => f.categoria === filtro);
  const mover = (paso) => setAbierta((i) => (i + paso + visibles.length) % visibles.length);

  // Teclado en el visor: Esc cierra, flechas navegan.
  useEffect(() => {
    if (abierta === null) return;
    function onKey(e) {
      if (e.key === "Escape") setAbierta(null);
      if (e.key === "ArrowRight") setAbierta((i) => (i + 1) % visibles.length);
      if (e.key === "ArrowLeft") setAbierta((i) => (i - 1 + visibles.length) % visibles.length);
    }
    window.addEventListener("keydown", onKey);
    return () => window.removeEventListener("keydown", onKey);
  }, [abierta, visibles.length]);

  return (
    <>
      <div className="flex flex-wrap justify-center gap-2">
        {categorias.map((c) => (
          <button
            key={c}
            onClick={() => setFiltro(c)}
            className={`rounded-full px-5 py-2 text-sm font-semibold transition ${
              filtro === c ? "bg-cepro text-white" : "bg-surface text-ink/70 hover:text-cepro"
            }`}
          >
            {c}
          </button>
        ))}
      </div>

      <ul className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        {visibles.map((foto, i) => (
          <li key={foto.src}>
            <button
              onClick={() => setAbierta(i)}
              className="group relative block aspect-[4/3] w-full overflow-hidden rounded-2xl bg-surface"
            >
              <Image
                src={foto.src}
                alt={foto.alt}
                fill
                sizes="(min-width: 1024px) 33vw, (min-width: 640px) 50vw, 100vw"
                className="object-cover transition duration-500 group-hover:scale-105"
              />
              <span className="absolute inset-x-0 bottom-0 bg-gradient-to-t from-cepro-dark/80 to-transparent p-4 text-left text-sm font-medium text-white opacity-0 transition group-hover:opacity-100">
                {foto.alt}
              </span>
            </button>
          </li>
        ))}
      </ul>

      {abierta !== null && (
        <div
          className="fixed inset-0 z-50 flex items-center justify-center bg-cepro-dark/95 p-4"
          onClick={() => setAbierta(null)}
          role="dialog"
          aria-modal="true"
        >
          <button className="absolute right-4 top-4 rounded-full p-2 text-white hover:bg-white/10" aria-label="Cerrar">
            <X size={28} />
          </button>
          <button
            onClick={(e) => {
              e.stopPropagation();
              mover(-1);
            }}
            className="absolute left-2 rounded-full p-2 text-white hover:bg-white/10 sm:left-6"
            aria-label="Anterior"
          >
            <ChevronLeft size={36} />
          </button>
          <figure className="relative h-[75vh] w-full max-w-5xl" onClick={(e) => e.stopPropagation()}>
            <Image src={visibles[abierta].src} alt={visibles[abierta].alt} fill sizes="100vw" className="object-contain" />
            <figcaption className="absolute -bottom-10 inset-x-0 text-center text-white/80">
              {visibles[abierta].alt}
            </figcaption>
          </figure>
          <button
            onClick={(e) => {
              e.stopPropagation();
              mover(1);
            }}
            className="absolute right-2 rounded-full p-2 text-white hover:bg-white/10 sm:right-6"
            aria-label="Siguiente"
          >
            <ChevronRight size={36} />
          </button>
        </div>
      )}
    </>
  );
}
