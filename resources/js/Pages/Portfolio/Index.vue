<script setup>
import { ref, onMounted, onUnmounted } from "vue";

const showNav = ref(false);
const cmsUrl = document.querySelector('meta[name="cms-url"]')?.content ?? "#";

const handleScroll = () => {
    showNav.value = window.scrollY > 120;
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
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

const cmsPreview = "/images/cms.png";

const form = ref({
    name: "",
    email: "",
    message: "",
});

const send = async () => {
    await axios.post("/contact", form.value);

    form.value = {
        name: "",
        email: "",
        message: "",
    };
};
</script>

<template>
    <div
        class="relative min-h-screen overflow-x-hidden bg-slate-900 text-zinc-100"
    >
        <!-- invis fixed Nav -->
        <transition
            enter-active-class="transition duration-300"
            enter-from-class="opacity-0 -translate-y-3"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <nav
                v-if="showNav"
                class="fixed top-0 z-50 w-full bg-slate-900/80 backdrop-blur"
            >
                <div
                    class="mx-auto flex max-w-6xl justify-center gap-10 px-6 py-4 text-sm uppercase tracking-[0.2em]"
                >
                    <a href="#home" class="hover:text-[#BD4B4B]">Home</a>
                    <a href="#about" class="hover:text-[#BD4B4B]">About</a>
                    <a href="#projects" class="hover:text-[#BD4B4B]"
                        >Projects</a
                    >
                    <a href="#contact" class="hover:text-[#BD4B4B]">Contact</a>
                </div>
            </nav>
        </transition>

        <!-- Hero -->
        <section
            id="home"
            class="relative isolate flex min-h-screen items-center justify-center overflow-hidden text-center"
        >
            <div class="absolute inset-0 z-0">
                <vue-particles
                    id="tsparticles"
                    :options="options"
                    class="h-full w-full"
                />
            </div>

            <div class="relative z-10 px-6">
                <p class="mb-4 text-xl text-zinc-300">Hello, I'm</p>

                <h1 class="text-6xl font-bold tracking-tight md:text-8xl">
                    Yusuf
                </h1>

                <p class="mt-6 text-xl text-zinc-400 md:text-2xl">
                    Full stack developer building modern web experiences.
                </p>

                <a
                    href="#projects"
                    class="group mt-10 inline-flex items-center bg-zinc-950 px-8 py-4 uppercase tracking-[0.2em] shadow-[12px_12px_0px_#BD4B4B] transition-all duration-200 hover:translate-x-[6px] hover:translate-y-[6px] hover:shadow-[6px_6px_0px_#BD4B4B]"
                >
                    <span>View my work</span>
                    <span
                        class="ml-3 transition-transform duration-200 group-hover:translate-x-1"
                    >
                        →
                    </span>
                </a>
            </div>
        </section>

        <!-- About -->
        <section
            id="about"
            class="relative mx-auto flex max-w-6xl flex-col items-center gap-20 px-6 py-32 lg:flex-row"
        >
            <div class="w-full lg:w-1/2">
                <p
                    class="mb-6 text-sm uppercase tracking-[0.3em] text-zinc-500"
                >
                    About
                </p>

                <h2 class="text-4xl font-bold leading-tight md:text-4xl">
                    A results-driven Software Developer with 5+ years of
                    professional experience delivering data-driven applications.
                </h2>
            </div>

            <div class="h-[420px] w-full lg:w-1/2">
                <div class="mt-20 space-y-6">
                    <div
                        class="mt-20 grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4"
                    >
                        <div
                            v-for="(tech, index) in techStack"
                            :key="tech.name"
                            :class="[
                                'flex h-28 flex-col items-center justify-center border border-white/10 bg-black/30 backdrop-blur-sm transition hover:border-[#BD4B4B]',
                                Math.floor(index / 4) % 2 === 1
                                    ? 'lg:translate-x-6'
                                    : '',
                            ]"
                        >
                            <img
                                :src="tech.icon"
                                :alt="tech.name"
                                class="h-10 w-10 object-contain"
                            />
                            <span
                                class="mt-3 text-xs uppercase tracking-[0.2em] text-zinc-300"
                            >
                                {{ tech.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured project -->
        <section id="projects" class="relative z-10 py-16">
            <div
                class="mx-auto grid max-w-6xl grid-cols-1 items-center gap-20 px-6 lg:grid-cols-2"
            >
                <div class="bg-zinc-950 p-1 shadow-[24px_24px_0px_#BD4B4B]">
                    <img
                        :src="cmsPreview"
                        alt="Project preview"
                        class="w-full"
                    />
                </div>

                <div>
                    <p
                        class="mb-4 text-sm uppercase tracking-[0.3em] text-zinc-400"
                    >
                        Demo
                    </p>

                    <h2 class="text-5xl font-bold leading-tight">
                        Laravel CMS
                    </h2>

                    <p class="mt-8 max-w-xl text-lg text-zinc-400">
                        A demo CMS using Laravel, Inertia (Vue), TailwindCSS.
                        Showcasing real-time features which is prioritised over
                        UI. Login with the following details to preview the
                        basic admin dashboard:
                        <br /><br /><span>Email: viewer@example.com</span>
                        <br /><span>Password: password</span>
                    </p>

                    <div class="mt-10 space-y-6">
                        <a
                            :href="cmsUrl"
                            class="block w-fit border-b-2 border-[#BD4B4B] pb-2 uppercase tracking-[0.2em]"
                        >
                            Live Demo
                        </a>

                        <a
                            href="#"
                            class="block w-fit border-b-2 border-[#BD4B4B] pb-2 uppercase tracking-[0.2em]"
                        >
                            GitHub
                        </a>
                    </div>
                </div>
                <h3 class="text-4xl font-bold mt-20">And more to come...</h3>
            </div>

            <!-- Mini projects -->
            <!-- <div class="mx-auto mt-32 max-w-6xl px-6">
                <h3 class="text-4xl font-bold mt-20">Mini projects</h3>

                <div class="mt-10 grid gap-8 md:grid-cols-2">
                    <div class="bg-zinc-950 p-6 shadow-[14px_14px_0px_#BD4B4B]">
                        <h4 class="text-xl font-semibold">Mini Project 1</h4>
                        <a
                            href="#"
                            class="mt-6 inline-block border-b-2 border-[#BD4B4B] pb-1 uppercase tracking-[0.2em]"
                        >
                            GitHub
                        </a>
                    </div>

                    <div class="bg-zinc-950 p-6 shadow-[14px_14px_0px_#BD4B4B]">
                        <h4 class="text-xl font-semibold">Mini Project 2</h4>
                        <a
                            href="#"
                            class="mt-6 inline-block border-b-2 border-[#BD4B4B] pb-1 uppercase tracking-[0.2em]"
                        >
                            GitHub
                        </a>
                    </div>
                </div>
                <h3 class="text-4xl font-bold mt-20">And more to come...</h3>
            </div> -->
        </section>

        <!-- Contact -->
        <section
            id="contact"
            class="relative z-10 mx-auto max-w-4xl px-6 py-16"
        >
            <p class="mb-6 text-sm uppercase tracking-[0.3em] text-zinc-500">
                Contact
            </p>

            <h2 class="mb-14 text-2xl font-bold md:text-4xl">
                Let's build something great.
            </h2>

            <form @submit.prevent="send" class="space-y-8">
                <input
                    v-model="form.name"
                    type="text"
                    placeholder="Name"
                    class="w-full border border-white/10 bg-black/40 px-5 py-4 text-white placeholder-zinc-500 outline-none transition focus:border-[#BD4B4B] focus:bg-black/60"
                />

                <input
                    v-model="form.email"
                    type="email"
                    placeholder="Email"
                    class="w-full border border-white/10 bg-black/40 px-5 py-4 text-white placeholder-zinc-500 outline-none transition focus:border-[#BD4B4B] focus:bg-black/60"
                />

                <textarea
                    v-model="form.message"
                    rows="6"
                    placeholder="Message"
                    class="w-full border border-white/10 bg-black/40 px-5 py-4 text-white placeholder-zinc-500 outline-none transition focus:border-[#BD4B4B] focus:bg-black/60"
                ></textarea>

                <button
                    type="submit"
                    class="ml-auto block bg-zinc-950 px-8 py-4 uppercase tracking-[0.2em] shadow-[10px_10px_0px_#BD4B4B] transition-all duration-200 hover:translate-x-[5px] hover:translate-y-[5px] hover:shadow-[5px_5px_0px_#BD4B4B]"
                >
                    Send
                </button>
            </form>
        </section>

        <!-- Footer -->
        <footer
            class="relative z-10 px-6 py-12 text-center text-sm text-zinc-500"
        >
            Yusuf Ibrahim © 2026
        </footer>
    </div>
</template>
