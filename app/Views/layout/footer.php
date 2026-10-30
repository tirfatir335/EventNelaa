<footer class="pub-footer">
    <div class="pub-footer-inner">

        <div class="pub-footer-grid">
            <div>
                <div class="brand">
                    <img src="<?= base_url('assets/images/logo eventnela.png') ?>" alt="EventNela">
                </div>
                <p style="max-width: 340px;">
                    Pusat informasi UKM, Ormawa, event, dan open recruitment Politeknik Negeri Lampung.
                </p>
                <div style="margin-top: 18px; display: flex; gap: 10px;">
                    <a href="https://www.instagram.com/politeknik_negeri_lampung" target="_blank"
                       style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,.08);
                              display: flex; align-items: center; justify-content: center; color: white; font-size: 16px;">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="https://polinela.ac.id" target="_blank"
                       style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,.08);
                              display: flex; align-items: center; justify-content: center; color: white; font-size: 16px;">
                        <i class="bi bi-globe"></i>
                    </a>
                    <a href="mailto:info@polinela.ac.id"
                       style="width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,.08);
                              display: flex; align-items: center; justify-content: center; color: white; font-size: 16px;">
                        <i class="bi bi-envelope-fill"></i>
                    </a>
                </div>
            </div>

            <div>
                <h5>Jelajahi</h5>
                <ul>
                    <li><a href="<?= base_url('event') ?>">Event Kampus</a></li>
                    <li><a href="<?= base_url('ukm') ?>">UKM & Ormawa</a></li>
                    <li><a href="<?= base_url('berita') ?>">Berita</a></li>
                    <li><a href="<?= base_url('recruitment') ?>">Open Recruitment</a></li>
                </ul>
            </div>

            <div>
                <h5>Bantuan</h5>
                <ul>
                    <li><a href="<?= base_url('panduan') ?>">Panduan</a></li>
                    <li><a href="<?= base_url('tentang') ?>">Tentang EventNela</a></li>
                    <li><a href="<?= base_url('chatbot') ?>">Tanya AI</a></li>
                </ul>
            </div>

            <div>
                <h5>Kontak</h5>
                <ul>
                    <li>
                        <i class="bi bi-geo-alt-fill" style="color: var(--pub-primary);"></i>
                        Jl. Soekarno Hatta No.10, Rajabasa
                    </li>
                    <li>
                        <i class="bi bi-telephone-fill" style="color: var(--pub-primary);"></i>
                        (0721) 703-995
                    </li>
                    <li>
                        <i class="bi bi-envelope-fill" style="color: var(--pub-primary);"></i>
                        info@polinela.ac.id
                    </li>
                </ul>
            </div>
        </div>

        <div class="pub-footer-bottom">
            © <?= date('Y') ?> EventNela — Politeknik Negeri Lampung
        </div>
    </div>
</footer>