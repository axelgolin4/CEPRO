import PageHeader from "@/components/PageHeader";
import Gallery from "@/components/Gallery";
import CtaBanner from "@/components/CtaBanner";
import { galeria } from "@/data/site";

export const metadata = { title: "Galería" };

export default function GaleriaPage() {
  return (
    <>
      <PageHeader
        title="Galería"
        subtitle="Conoce nuestras instalaciones, nuestro equipo y cómo trabajamos día a día."
        crumbs={[{ label: "Galería" }]}
      />

      <section className="mx-auto max-w-7xl px-4 py-20 sm:px-6">
        <Gallery fotos={galeria} />
      </section>

      <CtaBanner />
    </>
  );
}
