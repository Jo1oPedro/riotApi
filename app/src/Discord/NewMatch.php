<?php

namespace Riot\Discord;

class NewMatch
{
    public static function sendMessage(string $image)
    {
        $apiUrl = "https://discord.com/api/v10/channels/1084248489707450498/messages";
        $timestamp = date("c", strtotime("now"));
        $msg = json_encode([
            "content" => "Analise de mapa",
            "username" => "analisador",
            "avatar_url" => "https://cdn.discordapp.com/avatars/1223334672835149825/ed1007d7446f1fa47b1e1f60bf6dda5d.webp?size=1024",
            "tts" => false,
            "embeds" => [
                [
                    "title" => "Varinha",
                    "type" => "rich",
                    "description" => "mapa",
                    "url" => "http://85.31.62.148:5000/",
                    "timestamp" => $timestamp,
                    "color" => hexdec( "FF0000"),
                    // Footer text
                    "footer" => [
                        "text" => "Varinha & rayray",
                        "icon_url" => "http://localhost:8888/"
                    ],

                    "image" => [
                        "url" => "http://85.31.62.148:5000/MapsImage/{$image}?size=600",
                    ],

                    // thumbnail
                    "thumbnail" => [
                        "url" => "http://85.31.62.148:5000/MapsImage/{$image}?size=600"
                    ],

                    // Author name & url
                    "author" => [
                        "name" => "cascata",
                        "url" => "http://85.31.62.148:5000"
                    ],

                    "fields" => [
                        [
                            "name" => "Contato do dono",
                            "value" => "varinha@rayray.com",
                            "inline" => false
                        ],
                        [
                            "name" => "Field #2",
                            "value" => "Value #2",
                            "inline" => true
                        ]
                    ]
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        $ch = curl_init($apiUrl);
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-type: application/json', 'Authorization: Bot ' . $_ENV["BOT_TOKEN"]));
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $msg);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        #echo $response;
        curl_close( $ch );
    }
}