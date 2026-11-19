"use client";

import { useState } from "react";
import ContactActions from "./ContactActions";

const zonas = [
  { id: "rodilla", label: "Rodilla", frase: "me duele la rodilla" },
  { id: "espalda", label: "Espalda o cuello", frase: "tengo dolor de espalda o cuello" },
  { id: "hombro", label: "Hombro", frase: "me duele el hombro" },
  { id: "deporte", label: "Lesión deportiva", frase: "tengo una lesión deportiva" },
  { id: "cirugia", label: "Después de una cirugía", frase: "necesito rehabilitación después de una cirugía" },
];

// El paciente marca dónde le duele y el mensaje de WhatsApp sale escrito.
export default function PainPicker() {
  const [zona, setZona] = useState(null);
  const elegida = zonas.find((z) => z.id === zona);
  const mensaje = elegida ? `Hola, ${elegida.frase} y quiero agendar una evaluación en CEPRO.` : undefined;

  return (
    <div>
      <fieldset>
        <legend className="font-semibold text-white">¿Dónde te duele?</legend>
        <div className="mt-3 flex flex-wrap gap-2">
          {zonas.map((z) => {
            const marcada = z.id === zona;
            return (
              <label
                key={z.id}
                className={`relative cursor-pointer select-none rounded-full border px-4 py-2 text-sm font-medium transition ${
                  marcada
                    ? "border-accent bg-accent text-white"
                    : "border-white/25 bg-white/10 text-white hover:bg-white/20"
                } has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-white`}
              >
                <input
                  type="radio"
                  name="zona"
                  value={z.id}
                  checked={marcada}
                  onChange={() => setZona(z.id)}
                  className="sr-only"
                />
                {z.label}
              </label>
            );
          })}
        </div>
      </fieldset>
      <p className="mt-3 min-h-5 text-sm text-white/70" aria-live="polite">
        {elegida ? `Tu mensaje dirá: «${mensaje}»` : "Marca una opción y el mensaje sale escrito."}
      </p>
      <ContactActions mensaje={mensaje} dark className="mt-5" />
    </div>
  );
}
