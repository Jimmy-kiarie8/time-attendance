<?php

namespace App\Services;

use DefStudio\Telegraph\Models\TelegraphChat;

class TelegramService
{
    public function message($id, $message)
    {
        $chat = TelegraphChat::find($id);
        $chat->html($message)->send();
        return;
    }
}
