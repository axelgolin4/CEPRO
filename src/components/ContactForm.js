"use client";

import { servicios, whatsappLink } from "@/data/site";

const inputClass =
  "w-full rounded-xl border border-slate-200 px-4 py-3 outline-none transition focus:border-cepro focus:ring-2 focus:ring-cepro/20";

// Arma el mensaje con los datos del formulario y lo abre en WhatsApp.
export default function ContactForm() {
  function handleSubmit(e) {
    e.preventDefault();
    const data = new FormData(e.currentTarget);
    const mensaje = [
      `Hola, soy ${data.get("nombre")}.`,
      `Me interesa: ${data.get("servicio")} (${data.get("modalidad")}).`,
      data.get("mensaje"),
      `Mi teléfono: ${data.get("telefono")}`,
    ]
      .filter(Boolean)
      .join("\n");
    window.open(whatsappLink(mensaje), "_blank", "noopener");
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <h2 className="font-display text-2xl font-bold text-cepro">Escríbenos</h2>
      <input name="nombre" required placeholder="Nombre completo" className={inputClass} />
      <input name="telefono" required type="tel" placeholder="Teléfono" className={inputClass} />
      <select name="servicio" className={inputClass} defaultValue={servicios[0].titulo}>
        {servicios.map((s) => (
          <option key={s.slug}>{s.titulo}</option>
        ))}
      </select>
      <div className="flex gap-6">
        {["Presencial", "En línea"].map((m) => (
          <label key={m} className="flex items-center gap-2">
            <input type="radio" name="modalidad" value={m} defaultChecked={m === "Presencial"} className="accent-cepro" />
            {m}
          </label>
        ))}
      </div>
      <textarea name="mensaje" rows={4} placeholder="Cuéntanos brevemente tu caso" className={inputClass} />
      <button className="w-full rounded-full bg-accent py-3.5 font-semibold text-white transition hover:brightness-110">
        Enviar por WhatsApp
      </button>
    </form>
  );
}
