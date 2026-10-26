// URL pública del sitio; cambiarla aquí si se conecta un dominio propio.
export const siteUrl = "https://cepro-three.vercel.app";

export const contacto = {
  nombre: "CEPRO – Centro Profesional de Rehabilitación en Occidente",
  direccion: "Calle A 23-70, Zona 1, Edificio Andaga, Clínica 104, Quetzaltenango, Guatemala",
  telefonos: ["5995-5003", "5191-9016"],
  whatsapp: "50259955003",
  correo: "ceproxela@gmail.com",
  redes: "@ceproxela",
  horario: [
    { dias: "Lunes a viernes", horas: "9:00 – 18:00" },
    { dias: "Sábados", horas: "8:00 – 14:00" },
  ],
  nota: "Atención previa cita",
  mapsUrl: "https://maps.app.goo.gl/U4TAD73rwfknyCru5",
  mapsEmbed: "https://www.google.com/maps?q=14.8409719,-91.5278376&z=17&output=embed",
};

export const whatsappLink = (mensaje = "Hola, quiero agendar una evaluación en CEPRO.") =>
  `https://wa.me/${contacto.whatsapp}?text=${encodeURIComponent(mensaje)}`;

export const navLinks = [
  { href: "/", label: "Inicio" },
  { href: "/nosotros", label: "Nosotros" },
  { href: "/servicios", label: "Servicios" },
  { href: "/equipo", label: "Equipo" },
  { href: "/galeria", label: "Galería" },
  { href: "/contacto", label: "Contacto" },
];

export const servicios = [
  {
    slug: "fisioterapia-musculoesqueletica",
    especialista: "yessi-maldonado",
    titulo: "Fisioterapia musculoesquelética",
    resumen: "Tratamiento de lesiones de músculos, tendones, ligamentos y articulaciones.",
    descripcion:
      "Tratamiento de lesiones y alteraciones que afectan músculos, tendones, ligamentos y articulaciones. Nuestro objetivo es disminuir el dolor, recuperar la movilidad, mejorar la fuerza y facilitar el retorno progresivo a las actividades diarias.",
    dirigidoA: ["Dolor lumbar y cervical", "Tendinopatías", "Esguinces", "Lesiones musculares", "Limitaciones articulares"],
  },
  {
    slug: "rehabilitacion-deportiva",
    especialista: "luis-arturo-hernandez",
    titulo: "Rehabilitación deportiva",
    resumen: "Recupera tu función física y vuelve al deporte de forma progresiva.",
    descripcion:
      "Programas personalizados para recuperar la función física después de una lesión y facilitar el retorno progresivo al deporte. Incluye fortalecimiento, movilidad, control neuromuscular y acondicionamiento físico adaptado a las necesidades de cada persona. Buscamos que los pacientes puedan volver a entrenar y practicar deporte con una mejor preparación física y funcional.",
    dirigidoA: ["Fortalecimiento", "Movilidad", "Control neuromuscular", "Acondicionamiento físico"],
  },
  {
    slug: "rehabilitacion-de-rodilla",
    especialista: "luis-arturo-hernandez",
    titulo: "Programa integral de rodilla",
    resumen: "Para dolor de rodilla, artrosis, debilidad muscular o limitación funcional.",
    descripcion:
      "Atención dirigida a personas con dolor de rodilla, artrosis, debilidad muscular o limitación funcional. Integramos evaluación funcional, fortalecimiento progresivo, ejercicio terapéutico y recursos complementarios según las necesidades de cada paciente. El objetivo es mejorar la movilidad y facilitar actividades como caminar, subir y bajar gradas, agacharse, trabajar y realizar ejercicio físico.",
    dirigidoA: ["Dolor de rodilla", "Artrosis", "Debilidad muscular", "Limitación funcional"],
  },
  {
    slug: "tecnologia-avanzada",
    titulo: "Terapias con tecnología avanzada",
    resumen: "Ondas de choque, láser, radiofrecuencia, electroestimulación y presoterapia.",
    descripcion:
      "Utilizamos recursos tecnológicos que complementan el tratamiento fisioterapéutico, seleccionados de acuerdo con la evaluación y las necesidades de cada paciente. Estas modalidades se incorporan al plan de tratamiento cuando están indicadas, como complemento del proceso de rehabilitación.",
    dirigidoA: ["Terapia de ondas de choque", "Láser terapéutico", "Radiofrecuencia", "Electroestimulación", "Presoterapia"],
  },
  {
    slug: "rehabilitacion-de-hombro",
    especialista: "luis-arturo-hernandez",
    titulo: "Rehabilitación de hombro",
    resumen: "Recupera la movilidad, la fuerza y la función del hombro.",
    descripcion:
      "Tratamiento dirigido a recuperar la movilidad, la fuerza y la función del hombro. El tratamiento puede incluir ejercicio terapéutico progresivo, técnicas manuales y otros recursos complementarios según la valoración fisioterapéutica.",
    dirigidoA: ["Lesiones del manguito rotador", "Tendinopatías", "Rigidez articular", "Dolor al mover el brazo"],
  },
  {
    slug: "ejercicio-terapeutico",
    especialista: "luis-arturo-hernandez",
    titulo: "Ejercicio terapéutico personalizado",
    resumen: "Programas adaptados a tu condición, capacidades y objetivos.",
    descripcion:
      "Diseñamos programas de ejercicios adaptados a la condición física, las capacidades y los objetivos de cada persona. Estos planes están orientados a mejorar la fuerza, la movilidad, la resistencia y el control del movimiento. También proporcionamos recomendaciones para dar continuidad al proceso de recuperación en casa, favoreciendo la autonomía y la adherencia al tratamiento.",
    dirigidoA: ["Fuerza", "Movilidad", "Resistencia", "Control del movimiento"],
  },
  {
    slug: "descargas-musculares",
    especialista: "carmen-maria-fetzer",
    titulo: "Descargas musculares y recuperación",
    resumen: "Para deportistas y personas activas con sobrecarga muscular.",
    descripcion:
      "Servicio dirigido a deportistas y personas físicamente activas que presentan sobrecarga muscular asociada al entrenamiento o al esfuerzo físico. Puede incluir técnicas manuales y recomendaciones de recuperación para mejorar la tolerancia al movimiento y facilitar la continuidad de las actividades físicas y deportivas.",
    dirigidoA: ["Deportistas", "Personas físicamente activas", "Sobrecarga por entrenamiento"],
  },
  {
    slug: "rehabilitacion-postoperatoria",
    titulo: "Rehabilitación funcional y postoperatoria",
    resumen: "Acompañamiento después de cirugías, lesiones o inmovilización.",
    descripcion:
      "Acompañamiento fisioterapéutico después de cirugías, lesiones o periodos de inmovilización. El tratamiento se adapta a la fase de recuperación y a las indicaciones médicas para restablecer progresivamente la movilidad, la fuerza, el equilibrio y la independencia funcional.",
    dirigidoA: ["Postoperatorio", "Después de una lesión", "Periodos de inmovilización"],
  },
  {
    slug: "masajes-de-espalda",
    especialista: "carmen-maria-fetzer",
    titulo: "Masajes profesionales de espalda",
    resumen: "Relajación muscular y alivio de la tensión acumulada.",
    descripcion:
      "Servicio de masaje profesional enfocado en la relajación muscular y el alivio de la tensión acumulada en la espalda, especialmente en personas con sobrecarga relacionada con el trabajo, las posturas mantenidas o las actividades cotidianas. Mediante técnicas manuales adaptadas a cada persona, buscamos favorecer la relajación y proporcionar un espacio de recuperación física.",
    dirigidoA: ["Tensión por trabajo", "Posturas mantenidas", "Estrés y sobrecarga"],
  },
  {
    slug: "fisioterapia-en-linea",
    titulo: "Fisioterapia y orientación en línea",
    resumen: "Seguimiento, asesoría y ejercicios desde casa.",
    descripcion:
      "Ofrecemos atención y orientación fisioterapéutica en línea para pacientes que necesitan seguimiento, asesoramiento y programas de ejercicios adaptados a sus condiciones y objetivos. Puede incluir ejercicios en casa, educación sobre el movimiento y seguimiento de la evolución, siempre que la condición del paciente permita una atención remota adecuada.",
    dirigidoA: ["Seguimiento", "Ejercicios en casa", "Educación sobre el movimiento"],
  },
];

export const tecnologias = [
  { nombre: "Ondas de choque", texto: "Ondas acústicas que estimulan la regeneración en tendinopatías y dolor persistente." },
  { nombre: "Láser terapéutico", texto: "Luz de baja intensidad que ayuda a modular el dolor y la inflamación." },
  { nombre: "Radiofrecuencia", texto: "Calor profundo que favorece la circulación y la relajación de los tejidos." },
  { nombre: "Electroestimulación", texto: "Corrientes que ayudan a aliviar el dolor y a activar la musculatura." },
  { nombre: "Presoterapia", texto: "Compresión secuencial que favorece la circulación y la recuperación de las piernas." },
];

export const pasos = [
  { titulo: "Evaluación", texto: "Valoramos tu condición, tu movilidad y tus objetivos para entender el origen del problema." },
  { titulo: "Plan personalizado", texto: "Diseñamos un tratamiento adaptado a tu caso, tu fase de recuperación y tus actividades." },
  { titulo: "Tratamiento progresivo", texto: "Ejercicio terapéutico dosificado, técnicas manuales y tecnología cuando está indicada." },
  { titulo: "Seguimiento", texto: "Medimos tu evolución y te damos recomendaciones para continuar en casa." },
];

export const beneficios = [
  { titulo: "Atención personalizada", texto: "Cada paciente recibe un plan adaptado a su condición y sus objetivos." },
  { titulo: "Ejercicio terapéutico dosificado", texto: "Trabajamos de manera progresiva para recuperar capacidades físicas y funcionales." },
  { titulo: "Tecnología complementaria", texto: "Incorporamos recursos terapéuticos seleccionados según cada caso." },
  { titulo: "Enfoque funcional", texto: "Que la recuperación se refleje en caminar, trabajar, subir gradas, entrenar o hacer deporte." },
  { titulo: "Acompañamiento profesional", texto: "Te orientamos durante todo el proceso y te damos recomendaciones para casa." },
  { titulo: "Presencial y en línea", texto: "Alternativas de atención según tus necesidades y posibilidades." },
];

export const equipo = [
  {
    slug: "luis-arturo-hernandez",
    nombre: "Lic. Luis Arturo Hernández Velásquez",
    cargo: "Licenciado en Fisioterapia",
    foto: "/fotos/equipo/luis-perfil.jpg",
    especialidades: [
      "Rehabilitación de rodilla y hombro",
      "Dosificación y prescripción del ejercicio terapéutico",
      "Prevención de lesiones musculoesqueléticas y deportivas",
      "Optimización del rendimiento deportivo",
    ],
    formacion: [
      "Técnico Universitario en Terapia Física y Ocupacional",
      "Licenciado en Fisioterapia",
      "Cierre de pensum de Maestría en Optimización del Rendimiento Deportivo",
    ],
    experiencia: [
      "Área de Medicina Física y Rehabilitación del IGSS, Quetzaltenango",
      "Clínicas privadas del área de Quetzaltenango",
    ],
    objetivo:
      "Ayudar a nuestros pacientes a recuperar su funcionalidad y volver a realizar sus actividades cotidianas, laborales, deportivas y recreativas con la menor molestia posible y en el menor tiempo que permita una recuperación segura y adecuada.",
  },
  {
    slug: "yessi-maldonado",
    nombre: "Licda. Yessi Maldonado",
    cargo: "Licenciada en Fisioterapia",
    foto: "/fotos/equipo/yessi-perfil.jpg",
    especialidades: [
      "Fisioterapia pediátrica",
      "Fisioterapia neurológica",
      "Rehabilitación de espalda, rodilla y tobillo",
    ],
    formacion: ["Técnico en Terapia Física y Ocupacional", "Licenciatura en Fisioterapia"],
    experiencia: [
      "5 años de experiencia en clínicas privadas y centros de rehabilitación pediátrica",
      "Clínica privada AMINIQ, Quetzaltenango y Malacatán",
      "Centro Galo",
      "Fundabiem, Quetzaltenango",
    ],
    objetivo:
      "Contribuir a mejorar la calidad de vida de mis pacientes mediante una atención fisioterapéutica integral, personalizada y basada en sus necesidades, promoviendo la recuperación funcional, la independencia y el bienestar.",
  },
  {
    slug: "carmen-maria-fetzer",
    nombre: "Carmen María Fetzer Milian",
    cargo: "Técnica en Terapia Física y Ocupacional",
    foto: "/fotos/equipo/carmen-perfil.jpg",
    especialidades: [
      "Terapia física y rehabilitación",
      "Masajes relajantes y bienestar corporal",
      "Técnicas de masaje terapéutico",
    ],
    formacion: ["Técnica en Terapia Física y Ocupacional"],
    experiencia: [
      "Las Cumbres: masajes y bienestar corporal",
      "IGSS, Quetzaltenango: atención y rehabilitación",
      "Docencia en técnicas de masaje",
    ],
    objetivo:
      "Contribuir a la recuperación y al bienestar integral de nuestros pacientes, combinando técnicas terapéuticas con masajes relajantes según las necesidades de cada persona.",
  },
];

export const galeria = [
  { src: "/fotos/f02a0538-3ec0-442d-abc3-14c06d0431b0.jpg", alt: "Área de tratamiento de CEPRO", categoria: "Instalaciones" },
  { src: "/fotos/70bc26d2-2f7c-4bf6-a265-d524dfbc2097.jpg", alt: "Equipo de CEPRO en el área de ejercicio", categoria: "Instalaciones" },
  { src: "/fotos/arturo.jpg", alt: "Equipo de ondas de choque y electroestimulación", categoria: "Tecnología" },
  { src: "/fotos/e6ed9add-9306-471c-bf14-7602c1587e6e.jpg", alt: "Terapia de ondas de choque en el pie", categoria: "Tecnología" },
  { src: "/fotos/b0db8798-3627-4940-b2f3-bdc29ed68bc7.jpg", alt: "Láser terapéutico en rodilla", categoria: "Tecnología" },
  { src: "/fotos/a769cafa-1023-4ca0-bc22-8b930f80dd6b.jpg", alt: "Equipo de electroestimulación", categoria: "Tecnología" },
  { src: "/fotos/e993bacf-d61d-430f-8833-e5af4d736f06.jpg", alt: "Electroestimulación en rodilla", categoria: "Tecnología" },
  { src: "/fotos/453c42c4-57b8-407b-b667-d7fc78317202.jpg", alt: "Electrodo de electroestimulación en rodilla", categoria: "Tecnología" },
  { src: "/fotos/5213d594-5909-494b-9a5e-49f875906a07.jpg", alt: "Ejercicio terapéutico con banda elástica", categoria: "Tratamientos" },
  { src: "/fotos/95ae66aa-66b2-412f-bb08-8a145045d553.jpg", alt: "Movilización y estiramiento de pierna", categoria: "Tratamientos" },
  { src: "/fotos/52671b8d-8386-4201-86f3-11bdd0ae3571.jpg", alt: "Masaje profesional de espalda", categoria: "Tratamientos" },
  { src: "/fotos/740f3fe0-56ad-46fe-a40f-711fbce8e0ae.jpg", alt: "Tratamiento fisioterapéutico en brazo", categoria: "Tratamientos" },
  { src: "/fotos/cc652f64-0e9d-41cb-b04e-677f2f2fb7d9.jpg", alt: "Fisioterapeuta tratando a una paciente", categoria: "Tratamientos" },
];
