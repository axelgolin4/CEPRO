import { Clock, Mail, MapPin, Phone } from "lucide-react";
import PageHeader from "@/components/PageHeader";
import ContactForm from "@/components/ContactForm";
import { contacto } from "@/data/site";

export const metadata = { title: "Contacto" };

export default function ContactoPage() {
  const info = [
    { icon: MapPin, titulo: "Dirección", lineas: [contacto.direccion] },
    { icon: Phone, titulo: "Teléfonos y WhatsApp", lineas: contacto.telefonos },
    { icon: Mail, titulo: "Correo", lineas: [contacto.correo] },
    {
      icon: Clock,
      titulo: "Horario",
      lineas: [...contacto.horario.map((h) => `${h.dias}: ${h.horas}`), contacto.nota],
    },
  ];

  return (
    <>
      <PageHeader
        title="Contáctanos"
        subtitle="Tu recuperación comienza con una evaluación profesional."
        crumbs={[{ label: "Contacto" }]}
      />

      <section className="mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-2">
        <ContactForm />
        <div className="grid gap-4 sm:grid-cols-2">
          {info.map(({ icon: Icon, titulo, lineas }) => (
            <div key={titulo} className="rounded-2xl bg-surface p-6">
              <Icon className="text-accent" />
              <h2 className="mt-3 font-display font-bold text-cepro">{titulo}</h2>
              {lineas.map((l) => (
                <p key={l} className="mt-1 text-sm text-ink/80">
                  {l}
                </p>
              ))}
            </div>
          ))}
        </div>
      </section>

      <iframe
        title="Ubicación de CEPRO"
        src={contacto.mapsEmbed}
        className="h-96 w-full border-0"
        loading="lazy"
      />
    </>
  );
}
