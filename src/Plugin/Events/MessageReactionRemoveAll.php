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

use JaxkDev\DiscordBot\Models\Channels\Channel;
use pocketmine\plugin\Plugin;

/**
 * Emitted when ALL reactions are removed from a message.
 *
 * @see MessageReactionAdd
 * @see MessageReactionRemove
 * @see MessageReactionRemoveEmoji
 */
class MessageReactionRemoveAll extends DiscordBotEvent{

    private string $message_id;

    private Channel $channel;

    public function __construct(Plugin $plugin, string $message_id, Channel $channel){
        parent::__construct($plugin);
        $this->message_id = $message_id;
        $this->channel = $channel;
    }

    public function getMessageId(): string{
        return $this->message_id;
    }

    public function getChannel(): Channel{
        return $this->channel;
    }
}