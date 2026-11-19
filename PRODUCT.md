# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

- **Personas con dolor o lesión** (primario): adultos de Quetzaltenango y el occidente de Guatemala con dolor lumbar, cervical, de rodilla u hombro, o en recuperación postoperatoria. Llegan buscando un lugar confiable donde evaluarse y empezar tratamiento; muchos lo hacen desde el celular.
- **Deportistas y personas activas**: lesiones deportivas, retorno al deporte, sobrecarga muscular y rendimiento.
- **Adultos mayores**: artrosis, rodilla y movilidad para actividades diarias (caminar, subir gradas, agacharse). Con frecuencia es un familiar quien busca y decide.

Fisioterapia pediátrica y neurológica existe como especialidad de una integrante del equipo, pero no es la audiencia principal del sitio.

## Product Purpose

Sitio web de CEPRO – Centro Profesional de Rehabilitación en Occidente. Su trabajo es que una persona con dolor o una lesión entienda qué tratan, confíe en el equipo y agende una evaluación. Éxito = contactos por WhatsApp o llamada para agendar.

## Positioning

CEPRO combina **ejercicio terapéutico dosificado** con **tecnología complementaria** (ondas de choque, láser terapéutico, radiofrecuencia, electroestimulación, presoterapia), elegida según la evaluación de cada paciente. No es una clínica de solo masaje o solo aparatos: el objetivo es recuperar función real (caminar, trabajar, subir gradas, entrenar).

## Operating Context

- Atención presencial con previa cita en Calle A 23-70, Zona 1, Edificio Andaga, Clínica 104, Quetzaltenango. En Google Maps la ficha aparece como "CEPRO - PhysioGama".
- Atención y seguimiento en línea cuando la condición lo permite.
- Horario: lunes a viernes 9:00–18:00, sábados 8:00–14:00.
- El paciente agenda escribiendo por WhatsApp o llamando.

## Capabilities and Constraints

- Sitio estático en Next.js 16 (App Router) + Tailwind 4, desplegado en Vercel (`https://cepro-three.vercel.app`). Sin backend ni base de datos; todo el contenido vive en `src/data/site.js`.
- Páginas: Inicio, Nosotros, Servicios (10 detalles), Equipo (3 perfiles), Galería y Contacto.
- Contacto: WhatsApp y llamada telefónica al mismo nivel. Teléfonos 5995-5003 (también WhatsApp) y 5191-9016. Correo ceproxela@gmail.com. Redes @ceproxela.
- Todo el texto en español (Guatemala).

## Brand Commitments

- Nombre: "CEPRO – Centro Profesional de Rehabilitación en Occidente". Abreviado CEPRO / CEPRO Xela.
- Logo actual: wordmark "CEPRO" en mayúsculas con espaciado amplio, azul (#0B4DA8 en la versión original, azul marino en la versión del ícono), con el nombre completo debajo en itálica pequeña. No hay símbolo definitivo; el del sitio es provisional.
- Mensaje institucional: "Recuperar el movimiento significa recuperar oportunidades para vivir mejor." / "Tu recuperación comienza con una evaluación profesional."
- Equipo: Lic. Luis Arturo Hernández Velásquez, Licda. Yessi Maldonado y Carmen María Fetzer Milian.
- Crédito "Diseño web: Axel Rodas" en el footer.

## Evidence on Hand

- Fotos reales de la clínica, tratamientos y equipos en `public/fotos/` (ondas de choque, láser, electroestimulación, ejercicio con banda, masaje, área de tratamiento, equipo).
- Retratos del equipo editados con fondo beige uniforme en `public/fotos/equipo/`.
- Perfiles profesionales reales (formación, experiencia, especialidades) en `src/data/site.js`.
- **No existen** testimonios, reseñas, precios, cifras de pacientes ni años de experiencia de la clínica. No se deben inventar.

## Product Principles

1. La primera acción siempre está a la mano: escribir por WhatsApp o llamar.
2. Explicar en lenguaje de paciente (qué me duele, qué voy a poder volver a hacer), no en jerga clínica.
3. Mostrar al equipo y la clínica reales; la confianza viene de personas y lugar verificables.
4. La tecnología se presenta como complemento del ejercicio, nunca como promesa milagrosa.
5. No publicar afirmaciones sin respaldo (cifras, resultados, testimonios).

## Accessibility & Inclusion

Parte de la audiencia son adultos mayores y personas con dolor que navegan desde el celular: texto legible, buen contraste, objetivos táctiles amplios y teléfonos que se puedan tocar para llamar.
