<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<style>
.chat-page { background: #FFFBF5; padding: 20px 24px 40px; }
.chat-shell {
    max-width: 900px; margin: 0 auto; background: white;
    border-radius: 24px; box-shadow: 0 20px 60px rgba(15,23,42,.1);
    border: 1px solid #F1F5F9; overflow: hidden;
    display: flex; flex-direction: column;
    height: calc(100vh - 120px); min-height: 550px;
}
.chat-header {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white; padding: 20px 26px;
    display: flex; align-items: center; gap: 14px;
    box-shadow: 0 4px 20px rgba(255,122,0,.3); position: relative;
}
.chat-header::before {
    content: ''; position: absolute; top: -50%; right: -10%;
    width: 250px; height: 250px;
    background: rgba(255,255,255,.1); border-radius: 50%;
}
.chat-header-avatar {
    width: 50px; height: 50px; background: rgba(255,255,255,.2);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 24px; border: 2px solid rgba(255,255,255,.4);
    position: relative; z-index: 2; flex-shrink: 0;
}
.chat-header-info { flex: 1; position: relative; z-index: 2; min-width: 0; }
.chat-header-info h5 { margin: 0; font-size: 17px; font-weight: 800; letter-spacing: -.3px; }
.chat-header-info .status { display: flex; align-items: center; gap: 6px; font-size: 12.5px; opacity: .95; margin-top: 2px; }
.status-dot { width: 8px; height: 8px; background: #4ADE80; border-radius: 50%; animation: chatPulse 2s infinite; }
@keyframes chatPulse { 0%, 100% { opacity: 1; } 50% { opacity: .4; } }
.chat-btn-clear {
    background: rgba(255,255,255,.15); color: white;
    border: 1px solid rgba(255,255,255,.3); padding: 8px 14px;
    border-radius: 10px; cursor: pointer; font-size: 13px; font-weight: 700;
    transition: .2s; position: relative; z-index: 2; font-family: inherit;
    display: flex; align-items: center; gap: 6px;
}
.chat-btn-clear:hover { background: rgba(255,255,255,.25); }

.chat-body {
    flex: 1; overflow-y: auto; padding: 24px; background: #FAFBFC;
}
.chat-body::-webkit-scrollbar { width: 6px; }
.chat-body::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 3px; }

.chat-msg { display: flex; gap: 10px; margin-bottom: 18px; animation: chatFade .3s; }
@keyframes chatFade {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.chat-msg.user { flex-direction: row-reverse; }

.chat-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; font-size: 16px; color: white;
}
.chat-msg.assistant .chat-avatar { background: linear-gradient(135deg, #FF7A00, #E65100); }
.chat-msg.user .chat-avatar { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }

.chat-bubble-wrap { max-width: 78%; display: flex; flex-direction: column; }
.chat-msg.user .chat-bubble-wrap { align-items: flex-end; }

.chat-bubble {
    padding: 12px 18px; border-radius: 18px; line-height: 1.6;
    font-size: 14.5px; word-wrap: break-word; overflow-x: auto;
}
.chat-msg.assistant .chat-bubble {
    background: white; color: #334155; border-bottom-left-radius: 4px;
    box-shadow: 0 2px 8px rgba(15,23,42,.05); border: 1px solid #F1F5F9;
}
.chat-msg.user .chat-bubble {
    background: linear-gradient(135deg, #FF7A00, #E65100); color: white;
    border-bottom-right-radius: 4px; box-shadow: 0 4px 15px rgba(255,122,0,.25);
}
.chat-time { font-size: 11px; color: #94A3B8; margin-top: 5px; padding: 0 6px; }

.chat-bubble h1, .chat-bubble h2, .chat-bubble h3, .chat-bubble h4 {
    font-size: 16px; font-weight: 800; margin: 12px 0 6px; color: #0F172A;
}
.chat-bubble p { margin: 6px 0; }
.chat-bubble ul, .chat-bubble ol { padding-left: 22px; margin: 8px 0; }
.chat-bubble li { margin-bottom: 4px; }
.chat-bubble strong { color: #0F172A; font-weight: 800; }
.chat-bubble em { font-style: italic; color: #64748B; }
.chat-bubble code {
    background: #F4F4F4; padding: 2px 6px; border-radius: 4px;
    font-size: 13px; color: #E83E8C; font-family: 'Courier New', monospace;
}
.chat-bubble pre {
    background: #1E293B; color: #F8F8F2; padding: 12px;
    border-radius: 8px; overflow-x: auto; font-size: 13px; margin: 8px 0;
}
.chat-bubble blockquote {
    border-left: 4px solid #FF7A00; padding-left: 12px;
    margin: 8px 0; color: #64748B; font-style: italic;
}
.chat-bubble table {
    width: 100%; border-collapse: collapse; margin: 12px 0;
    font-size: 13px; background: white; border-radius: 8px; overflow: hidden;
}
.chat-bubble table thead { background: linear-gradient(135deg, #FF7A00, #E65100); color: white; }
.chat-bubble table th {
    padding: 10px 12px; text-align: left; font-weight: 700;
    font-size: 12.5px; white-space: nowrap;
}
.chat-bubble table td { padding: 10px 12px; border-bottom: 1px solid #F1F5F9; color: #334155; }
.chat-bubble table tbody tr:nth-child(even) { background: #FAFBFC; }

.chat-typing { display: flex; gap: 5px; padding: 14px 20px !important; background: white !important; }
.chat-typing-dot {
    width: 8px; height: 8px; background: #FF7A00; border-radius: 50%;
    animation: chatTyping 1.4s infinite;
}
.chat-typing-dot:nth-child(2) { animation-delay: .2s; }
.chat-typing-dot:nth-child(3) { animation-delay: .4s; }
@keyframes chatTyping {
    0%, 60%, 100% { transform: translateY(0); opacity: .5; }
    30% { transform: translateY(-8px); opacity: 1; }
}

.chat-chips {
    padding: 12px 20px; background: white; border-top: 1px solid #F1F5F9;
    display: flex; flex-wrap: wrap; gap: 8px; overflow-x: auto;
}
.chat-chip {
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    color: #E65100; border: 1px solid #FFD180;
    padding: 8px 16px; border-radius: 50px; font-size: 13px;
    cursor: pointer; transition: .2s; white-space: nowrap;
    user-select: none; font-weight: 600;
}
.chat-chip:hover {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white; border-color: transparent;
    transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255,122,0,.3);
}

.chat-input-area {
    padding: 14px 20px; background: white; border-top: 1px solid #F1F5F9;
    display: flex; gap: 10px; align-items: center;
}
.chat-input-area input {
    flex: 1; border: 2px solid #F1F5F9; border-radius: 50px;
    padding: 13px 22px; outline: none; font-size: 14.5px;
    background: #FAFBFC; transition: .2s; font-family: inherit; min-width: 0;
}
.chat-input-area input:focus {
    border-color: #FF7A00; background: white;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.chat-btn-send {
    background: linear-gradient(135deg, #FF7A00, #E65100); color: white;
    border: none; width: 48px; height: 48px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; cursor: pointer; transition: .25s;
    flex-shrink: 0; box-shadow: 0 6px 18px rgba(255,122,0,.35);
}
.chat-btn-send:hover:not(:disabled) {
    transform: scale(1.08); box-shadow: 0 10px 25px rgba(255,122,0,.5);
}
.chat-btn-send:disabled { opacity: .5; cursor: not-allowed; }

.chat-welcome { text-align: center; color: #94A3B8; font-size: 12px; margin: 10px 0 20px; }
.chat-welcome span {
    background: white; padding: 6px 16px; border-radius: 50px;
    box-shadow: 0 2px 8px rgba(15,23,42,.04);
    display: inline-flex; align-items: center; gap: 6px;
}

@media (max-width: 768px) {
    .chat-page { padding: 0 8px 10px; }
    .chat-shell { border-radius: 16px; height: calc(100vh - 80px); }
    .chat-header { padding: 14px 16px; }
    .chat-header-info h5 { font-size: 15px; }
    .chat-header-avatar { width: 44px; height: 44px; font-size: 20px; }
    .chat-body { padding: 16px; }
    .chat-bubble-wrap { max-width: 88%; }
    .chat-bubble { font-size: 14px; padding: 10px 14px; }
    .chat-bubble table { font-size: 11px; }
    .chat-bubble table th, .chat-bubble table td { padding: 6px 8px; }
    .chat-chips { padding: 10px 14px; }
    .chat-chip { font-size: 12px; padding: 6px 12px; }
    .chat-input-area { padding: 10px 14px; }
    .chat-input-area input { padding: 11px 18px; font-size: 14px; }
    .chat-btn-send { width: 44px; height: 44px; font-size: 16px; }
}
</style>

<div class="chat-page">
    <div class="chat-shell">

        <div class="chat-header">
            <div class="chat-header-avatar"><i class="bi bi-robot"></i></div>
            <div class="chat-header-info">
                <h5>EventNela AI</h5>
                <div class="status">
                    <span class="status-dot"></span>
                    <span>Online 24/7</span>
                </div>
            </div>
            <button class="chat-btn-clear" onclick="chatClear()">
                <i class="bi bi-trash"></i> Hapus
            </button>
        </div>

        <div class="chat-body" id="chatBody">
            <div class="chat-welcome">
                <span><i class="bi bi-shield-check"></i> Percakapan ini bersifat privat</span>
            </div>

            <div class="chat-msg assistant">
                <div class="chat-avatar"><i class="bi bi-robot"></i></div>
                <div class="chat-bubble-wrap">
                    <div class="chat-bubble">
                        Halo! 👋 Saya EventNela AI, asisten virtual EventNela.<br><br>
                        Saya bisa membantu kamu:<br>
                        • 📊 Analisis UKM/Ormawa paling aktif<br>
                        • ⭐ Info event & rating<br>
                        • 💡 Rekomendasi kegiatan<br>
                        • 📢 Info open recruitment<br>
                        • 🏢 Info gedung & jadwal<br><br>
                        Silakan tanya apa saja! 🚀
                    </div>
                    <div class="chat-time">Sekarang</div>
                </div>
            </div>

            <?php if (!empty($history)): ?>
                <?php foreach ($history as $h): ?>
                    <div class="chat-msg <?= $h['role'] ?>">
                        <div class="chat-avatar">
                            <i class="bi bi-<?= $h['role'] === 'user' ? 'person-fill' : 'robot' ?>"></i>
                        </div>
                        <div class="chat-bubble-wrap">
                            <div class="chat-bubble"
                                 data-role="<?= $h['role'] ?>"
                                 data-message="<?= htmlspecialchars($h['message'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= esc($h['message']) ?>
                            </div>
                            <div class="chat-time"><?= date('H:i', strtotime($h['created_at'])) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="chat-chips">
            <span class="chat-chip" onclick="chatQuick('UKM apa yang paling aktif?')">📊 UKM paling aktif?</span>
            <span class="chat-chip" onclick="chatQuick('Event dengan rating tertinggi?')">⭐ Event rating tertinggi?</span>
            <span class="chat-chip" onclick="chatQuick('Rekomendasi event untuk semester depan?')">💡 Rekomendasi event?</span>
            <span class="chat-chip" onclick="chatQuick('Info open recruitment yang sedang buka?')">📢 Recruitment aktif?</span>
            <span class="chat-chip" onclick="chatQuick('Gedung apa saja yang ada di Polinela?')">🏢 Info gedung?</span>
        </div>

        <div class="chat-input-area">
            <input type="text" id="chatInput" placeholder="Ketik pertanyaan kamu di sini..." autocomplete="off">
            <button id="chatSend" class="chat-btn-send" onclick="chatKirim()">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const chatSessionId = '<?= $session_id ?>';
const chatBody = document.getElementById('chatBody');
const chatInput = document.getElementById('chatInput');
const chatSend = document.getElementById('chatSend');

// URL fetch RELATIF — otomatis cocok di localhost & ngrok
const chatAskUrl   = '<?= parse_url(base_url('chatbot/ask'), PHP_URL_PATH) ?>';
const chatClearUrl = '<?= parse_url(base_url('chatbot/clear'), PHP_URL_PATH) ?>';

marked.setOptions({ breaks: true, gfm: true });

function chatScroll() {
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: 'smooth' });
}

function chatTime() {
    const now = new Date();
    return String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
}

function chatAddMessage(role, text) {
    const div = document.createElement('div');
    div.className = 'chat-msg ' + role;
    const icon = role === 'user' ? 'person-fill' : 'robot';

    let formatted;
    if (role === 'assistant') {
        formatted = marked.parse(text);
    } else {
        formatted = text
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\n/g, '<br>');
    }

    div.innerHTML = `
        <div class="chat-avatar"><i class="bi bi-${icon}"></i></div>
        <div class="chat-bubble-wrap">
            <div class="chat-bubble">${formatted}</div>
            <div class="chat-time">${chatTime()}</div>
        </div>
    `;
    chatBody.appendChild(div);
    chatScroll();
}

function chatShowTyping() {
    const div = document.createElement('div');
    div.className = 'chat-msg assistant';
    div.id = 'chatTyping';
    div.innerHTML = `
        <div class="chat-avatar"><i class="bi bi-robot"></i></div>
        <div class="chat-bubble-wrap">
            <div class="chat-bubble chat-typing">
                <span class="chat-typing-dot"></span>
                <span class="chat-typing-dot"></span>
                <span class="chat-typing-dot"></span>
            </div>
        </div>
    `;
    chatBody.appendChild(div);
    chatScroll();
}

function chatRemoveTyping() {
    document.getElementById('chatTyping')?.remove();
}

async function chatKirim() {
    const pertanyaan = chatInput.value.trim();
    if (!pertanyaan) return;

    chatAddMessage('user', pertanyaan);
    chatInput.value = '';
    chatSend.disabled = true;
    chatShowTyping();

    try {
        const fd = new FormData();
        fd.append('pertanyaan', pertanyaan);
        fd.append('session_id', chatSessionId);

        const res = await fetch(chatAskUrl, {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });

        const data = await res.json();
        chatRemoveTyping();

        if (data.status === 'success') {
            chatAddMessage('assistant', data.jawaban);
        } else {
            chatAddMessage('assistant', 'Maaf, terjadi kesalahan: ' + (data.message || 'Unknown'));
        }
    } catch (err) {
        chatRemoveTyping();
        console.error('Chat error:', err);
        chatAddMessage('assistant', 'Maaf, koneksi gagal. Coba lagi ya.');
    }

    chatSend.disabled = false;
    chatInput.focus();
}

function chatQuick(text) {
    chatInput.value = text;
    chatKirim();
}

async function chatClear() {
    if (!confirm('Hapus semua percakapan?')) return;

    const fd = new FormData();
    fd.append('session_id', chatSessionId);

    await fetch(chatClearUrl, {
        method: 'POST',
        body: fd
    });

    location.reload();
}

chatInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        chatKirim();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.chat-bubble[data-role="assistant"]').forEach(function(el) {
        const msg = el.getAttribute('data-message');
        if (msg) el.innerHTML = marked.parse(msg);
    });
    chatScroll();
    chatInput.focus();
});
</script>
<?= $this->endSection() ?>