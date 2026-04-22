<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const showNav = ref(false);
const cmsUrl = document.querySelector('meta[name="cms-url"]')?.content ?? "#";

const sending = ref(false);
const toast = ref("");

const navLinks = [
    { label: "Home", href: "#home" },
    { label: "About", href: "#about" },
    { label: "Projects", href: "#projects" },
    { label: "Contact", href: "#contact" },
];

const techStack = [
    { name: "PHP", icon: "/images/tech/php.svg" },
    { name: "Laravel", icon: "/images/tech/laravel.svg" },
    { name: "AWS", icon: "/images/tech/aws.svg" },
    { name: "HTML", icon: "/images/tech/html5.svg" },
    { name: "CSS", icon: "/images/tech/css3.svg" },
    { name: "JS", icon: "/images/tech/javascript.svg" },
    { name: "TS", icon: "/images/tech/typescript.svg" },
    { name: "Git", icon: "/images/tech/git.svg" },
    { name: "Rails", icon: "/images/tech/rails.svg" },
    { name: "Flutter", icon: "/images/tech/flutter.svg" },
    { name: "MySQL", icon: "/images/tech/mysql.svg" },
    { name: "Postgresql", icon: "/images/tech/postgresql.svg" },
];

const miniProjects = [
    {
        title: "Maze game",
        description:
            "A P5.js Maze game that uses recursive backtracking to generate a random maze which you can then attempt to solve. Health, movement and a clear goal added to make the experience more game-like.",
        demo: "https://yusuf-117.github.io/P5-Maze-game",
        github: "https://github.com/Yusuf-117/P5-Maze-game",
    },
    {
        title: "Block Shooter Minigame",
        description:
            "A quick p5.js minigame built while preparing for the maze game that ended up being more fun than expected.",
        demo: "https://yusuf-117.github.io/P5-Shooter-Game",
        github: "https://github.com/Yusuf-117/P5-Shooter-Game",
    },
    {
        title: "Lifegrid",
        description:
            "Conway's Game of Life as a drop-in animated background library (used for this section background).",
        demo: "https://yusuf-117.github.io/Lifegrid",
        github: "https://github.com/Yusuf-117/Lifegrid",
    },
    {
        title: "Memory game",
        description: "A small browser memory game weekend build.",
        demo: "https://yusuf-117.github.io/memoryGame",
        github: "https://github.com/Yusuf-117/memoryGame",
    },
    {
        title: "Ruby Chess",
        description: "A Ruby CLI Chess game completed as part of Odin Challenge.",
        demo: "",
        github: "https://github.com/Yusuf-117/ruby-chess",
    },
    {
        title: "API usage demo",
        description:
            'Submission for a coding challenge: "Create a page that uses at least 4 APIs".',
        demo: "https://yusuf-117.github.io/apiUsage",
        github: "https://github.com/Yusuf-117/apiUsage",
    },
    {
        title: "Single Product Page",
        description:
            'Submission for a coding challenge: "Create a single product page advertising a fake product".',
        demo: "https://yusuf-117.github.io/SPP",
        github: "https://github.com/Yusuf-117/SPP",
    },
    {
        title: "Master coder",
        description:
            'Submission for a coding challenge: "Create a single page with the term Master Coder". Included a quick JS challenge for visitors.',
        demo: "https://yusuf-117.github.io/SPP",
        github: "https://github.com/Yusuf-117/SPP",
    },
];

const cmsPreview = "/images/cms.png";
const crmPreview = "/images/crm.png";
const symfonyPreview = "/images/recruit.png";

const form = ref({
    name: "",
    email: "",
    message: "",
});

const handleScroll = () => {
    showNav.value = window.scrollY > 120;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);

    const el = document.querySelector("#gol-bg");

    if (el) {
        const grid = LifeGrid.init({
            selector: "#gol-bg",
            width: el.offsetWidth,
            height: el.offsetHeight,
            cellSize: 10,
            density: 0.08,
            speed: 30,
            aliveColor: "#bd4b4b70",
            deadColor: "#00000000",
            mouseDraw: false,
            background: true,
        });

        if (import.meta.hot) {
            import.meta.hot.dispose(() => {
                grid?.destroy();
            });
        }
    }
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const options = {
    background: {
        color: "#111827",
    },
    interactivity: {
        events: {
            onHover: {
                enable: true,
                mode: "grab",
            },
        },
        modes: {
            grab: {
                distance: 180,
                links: {
                    opacity: 0.45,
                },
            },
        },
    },
    particles: {
        number: {
            value: 80,
        },
        color: {
            value: "#BD4B4B",
        },
        links: {
            enable: true,
            color: "#EFB7B7",
            distance: 150,
            opacity: 0.18,
        },
        move: {
            enable: true,
            speed: 0.8,
        },
        size: {
            value: 2,
        },
        opacity: {
            value: 0.6,
        },
    },
};

const send = async () => {
    sending.value = true;

    try {
        const response = await fetch("/contact", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Accept: "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content"),
            },
            body: JSON.stringify(form.value),
        });

        if (!response.ok) {
            throw new Error("Failed to send");
        }

        form.value = {
            name: "",
            email: "",
            message: "",
        };

        toast.value = "Thanks for your message.";
        setTimeout(() => {
            toast.value = "";
        }, 3000);
    } finally {
        sending.value = false;
    }
};
</script>

<template>
    <div class="page-shell">
        <transition enter-active-class="transition duration-300" enter-from-class="opacity-0 -translate-y-3"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-200"
            leave-from-class="opacity-100" leave-to-class="opacity-0">
            <nav v-if="showNav" class="fixed top-0 z-50 w-full nav-shell">
                <div class="section-shell flex justify-center gap-6 py-4 text-sm uppercase tracking-[0.2em] md:gap-10">
                    <a v-for="link in navLinks" :key="link.href" :href="link.href" class="nav-link">
                        {{ link.label }}
                    </a>
                </div>
            </nav>
        </transition>

        <!-- Hero -->
        <section id="home"
            class="relative isolate flex min-h-screen items-center justify-center overflow-hidden text-center">
            <div class="absolute inset-0 z-0">
                <vue-particles id="tsparticles" :options="options" class="h-full w-full" />
            </div>

            <div class="relative z-10 px-6">
                <p class="mb-4 text-lg text-zinc-300 md:text-xl">Hello, I'm</p>

                <h1 class="text-5xl font-bold tracking-tight sm:text-6xl md:text-8xl">
                    Yusuf
                </h1>

                <p class="mt-6 text-lg text-zinc-400 md:text-2xl">
                    Full stack developer building modern web experiences.
                </p>

                <a href="#projects" class="primary-btn group mt-10">
                    <span>View my work</span>
                    <span class="ml-3 transition-transform duration-200 group-hover:translate-x-1">
                        →
                    </span>
                </a>
            </div>
        </section>

        <!-- About -->
        <section id="about"
            class="section-shell relative z-10 flex flex-col items-center gap-16 py-20 md:py-32 lg:flex-row">
            <div class="w-full lg:w-1/2">
                <p class="section-label">About</p>

                <h2 class="text-3xl font-bold leading-tight md:text-4xl">
                    A results-driven Software Developer with 5+ years of
                    professional experience delivering data-driven applications.
                </h2>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                    <div v-for="(tech, index) in techStack" :key="tech.name" :class="[
                        'tech-card',
                        Math.floor(index / 4) % 2 === 1
                            ? 'lg:translate-x-6'
                            : '',
                    ]">
                        <img :src="tech.icon" :alt="tech.name" class="h-10 w-10 object-contain" />
                        <span class="mt-3 text-xs uppercase tracking-[0.2em] text-zinc-300">
                            {{ tech.name }}
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects -->
        <section id="projects" class="relative z-10 py-20">
            <div class="section-shell grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
                <div class="panel-frame">
                    <img :src="cmsPreview" alt="Project preview" class="w-full" />
                </div>

                <div>
                    <p class="section-label">Demo</p>
                    <h2 class="text-3xl font-bold leading-tight sm:text-4xl md:text-5xl">
                        Laravel CMS
                    </h2>

                    <p class="mt-8 max-w-xl text-lg text-zinc-400">
                        A demo CMS using Laravel, Inertia (Vue), TailwindCSS.
                        Showcasing real-time features prioritised over UI.
                        <br /><br />
                        <span>Email: viewer@example.com</span><br />
                        <span>Password: password</span>
                    </p>

                    <div class="mt-10 space-y-6">
                        <a :href="cmsUrl" class="accent-link">Live Demo</a>
                        <a href="https://github.com/Yusuf-117/laravel-cms-demo" class="accent-link">
                            GitHub
                        </a>
                    </div>
                </div>
            </div>

            <div class="section-shell mt-50 grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
                <div>
                    <p class="section-label">Demo</p>
                    <h2 class="text-3xl font-bold leading-tight sm:text-4xl md:text-5xl">
                        Rails CRM
                    </h2>

                    <p class="mt-8 max-w-xl text-lg text-zinc-400">
                        A demo sales CRM built with Ruby on Rails 8, Hotwire,
                        PostgreSQL, and TailwindCSS. Includes company/contact
                        management, analytics and drag-and-drop pipelines.
                    </p>

                    <div class="mt-10 space-y-6">
                        <a href="https://github.com/Yusuf-117/mini-rails-crm" class="accent-link">
                            GitHub
                        </a>
                    </div>
                </div>

                <div class="panel-frame">
                    <img :src="crmPreview" alt="Project preview" class="w-full" />
                </div>
            </div>

            <div class="section-shell mt-50 grid grid-cols-1 items-center gap-16 lg:grid-cols-2">
                <div class="panel-frame">
                    <img :src="symfonyPreview" alt="Project preview" class="w-full" />
                </div>

                <div>
                    <p class="section-label">Demo</p>
                    <h2 class="text-3xl font-bold leading-tight sm:text-4xl md:text-5xl">
                        Symfony CRM
                    </h2>

                    <p class="mt-8 max-w-xl text-lg text-zinc-400">
                        A demo recruitment CRM built with Symfony, Doctrine ORM, Twig and TailwindCSS. Includes candidate/vacancy management, application tracking, and a stage-based pipeline.
                    </p>

                    <div class="mt-10 space-y-6">
                        <a href="https://recruit.yusufibrahim.co.uk" class="accent-link">Live Demo</a>
                        <a href="https://github.com/Yusuf-117/symfony-recruit-demo" class="accent-link">
                            GitHub
                        </a>
                    </div>
                </div>
            </div>

            <h3 class="mt-20 text-center text-3xl font-bold md:text-4xl">
                and more to come...
            </h3>

            <!-- Weekend builds -->
            <div id="gol-bg" class="relative mt-32 min-h-screen flex items-center p-5">
                <div class="section-shell relative z-10">
                    <h3 class="text-3xl font-bold md:text-4xl">
                        Weekend builds
                    </h3>

                    <div class="mt-10 grid gap-8 md:grid-cols-2">
                        <div v-for="project in miniProjects" :key="project.title" class="mini-card">
                            <h4 class="mb-5 text-xl font-semibold">
                                {{ project.title }}
                            </h4>

                            <p>{{ project.description }}</p>

                            <a v-if="project.demo != ''" :href="project.demo" class="accent-link mt-6">
                                Live Demo
                            </a>

                            <a :href="project.github" class="accent-link mt-6">
                                GitHub
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section id="contact" class="relative z-10 mx-auto max-w-4xl px-6 py-20">
            <p class="section-label">Contact</p>

            <h2 class="mb-14 text-2xl font-bold md:text-4xl">
                Let's build something great.
            </h2>

            <form @submit.prevent="send" class="space-y-8">
                <input v-model="form.name" type="text" placeholder="Name" class="input-field" />

                <input v-model="form.email" type="email" placeholder="Email" class="input-field" />

                <textarea v-model="form.message" rows="6" placeholder="Message" class="input-field"></textarea>

                <button type="submit" class="primary-btn" :disabled="sending">
                    <span v-if="sending" class="spinner"></span>
                    <span>{{ sending ? "Sending..." : "Send" }}</span>
                </button>
            </form>
            <transition enter-active-class="transition duration-300" enter-from-class="opacity-0 translate-y-2"
                enter-to-class="opacity-100 translate-y-0" leave-active-class="transition duration-200"
                leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="toast" class="toast">
                    {{ toast }}
                </div>
            </transition>
        </section>

        <footer class="px-6 py-12 text-center text-sm text-zinc-500">
            Yusuf Ibrahim © 2026
        </footer>
    </div>
</template>
