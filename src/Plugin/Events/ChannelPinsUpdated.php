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

use JaxkDev\DiscordBot\Models\Channels\TextChannel;
use pocketmine\plugin\Plugin;

/**
 * Emitted when a message is pinned or unpinned, note we dont know what message was pinned or unpinned only the channel ID.
 */
class ChannelPinsUpdated extends DiscordBotEvent{

    private TextChannel $channel;

    public function __construct(Plugin $plugin, TextChannel $channel){
        parent::__construct($plugin);
        $this->channel = $channel;
    }

    public function getChannel(): TextChannel{
        return $this->channel;
    }
}