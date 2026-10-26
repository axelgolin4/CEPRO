import { equipo, navLinks, servicios, siteUrl } from "@/data/site";

export default function sitemap() {
  const paginas = navLinks.map(({ href }) => ({
    url: `${siteUrl}${href === "/" ? "" : href}`,
    changeFrequency: "monthly",
    priority: href === "/" ? 1 : 0.8,
  }));

  const detalleServicios = servicios.map((s) => ({
    url: `${siteUrl}/servicios/${s.slug}`,
    changeFrequency: "monthly",
    priority: 0.7,
  }));

  const perfiles = equipo.map((p) => ({
    url: `${siteUrl}/equipo/${p.slug}`,
    changeFrequency: "yearly",
    priority: 0.5,
  }));

  return [...paginas, ...detalleServicios, ...perfiles];
}
