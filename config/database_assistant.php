<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Database Assistant Communication Rules
    |--------------------------------------------------------------------------
    | These phrases help the rule-based assistant recognize common questions.
    | They do not execute database queries by themselves.
    */

    'intents' => [
        'greeting' => [
            'examples' => [
                'hello',
                'hi',
                'hey',
                'good morning',
                'good afternoon',
                'good evening',
                'kumusta',
                'magandang umaga',
                'magandang hapon',
                'magandang gabi',
            ],
        ],

        'help' => [
            'examples' => [
                'help',
                'help me',
                'what can you do',
                'what can i ask',
                'how can you help me',
                'what questions can i ask',
                'how do i use you',
                'ano ang kaya mo',
                'paano gamitin',
                'ano ang pwede kong itanong',
                'ano ang maaari kong itanong',
                'paano ka makakatulong',
                'commands',
            ],
        ],

        'count_residents' => [
            'examples' => [
                'how many residents',
                'how many resident',
                'resident count',
                'total residents',
                'total resident',
                'number of residents',
                'count residents',
                'ilan ang resident',
                'ilan ang residente',
                'bilang ng residente',
                'pila kabuok ang residents',
                'pila ka residente',
                'total na residente',
            ],
        ],

        'search_residents' => [
            'examples' => [
                'find resident',
                'search resident',
                'show resident',
                'resident named',
                'look up resident',
                'find patient',
                'search patient',
                'hanapin ang residente',
                'ipakita ang residente',
                'sino si',
                'resident address',
                'address of resident',
                'where does',
                'where do',
                'address of',
                'contact number of',
                'nasaan si',
                'saan nakatira si',
                'asa nagpuyo si',
            ],
        ],

        'count_households' => [
            'examples' => [
                'how many households',
                'how many household',
                'household count',
                'total households',
                'total household',
                'number of households',
                'count households',
                'ilan ang household',
                'ilan ang sambahayan',
                'bilang ng sambahayan',
                'pila ka household',
            ],
        ],

        'search_households' => [
            'examples' => [
                'find household',
                'search household',
                'show household',
                'household code',
                'household head',
                'head of household',
                'household address',
                'address of household',
                'where is the household',
                'where is this household',
                'who is the household head',
                'sino ang household head',
                'hanapin ang sambahayan',
                'ipakita ang sambahayan',
                'sambahayan',
            ],
        ],

        'upcoming_schedules' => [
            'examples' => [
                'upcoming schedule',
                'upcoming schedules',
                'upcoming event',
                'upcoming events',
                'show schedule',
                'show schedules',
                'show event',
                'show events',
                'what events are coming',
                'what is the next event',
                'when is the next event',
                'when is the next schedule',
                'next schedule',
                'calendar activities',
                'mga susunod na schedule',
                'ano ang schedule',
                'may schedule ba',
                'iskedyul',
                'mga event',
            ],
        ],

        'medical_inventory' => [
            'examples' => [
                'show inventory',
                'medical inventory',
                'show medical inventory',
                'medical supplies',
                'show medicines',
                'show medicine stock',
                'medicine stock',
                'stock of medicine',
                'expired medicines',
                'expiring medicines',
                'medicine expiry',
                'expiry date',
                'expiration date',
                'which medicines are expiring',
                'what medicines are expired',
                'gamot',
                'mga gamot',
                'mga expired na gamot',
                'gamot na malapit mag expire',
                'mga supply',
            ],
        ],

        'published_announcements' => [
            'examples' => [
                'show announcements',
                'published announcements',
                'latest announcement',
                'latest announcements',
                'barangay announcements',
                'what are the announcements',
                'what are the latest announcements',
                'mga anunsyo',
                'mga abiso',
                'ano ang mga announcement',
                'ano ang mga anunsyo',
            ],
        ],

        'staff_accounts' => [
            'examples' => [
                'how many staff',
                'staff count',
                'total staff',
                'list staff',
                'show staff',
                'staff accounts',
                'health workers',
                'health worker accounts',
                'officials',
                'official accounts',
                'mga health worker',
            ],
        ],
    ],

    'fallback' =>
        'Sorry, I could not understand that question yet. You can ask about residents, households, schedules, medical inventory, announcements, or staff accounts.',

    'max_examples_per_intent' => 30,

    'max_message_length' => 300,
];
