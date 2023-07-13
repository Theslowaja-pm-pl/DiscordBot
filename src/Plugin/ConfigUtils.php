<?php /** @noinspection PhpUnusedPrivateMethodInspection */

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

namespace JaxkDev\DiscordBot\Plugin;

abstract class ConfigUtils{

    const VERSION = 4;

    // Map all versions to a static function.
    private const _PATCH_MAP = [
        1 => "patch_1",
        2 => "patch_2",
        3 => "patch_3"
    ];

    static public function update(array &$config): void{
        for($i = (int)$config["version"]; $i < self::VERSION; $i += 1){
            $config = forward_static_call([self::class, self::_PATCH_MAP[$i]], $config);
        }
    }

    static private function patch_1(array $config): array{
        $config["version"] = 2;
        if(!isset($config["discord"])){
            $config["discord"] = [
                "token" => "Long Token here.",
                "use_plugin_cacert" => true
            ];
        }else{
            $config["discord"]["use_plugin_cacert"] = true;
            unset($config["discord"]["usePluginCacert"]);
        }
        if(!isset($config["logging"])){
            $config["logging"] = [
                "debug" => false,
                "max_files" => 28,
                "directory" => "logs"
            ];
        }else{
            $config["logging"]["max_files"] = $config["logging"]["max_files"] ?? 28;
            unset($config["logging"]["maxFiles"]);
        }
        if(!isset($config["protocol"])){
            $config["protocol"] = [
                "packets_per_tick" => 50,
                "heartbeat_allowance" => 60
            ];
        }
        return $config;
    }

    static private function patch_2(array $config): array{
        $config["version"] = 3;
        unset($config["logging"]["debug"]);
        return $config;
    }

    static private function patch_3(array $config): array{
        $config["version"] = 4;
        $config["discord"]["type"] = "internal";
        $old = $config["protocol"];
        $config["protocol"] = [
            "general" => [
                "packets_per_tick" => $old["packets_per_tick"] ?? 50,
                "heartbeat_allowance" => $old["heartbeat_allowance"] ?? 60
            ],
            "internal" => [
                "use_plugin_cacert" => $config["discord"]["use_plugin_cacert"] ?? true
            ],
            "external" => [
                "host" => "0.0.0.0",
                "port" => 22222
            ]
        ];
        unset($config["discord"]["use_plugin_cacert"]);
        return $config;
    }

    /**
     * Verifies the config's keys and values, returning any keys and a relevant message.
     * @return string[]
     */
    static public function verify(array $config): array{
        $result = [];

        if(!array_key_exists("version", $config) or $config["version"] === null){
            $result[] = "No 'version' field found.";
        }else{
            if(!is_int($config["version"]) or $config["version"] <= 0 or $config["version"] > self::VERSION){
                $result[] = "Invalid 'version' ({$config["version"]}), you were warned not to touch it...";
            }
        }

        if(!array_key_exists("discord", $config) or $config["discord"] === null){
            $result[] = "No 'discord' field found.";
        }else{
            if(!array_key_exists("token", $config["discord"]) or $config["discord"]["token"] === null){
                $result[] = "No 'discord.token' field found.";
            }else{
                if(!is_string($config["discord"]["token"]) or strlen($config["discord"]["token"]) < 59){
                    $result[] = "Invalid 'discord.token' ({$config["discord"]["token"]}), did you follow the wiki ?";
                }
            }
            if(!array_key_exists("type", $config["discord"]) or $config["discord"]["type"] === null){
                $result[] = "No 'discord.type' field found.";
            }else{
                if(!is_string($config["discord"]["type"]) or !in_array($config["discord"]["type"], ["internal", "external"], true)){
                    $result[] = "Invalid 'discord.token' ({$config["discord"]["token"]}), must be 'internal' or 'external'.";
                }
            }
        }

        if(!array_key_exists("logging", $config) or $config["logging"] === null){
            $result[] = "No 'logging' field found.";
        }else{
            if(!array_key_exists("max_files", $config["logging"]) or $config["logging"]["max_files"] === null){
                $result[] = "No 'logging.max_files' field found.";
            }else{
                if(!is_int($config["logging"]["max_files"]) or $config["logging"]["max_files"] <= 0){
                    $result[] = "Invalid 'logging.max_files' ({$config["logging"]["max_files"]}), should be an int > 0.";
                }
            }

            if(!array_key_exists("directory", $config["logging"]) or $config["logging"]["directory"] === null){
                $result[] = "No 'logging.directory' field found.";
            }else{
                if(!is_string($config["logging"]["directory"]) or strlen($config["logging"]["directory"]) === 0){
                    $result[] = "Invalid 'logging.directory' ({$config["logging"]["directory"]}).";
                }
            }
        }

        if(!array_key_exists("protocol", $config) or $config["protocol"] === null){
            $result[] = "No 'protocol' field found.";
        }else{
            if(!array_key_exists("general", $config["protocol"]) or $config["protocol"]["general"] === null){
                $result[] = "No 'protocol.general' field found.";
            }else{
                if(!array_key_exists("packets_per_tick", $config["protocol"]["general"]) or $config["protocol"]["general"]["packets_per_tick"] === null){
                    $result[] = "No 'protocol.general.packets_per_tick' field found.";
                }else{
                    if(!is_int($config["protocol"]["general"]["packets_per_tick"]) or $config["protocol"]["general"]["packets_per_tick"] < 5){
                        $result[] = "Invalid 'protocol.general.packets_per_tick' ({$config["protocol"]["general"]["packets_per_tick"]}), Do not touch this without being told to explicitly by JaxkDev";
                    }
                }
                if(!array_key_exists("heartbeat_allowance", $config["protocol"]["general"]) or $config["protocol"]["general"]["heartbeat_allowance"] === null){
                    $result[] = "No 'protocol.general.heartbeat_allowance' field found.";
                }else{
                    if(!is_int($config["protocol"]["general"]["heartbeat_allowance"]) or $config["protocol"]["general"]["heartbeat_allowance"] < 2){
                        $result[] = "Invalid 'protocol.general.heartbeat_allowance' ({$config["protocol"]["general"]["heartbeat_allowance"]}),  Do not touch this without being told to explicitly by JaxkDev";
                    }
                }
            }

            if(!array_key_exists("internal", $config["protocol"]) or $config["protocol"]["internal"] === null){
                $result[] = "No 'protocol.internal' field found.";
            }else{
                if(!array_key_exists("use_plugin_cacert", $config["protocol"]["internal"]) or $config["protocol"]["internal"]["use_plugin_cacert"] === null){
                    $result[] = "No 'protocol.internal.use_plugin_cacert' field found.";
                }else{
                    if(!is_bool($config["protocol"]["internal"]["use_plugin_cacert"])){
                        $result[] = "Invalid 'protocol.internal.use_plugin_cacert' ({$config["protocol"]["internal"]["use_plugin_cacert"]}), Do not touch this without being told to explicitly by JaxkDev";
                    }
                }
            }

            if(!array_key_exists("external", $config["protocol"]) or $config["protocol"]["external"] === null){
                $result[] = "No 'protocol.external' field found.";
            }else{
                if(!array_key_exists("host", $config["protocol"]["external"]) or $config["protocol"]["external"]["host"] === null){
                    $result[] = "No 'protocol.external.host' field found.";
                }else{
                    if(filter_var($config["protocol"]["external"]["host"], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false){
                        $result[] = "Invalid 'protocol.external.host' ({$config["protocol"]["external"]["host"]}) must be a valid IPv4 address.";
                    }
                }

                if(!array_key_exists("port", $config["protocol"]["external"]) or $config["protocol"]["external"]["port"] === null){
                    $result[] = "No 'protocol.external.port' field found.";
                }else{
                    if(!is_int($config["protocol"]["external"]["port"]) or $config["protocol"]["external"]["port"] < 1 or $config["protocol"]["external"]["port"] > 65535){
                        $result[] = "Invalid 'protocol.external.port' ({$config["protocol"]["external"]["port"]}) must be a valid port (1-65535).";
                    }
                }
            }
        }

        return $result;
    }
}