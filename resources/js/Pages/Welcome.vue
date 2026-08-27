<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const navItems = [
    { label: 'Alur Kerja', href: '#alur' },
    { label: 'Fitur', href: '#fitur' },
    { label: 'Data Prestasi', href: '#data' },
    { label: 'FAQ', href: '#faq' },
];

const alur = [
    {
        no: '01',
        title: 'Mengajukan prestasi',
        desc: 'Siswa mengisi data prestasi dan mengunggah sertifikat serta dokumentasi foto sebagai bukti pencapaian.',
    },
    {
        no: '02',
        title: 'Memverifikasi data',
        desc: 'Pihak kesiswaan memeriksa kelengkapan bukti, lalu menyetujui atau menolak lengkap dengan catatan.',
    },
    {
        no: '03',
        title: 'Memindai portofolio',
        desc: 'Siapa saja dapat membuka portofolio siswa lewat QR Code dan mengunduh versi PDF-nya.',
    },
];

const fitur = [
    {
        icon: 'upload',
        title: 'Pengajuan Digital',
        desc: 'Form pengajuan prestasi lengkap dengan unggah sertifikat dan dokumentasi, tanpa berkas fisik.',
    },
    {
        icon: 'check',
        title: 'Verifikasi Kesiswaan',
        desc: 'Setiap pengajuan diperiksa dan dikategorikan oleh pihak sekolah sebelum resmi tercatat.',
    },
    {
        icon: 'qr',
        title: 'Portofolio via QR',
        desc: 'Setiap siswa punya QR Code unik menuju portofolio publik, bisa diunduh sebagai PDF.',
    },
    {
        icon: 'chart',
        title: 'Statistik Sekolah',
        desc: 'Rekap dan leaderboard prestasi siswa untuk kebutuhan laporan dan akreditasi sekolah.',
    },
];

const faqs = ref([
    {
        q: 'Bagaimana cara membuat akun?',
        a: 'Akun dibuat oleh admin sekolah untuk siswa dan pihak kesiswaan. Siswa dan kesiswaan tidak bisa mendaftar sendiri.',
        open: true,
    },
    {
        q: 'Bagaimana cara mengajukan prestasi?',
        a: 'Siswa login, mengisi data prestasi (nama, penyelenggara, tingkat, tanggal), lalu mengunggah sertifikat dan foto dokumentasi. Setelah itu, statusnya menunggu verifikasi kesiswaan.',
        open: false,
    },
    {
        q: 'Apa yang terjadi jika prestasi ditolak?',
        a: 'Pihak kesiswaan akan menyertakan catatan alasan penolakan, sehingga siswa tahu apa yang perlu diperbaiki atau dilengkapi.',
        open: false,
    },
    {
        q: 'Bagaimana orang lain bisa melihat portofolio saya?',
        a: 'Setiap siswa punya QR Code unik yang mengarah ke halaman portofolio publik, lengkap dengan opsi unduh versi PDF, tanpa perlu login.',
        open: false,
    },
]);

function toggleFaq(i) {
    faqs.value[i].open = !faqs.value[i].open;
}
</script>

<template>
    <Head title="Informasi Prestasi Siswa" />

    <div class="bg-[#FAF7F0] text-[#0B1E38]">
        <!-- NAV -->
        <header class="sticky top-0 z-30 bg-[#0B1E38]/95 backdrop-blur border-b border-white/10">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-full bg-[#C9A227] flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 2L14.5 8.5L21 9L16 13.5L17.5 20L12 16.5L6.5 20L8 13.5L3 9L9.5 8.5L12 2Z" fill="#0B1E38"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="font-display text-sm font-semibold text-white">E-Prestasi</p>
                        <p class="text-[11px] text-white/40">Sistem Informasi Prestasi Siswa</p>
                    </div>
                </div>

                <nav class="hidden md:flex items-center gap-7">
                    <a v-for="item in navItems" :key="item.href" :href="item.href"
                       class="text-sm text-white/70 hover:text-white transition">
                        {{ item.label }}
                    </a>
                </nav>

                <Link :href="route('login')"
                      class="text-sm font-semibold bg-[#C9A227] text-[#0B1E38] px-5 py-2.5 rounded-full hover:brightness-110 transition">
                    Masuk ke Sistem
                </Link>
            </div>
        </header>

        <!-- HERO -->
        <section class="relative overflow-hidden bg-[#0B1E38]">
            <div class="absolute left-1/2 top-0 -translate-x-1/2 w-[800px] h-[500px] bg-[#C9A227]/10 rounded-full blur-[120px] pointer-events-none"></div>

            <div class="max-w-6xl mx-auto px-6 pt-20 pb-28 grid lg:grid-cols-[1.1fr_0.9fr] gap-16 items-center relative">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/5 border border-white/10 rounded-full px-3.5 py-1.5 mb-6">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4ADE80]"></span>
                        <span class="text-xs font-medium text-white/70">Layanan digital sekolah</span>
                    </div>

                    <h1 class="font-display text-4xl lg:text-5xl font-semibold text-white leading-[1.15] mb-6">
                        Setiap prestasi siswa,<br>
                        <span class="text-[#C9A227]">tercatat &amp; terverifikasi resmi.</span>
                    </h1>

                    <p class="text-white/60 text-lg leading-relaxed mb-9 max-w-lg">
                        E-Prestasi mengganti tumpukan sertifikat fisik dengan portofolio digital yang diperiksa langsung oleh pihak sekolah — siap dibagikan lewat satu pindai QR Code.
                    </p>

                    <div class="flex flex-wrap items-center gap-4">
                        <a href="#alur" class="text-sm font-semibold bg-[#C9A227] text-[#0B1E38] px-6 py-3.5 rounded-full hover:brightness-110 transition">
                            Lihat cara kerjanya
                        </a>
                        <a href="#fitur" class="text-sm font-semibold text-white/80 hover:text-white px-6 py-3.5 rounded-full border border-white/15 hover:border-white/30 transition">
                            Jelajahi fitur
                        </a>
                    </div>
                </div>

                <!-- Signature element: rotating seal + portfolio card mock -->
                <div class="relative flex items-center justify-center">
                    <svg class="absolute w-56 h-56 animate-[spin_28s_linear_infinite] text-[#C9A227]/70" viewBox="0 0 200 200">
                        <path id="sealCircle" fill="none" d="M 100,100 m -80,0 a 80,80 0 1,1 160,0 a 80,80 0 1,1 -160,0" />
                        <text font-size="11.5" letter-spacing="3" fill="currentColor" font-family="Space Grotesk, sans-serif">
                            <textPath href="#sealCircle">
                                • TERVERIFIKASI RESMI • E-PRESTASI • TERVERIFIKASI RESMI •
                            </textPath>
                        </text>
                    </svg>

                    <div class="relative bg-white rounded-2xl shadow-2xl shadow-black/40 p-6 w-72 border border-black/5">
                        <div class="flex items-center justify-between mb-4">
                            <p class="text-xs text-[#0B1E38]/40 font-medium">Portofolio Siswa</p>
                            <span class="text-[10px] font-semibold bg-[#4ADE80]/15 text-[#16803C] px-2 py-0.5 rounded-full">Disetujui</span>
                        </div>
                        <p class="font-display font-semibold text-[#0B1E38] mb-1">Juara 1 LKS Web Design</p>
                        <p class="text-xs text-[#0B1E38]/50 mb-4">Tingkat Provinsi &middot; XII RPL 2</p>
                        <div class="h-px bg-[#0B1E38]/10 mb-4"></div>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-[#0B1E38] flex items-center justify-center shrink-0">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                    <rect x="3" y="3" width="7" height="7" stroke="#C9A227" stroke-width="1.5"/>
                                    <rect x="14" y="3" width="7" height="7" stroke="#C9A227" stroke-width="1.5"/>
                                    <rect x="3" y="14" width="7" height="7" stroke="#C9A227" stroke-width="1.5"/>
                                </svg>
                            </div>
                            <p class="text-[11px] text-[#0B1E38]/50 leading-snug">Pindai untuk membuka portofolio lengkap</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ALUR KERJA -->
        <section id="alur" class="max-w-6xl mx-auto px-6 py-24 scroll-mt-20">
            <div class="max-w-xl mb-14">
                <p class="text-xs font-semibold tracking-widest text-[#C9A227] mb-3">ALUR KERJA</p>
                <h2 class="font-display text-3xl font-semibold mb-4">Tiga peran, satu alur yang jelas</h2>
                <p class="text-[#0B1E38]/60 leading-relaxed">Dari pengajuan siswa sampai portofolio siap dibagikan, setiap langkah tercatat dan dapat dipertanggungjawabkan.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div v-for="step in alur" :key="step.no"
                     class="bg-white rounded-2xl p-7 border border-[#0B1E38]/8 hover:border-[#C9A227]/40 hover:-translate-y-1 transition-all duration-300">
                    <p class="font-display text-3xl font-semibold text-[#0B1E38]/15 mb-5">{{ step.no }}</p>
                    <h3 class="font-display font-semibold text-lg mb-2.5">{{ step.title }}</h3>
                    <p class="text-sm text-[#0B1E38]/60 leading-relaxed">{{ step.desc }}</p>
                </div>
            </div>
        </section>

        <!-- FITUR -->
        <section id="fitur" class="bg-white border-y border-[#0B1E38]/8 scroll-mt-20">
            <div class="max-w-6xl mx-auto px-6 py-24">
                <div class="max-w-xl mb-14">
                    <p class="text-xs font-semibold tracking-widest text-[#C9A227] mb-3">FITUR</p>
                    <h2 class="font-display text-3xl font-semibold mb-4">Semua yang dibutuhkan, dalam satu sistem</h2>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div v-for="f in fitur" :key="f.title"
                         class="flex gap-4 p-6 rounded-2xl bg-[#FAF7F0] border border-[#0B1E38]/6">
                        <div class="w-11 h-11 shrink-0 rounded-xl bg-[#0B1E38] flex items-center justify-center">
                            <svg v-if="f.icon === 'upload'" width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 16V4M12 4L7 9M12 4L17 9" stroke="#C9A227" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 16V18C4 19.1 4.9 20 6 20H18C19.1 20 20 19.1 20 18V16" stroke="#C9A227" stroke-width="1.7" stroke-linecap="round"/></svg>
                            <svg v-else-if="f.icon === 'check'" width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="#C9A227" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <svg v-else-if="f.icon === 'qr'" width="18" height="18" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" stroke="#C9A227" stroke-width="1.7"/><rect x="14" y="3" width="7" height="7" stroke="#C9A227" stroke-width="1.7"/><rect x="3" y="14" width="7" height="7" stroke="#C9A227" stroke-width="1.7"/></svg>
                            <svg v-else width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 20V10M12 20V4M20 20V14" stroke="#C9A227" stroke-width="1.7" stroke-linecap="round"/></svg>
                        </div>
                        <div>
                            <h3 class="font-display font-semibold mb-1.5">{{ f.title }}</h3>
                            <p class="text-sm text-[#0B1E38]/60 leading-relaxed">{{ f.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- DATA / KATEGORI -->
        <section id="data" class="max-w-6xl mx-auto px-6 py-24 scroll-mt-20">
            <div class="max-w-xl mb-14">
                <p class="text-xs font-semibold tracking-widest text-[#C9A227] mb-3">CAKUPAN DATA</p>
                <h2 class="font-display text-3xl font-semibold mb-4">Tingkat &amp; kategori prestasi yang tercatat</h2>
                <p class="text-[#0B1E38]/60 leading-relaxed">Setiap prestasi dicatat lengkap dengan jenjang kompetisi dan kategorinya setelah diverifikasi kesiswaan.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-[#0B1E38] rounded-2xl p-8">
                    <p class="text-xs font-semibold tracking-widest text-[#C9A227] mb-5">TINGKAT KOMPETISI</p>
                    <ul class="space-y-3">
                        <li v-for="t in ['Sekolah', 'Kabupaten / Kota', 'Provinsi', 'Nasional', 'Internasional']" :key="t"
                            class="flex items-center gap-3 text-white/80 text-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#C9A227] shrink-0"></span>{{ t }}
                        </li>
                    </ul>
                </div>
                <div class="bg-white rounded-2xl p-8 border border-[#0B1E38]/8">
                    <p class="text-xs font-semibold tracking-widest text-[#C9A227] mb-2">KATEGORI PRESTASI</p>
                    <p class="text-sm text-[#0B1E38]/50 mb-5">Ditentukan pihak kesiswaan saat prestasi disetujui, sesuai bukti yang dilampirkan siswa.</p>
                    <ul class="space-y-3">
                        <li v-for="k in ['Akademik', 'Non-Akademik', 'Kejuaraan']" :key="k"
                            class="flex items-center gap-3 text-[#0B1E38]/80 text-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#0B1E38] shrink-0"></span>{{ k }}
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- WHY -->
        <section class="bg-[#0B1E38]">
            <div class="max-w-6xl mx-auto px-6 py-24">
                <p class="text-xs font-semibold tracking-widest text-[#C9A227] mb-3">KENAPA PAKAI E-PRESTASI</p>
                <div class="grid md:grid-cols-3 gap-8 mt-8">
                    <div v-for="w in [
                        { t: 'Terverifikasi resmi', d: 'Setiap prestasi diperiksa langsung oleh kesiswaan sebelum tercatat, jadi datanya bisa dipertanggungjawabkan.' },
                        { t: 'Tanpa berkas fisik', d: 'Sertifikat dan dokumentasi diunggah langsung ke sistem, tidak perlu bolak-balik cetak dan menyerahkan berkas.' },
                        { t: 'Portofolio siap bagi', d: 'Portofolio siswa bisa dibagikan lewat QR Code dan dilihat siapa saja tanpa perlu login ke sistem.' },
                    ]" :key="w.t">
                        <h3 class="font-display text-white font-semibold text-lg mb-2.5">{{ w.t }}</h3>
                        <p class="text-sm text-white/50 leading-relaxed">{{ w.d }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FAQ -->
        <section id="faq" class="max-w-3xl mx-auto px-6 py-24 scroll-mt-20">
            <p class="text-xs font-semibold tracking-widest text-[#C9A227] mb-3">FAQ</p>
            <h2 class="font-display text-3xl font-semibold mb-10">Pertanyaan yang sering ditanyakan</h2>

            <div class="space-y-3">
                <div v-for="(f, i) in faqs" :key="f.q" class="bg-white rounded-xl border border-[#0B1E38]/8 overflow-hidden">
                    <button @click="toggleFaq(i)" class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
                        <span class="font-medium text-sm">{{ f.q }}</span>
                        <span class="text-[#C9A227] text-xl leading-none shrink-0">{{ f.open ? '−' : '+' }}</span>
                    </button>
                    <div v-show="f.open" class="px-6 pb-5 text-sm text-[#0B1E38]/60 leading-relaxed">
                        {{ f.a }}
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA / FOOTER -->
        <footer class="bg-[#0B1E38] border-t border-white/10">
            <div class="max-w-6xl mx-auto px-6 py-16 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <p class="font-display text-white font-semibold mb-1">E-Prestasi</p>
                    <p class="text-sm text-white/40">Sistem Informasi Prestasi Siswa</p>
                </div>
                <Link :href="route('login')"
                      class="text-sm font-semibold bg-[#C9A227] text-[#0B1E38] px-6 py-3 rounded-full hover:brightness-110 transition">
                    Masuk ke Sistem
                </Link>
            </div>
        </footer>
    </div>
</template>
