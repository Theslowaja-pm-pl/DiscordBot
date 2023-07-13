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

namespace JaxkDev\DiscordBot\Communication\Packets\Discord;

use JaxkDev\DiscordBot\Communication\Packets\Packet;

class MemberLeave extends Packet{

    public const ID = 49;

    private string $member_id;

    public function __construct(string $member_id, ?int $uid = null){
        parent::__construct($uid);
        $this->member_id = $member_id;
    }

    public function getMemberID(): string{
        return $this->member_id;
    }

    public function jsonSerialize(): array{
        return [
            "uid" => $this->UID,
            "member_id" => $this->member_id
        ];
    }

    public static function fromJson(array $data): self{
        return new self(
            $data["member_id"],
            $data["uid"]
        );
    }
}