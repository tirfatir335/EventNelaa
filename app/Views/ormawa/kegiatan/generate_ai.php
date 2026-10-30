<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<style>
.chat-wrap {
    max-width: 780px;
    margin: 0 auto;
    background: white;
    border-radius: var(--en-r-lg);
    box-shadow: var(--en-sh-md);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: calc(100vh - 180px);
    min-height: 500px;
}
.chat-header {
    background: var(--en-grad-primary);
    color: white;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.chat-header .avatar {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    border: 2px solid rgba(255,255,255,0.3);
}
.chat-body {
    flex: 1;
    overflow-y: auto;
    padding: 24px;
    background: var(--en-bg-alt);
}
.msg { display: flex; gap: 10px; margin-bottom: 18px; }
.msg.user { flex-direction: row-reverse; }
.msg-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    color: white;
    font-size: 16px;
}
.msg.assistant .msg-avatar { background: var(--en-grad-primary); }
.msg.user .msg-avatar { background: linear-gradient(135deg, #3B82F6, #1D4ED8); }
.msg-bubble {
    max-width: 78%;
    padding: 12px 18px;
    border-radius: 16px;
    font-size: 14.5px;
    line-height: 1.6;
}
.msg.assistant .msg-bubble {
    background: white;
    border: 1px solid var(--en-border);
    border-bottom-left-radius: 4px;
}
.msg.user .msg-bubble {
    background: var(--en-grad-primary);
    color: white;
    border-bottom-right-radius: 4px;
}
.chat-input-area {
    padding: 16px 20px;
    background: white;
    border-top: 1px solid var(--en-border);
}
.chat-input-row {
    display: flex;
    gap: 10px;
}
.chat-input-row input {
    flex: 1;
    height: 46px;
    border: 2px solid var(--en-border-strong);
    border-radius: var(--en-r-pill);
    padding: 0 20px;
    font-size: 14px;
    outline: none;
    transition: .2s;
}
.chat-input-row input:focus {
    border-color: var(--en-primary);
    box-shadow: 0 0 0 4px var(--en-primary-glow);
}
.chat-input-row button {
    width: 46px; height: 46px;
    border-radius: 50%;
    background: var(--en-grad-primary);
    color: white;
    border: none;
    font-size: 18px;
    cursor: pointer;
    flex-shrink: 0;
    box-shadow: var(--en-sh-brand);
}
.chat-input-row button:disabled { opacity: .5; cursor: not-allowed; }
.typing-bubble {
    display: flex; align-items: center; gap: 5px; padding: 14px 20px;
}
.typing-dot {
    width: 8px; height: 8px;
    background: var(--en-primary);
    border-radius: 50%;
    animation: typeAnim 1.4s infinite;
}
.typing-dot:nth-child(2) { animation-delay: .2s; }
.typing-dot:nth-child(3) { animation-delay: .4s; }
@keyframes typeAnim {
    0%, 60%, 100% { transform: translateY(0); opacity: .5; }
    30% { transform: translateY(-8px); opacity: 1; }
}
.result-card {
    background: white;
    border-radius: var(--en-r);
    padding: 20px;
    border: 2px solid var(--en-primary-light);
    margin-top: 12px;
}
.result-card h5 {
    font-size: 16px;
    font-weight: 800;
    color: var(--en-dark);
    margin: 0 0 12px;
}
</style>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-robot me-2" style="color: var(--en-primary);"></i> Generate Event dengan AI</h3>
            <p>Ceritakan event kamu, AI akan mengisi form otomatis</p>
        </div>
        <a href="<?= site_url('ormawa/kegiatan/tambah') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Isi Manual
        </a>
    </div>
</div>

<div class="chat-wrap">
    <div class="chat-header">
        <div class="avatar"><i class="bi bi-robot"></i></div>
        <div style="flex: 1;">
            <strong style="font-size: 16px;">EventNela AI</strong>
            <div style="font-size: 12px; opacity: .9;">Konsultan Event Kampus</div>
        </div>
    </div>

    <div class="chat-body" id="chatBody"></div>

    <div class="chat-input-area">
        <div class="chat-input-row">
            <input type="text" id="chatInput" placeholder="Ceritakan event yang mau kamu bikin..." autocomplete="off">
            <button type="button" id="sendBtn"><i class="bi bi-send-fill"></i></button>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let history = [];
let isSending = false;

const chatBody  = document.getElementById('chatBody');
const chatInput = document.getElementById('chatInput');
const sendBtn   = document.getElementById('sendBtn');

// === Helper: ekstrak reply dari teks yang mungkin JSON ===
function extractReply(text) {
    if (typeof text !== 'string') return { reply: text, status: null, form_data: null };
    
    const trimmed = text.trim();
    if (!trimmed.startsWith('{')) {
        return { reply: text, status: null, form_data: null };
    }
    
    try {
        const parsed = JSON.parse(trimmed);
        if (parsed && parsed.reply) {
            return {
                reply: parsed.reply,
                status: parsed.status || null,
                form_data: parsed.form_data || null
            };
        }
    } catch (e) {
        // Bukan JSON valid, coba ekstrak dengan regex
        const match = trimmed.match(/"reply"\s*:\s*"([^"]+)"/);
        if (match && match[1]) {
            return { reply: match[1], status: null, form_data: null };
        }
    }
    
    return { reply: text, status: null, form_data: null };
}

function addMessage(role, text, extraHtml = '') {
    const div = document.createElement('div');
    div.className = 'msg ' + role;
    const icon = role === 'user' ? 'person-fill' : 'robot';
    const formatted = String(text).replace(/\n/g, '<br>');
    div.innerHTML = `
        <div class="msg-avatar"><i class="bi bi-${icon}"></i></div>
        <div class="msg-bubble">${formatted}${extraHtml}</div>
    `;
    chatBody.appendChild(div);
    chatBody.scrollTop = chatBody.scrollHeight;
}

function showTyping() {
    const div = document.createElement('div');
    div.className = 'msg assistant';
    div.id = 'typing';
    div.innerHTML = `
        <div class="msg-avatar"><i class="bi bi-robot"></i></div>
        <div class="msg-bubble typing-bubble">
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
        </div>
    `;
    chatBody.appendChild(div);
    chatBody.scrollTop = chatBody.scrollHeight;
}

function removeTyping() {
    document.getElementById('typing')?.remove();
}

function renderResultCard(formData) {
    const rundown = (formData.rundown || []).map(r => `<li>${r}</li>`).join('');
    return `
        <div class="result-card">
            <h5>🎉 ${formData.nama_event || 'Rencana Event'}</h5>
            <div style="display: flex; flex-wrap: wrap; gap: 12px; font-size: 12px; color: var(--en-muted); margin-bottom: 12px;">
                <span><i class="bi bi-calendar3"></i> ${formData.tanggal || '-'}</span>
                <span><i class="bi bi-clock-fill"></i> ${formData.waktu || '-'} WIB</span>
                <span><i class="bi bi-geo-alt-fill"></i> ${formData.gedung || '-'}</span>
            </div>
            <div style="font-size: 13px; color: var(--en-text); line-height: 1.7; margin-bottom: 12px;">
                ${formData.deskripsi || '-'}
            </div>
            ${rundown ? `<ul style="font-size: 13px; color: var(--en-text); padding-left: 20px;">${rundown}</ul>` : ''}
            <a href="<?= site_url('ormawa/kegiatan/tambah') ?>" class="en-btn en-btn-primary" style="margin-top: 10px;">
                <i class="bi bi-check-circle-fill"></i> Setuju, Lanjut Isi Form
            </a>
        </div>
    `;
}

async function sendMessage(text) {
    if (isSending) return;
    text = text.trim();
    if (!text) return;

    isSending = true;
    sendBtn.disabled = true;

    addMessage('user', text);
    history.push({ role: 'user', content: text });
    chatInput.value = '';
    showTyping();

    try {
        const res = await fetch('<?= parse_url(site_url('ormawa/kegiatan/chat-ai'), PHP_URL_PATH) ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ history: history.slice(-12) })
        });
        const data = await res.json();
        removeTyping();

        if (data.status === 'error') {
            addMessage('assistant', '❌ ' + (data.message || 'Terjadi kesalahan.'));
        } else {
            // Ekstrak reply — handle kalau reply-nya sendiri berisi JSON
            const extracted = extractReply(data.reply || '');
            const finalReply = extracted.reply;
            const finalStatus = extracted.status || data.status;
            const finalFormData = extracted.form_data || data.form_data;

            history.push({ role: 'assistant', content: finalReply });

            if (finalStatus === 'ready') {
                addMessage('assistant', finalReply || 'Event siap!', renderResultCard(finalFormData || {}));
                sessionStorage.setItem('ai_result', JSON.stringify(finalFormData || {}));
            } else {
                addMessage('assistant', finalReply || '...');
            }
        }
    } catch (err) {
        removeTyping();
        addMessage('assistant', '❌ Koneksi gagal. Coba lagi.');
    }

    isSending = false;
    sendBtn.disabled = false;
    chatInput.focus();
}

sendBtn.addEventListener('click', () => sendMessage(chatInput.value));
chatInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') { e.preventDefault(); sendMessage(chatInput.value); }
});

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const opening = 'Halo! 👋 Aku EventNela AI.\n\nCeritakan dong event apa yang mau kamu bikin. Bebas, nggak usah pakai format. Nanti aku yang tanya detailnya satu-satu.';
        addMessage('assistant', opening);
        history.push({ role: 'assistant', content: opening });
        chatInput.focus();
    }, 300);
});
</script>
<?= $this->endSection() ?>