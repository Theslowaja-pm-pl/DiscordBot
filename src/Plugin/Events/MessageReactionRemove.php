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
use JaxkDev\DiscordBot\Models\Member;
use pocketmine\plugin\Plugin;

/**
 * Emitted when a reaction is removed from a message.
 *
 * @see MessageReactionAdd
 * @see MessageReactionRemoveAll
 * @see MessageReactionRemoveEmoji
 */
class MessageReactionRemove extends DiscordBotEvent{

    private string $emoji;

    private string $message_id;

    private Channel $channel;

    private Member $member;

    public function __construct(Plugin $plugin, string $emoji, string $message_id, Channel $channel, Member $member){
        parent::__construct($plugin);
        $this->emoji = $emoji;
        $this->message_id = $message_id;
        $this->channel = $channel;
        $this->member = $member;
    }

    public function getEmoji(): string{
        return $this->emoji;
    }

    public function getMessageId(): string{
        return $this->message_id;
    }

    public function getChannel(): Channel{
        return $this->channel;
    }

    public function getMember(): Member{
        return $this->member;
    }
}