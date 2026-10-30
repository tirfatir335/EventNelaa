<?php

namespace App\Controllers;

use App\Models\ChatModel;
use App\Services\AIService;

class Chatbot extends BaseController
{
    protected $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    public function index()
    {
        $session_id = session()->get('chat_session_id');
        if (!$session_id) {
            $session_id = 'chat_' . uniqid() . '_' . time();
            session()->set('chat_session_id', $session_id);
        }

        return view('chatbot/index', [
            'title'        => 'EventNela AI',
            'history'      => $this->chatModel->getHistory($session_id),
            'session_id'   => $session_id,
            'current_page' => 'chatbot'
        ]);
    }

    public function ask()
{
    $pertanyaan = $this->request->getPost('pertanyaan');
    $session_id = $this->request->getPost('session_id');

    if (empty($pertanyaan) || empty($session_id)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Pertanyaan kosong.']);
    }

    $id_user = session()->get('user_id') ?? null;
    
    // 1. Simpan pertanyaan user
    $this->chatModel->simpanPesan($session_id, 'user', $pertanyaan, $id_user);

    // 2. AMBIL HISTORY PERCAKAPAN (10 pesan terakhir)
    $history = $this->chatModel->getHistory($session_id, 10);

    // 3. Kirim ke AI dengan history
    $ai = new AIService();
    $jawaban = $ai->tanya($pertanyaan, $history);

    // 4. Simpan jawaban AI
    $this->chatModel->simpanPesan($session_id, 'assistant', $jawaban, $id_user);

    return $this->response->setJSON([
        'status'     => 'success',
        'pertanyaan' => $pertanyaan,
        'jawaban'    => $jawaban
    ]);
}

    public function clear()
    {
        $session_id = $this->request->getPost('session_id');
        if ($session_id) $this->chatModel->hapusHistory($session_id);
        return $this->response->setJSON(['status' => 'success']);
    }
}