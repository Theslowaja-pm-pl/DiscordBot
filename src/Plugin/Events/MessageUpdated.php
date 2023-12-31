<?php
/*
 * DiscordBot, PocketMine-MP Plugin.
 *
 * Licensed under the Open Software License version 3.0 (OSL-3.0)
 * Copyright (C) 2020-present JaxkDev
 *
 * Twitter :: @JaxkDev
 * Discord :: JaxkDev
 * Email   :: JaxkDev@gmail.com
 */

namespace JaxkDev\DiscordBot\Plugin\Events;

use JaxkDev\DiscordBot\Models\Messages\Message;
use pocketmine\plugin\Plugin;

/**
 * Emitted when a message has been updated.
 *
 * @see MessageDeleted
 * @see MessageSent
 */
class MessageUpdated extends DiscordBotEvent{

    private Message $message;

    public function __construct(Plugin $plugin, Message $message){
        parent::__construct($plugin);
        $this->message = $message;
    }

    public function getMessage(): Message{
        return $this->message;
    }
}