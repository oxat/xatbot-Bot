<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$super = function (int $who, array $message, int $type) {

    $bot = xatbot\API\ActionAPI::getBot();
    if (!$bot->minrank($who, 'super')) {
        return $bot->network->sendMessageAutoDetection($who, $bot->botlang('not.enough.rank'), $type);
    }

    if (empty($message[1])) {
        return $bot->network->sendMessageAutoDetection(
            $who,
            'Usage !super [anime/summer/halloween/xmas/heart/hobbies/cary/santa/love/egg/kao/fx/bunny/bf/zoo] [user]',
            $type
        );
    }

    if (empty($message[2])) {
        $message[2] = $who;
    }

    $info = null;
    if (is_numeric($message[2])) {
        $message[2] = (int)$message[2];

        if ($message[2] == 9223372036854775807) {
            return $bot->network->sendMessageAutoDetection($who, 'I am in a 64-bit environment.', $type, true);
        }
        
        $info = Capsule::table('userinfo')
                ->where('xatid', $message[2])
                ->orderBy('updated_at', 'desc')
                ->get()
                ->toArray();
    } else {
        $info = Capsule::table('userinfo')
                ->whereRaw('LOWER(regname) = ?', [strtolower($message[2])])
                ->orderBy('updated_at', 'desc')
                ->get()
                ->toArray();
    }

    if (!empty($info)) {
        $info = $info[0];
        
        $anime = [
            'anime' => 53,
            'manga' => 151,
            'ani1' => 253,
            'cutie' => 295,
            'coolz' => 298,
            'blueoni' => 311,
            'animegirl' => 392,
            'aprincess' => 399,
            'battle' => 420,
        ];

        $summer = [
            'summer' => 89,
            'beach' => 128,
            'seaside' => 229,
            'summerflix' => 296,
            'vacation' => 343,
            'shells' => 345,
            'summerland' => 398,
            'summerhug' => 401,
            'splashfx' => 445,
        ];

        $halloween = [
            'halloween' => 52,
            'horror' => 92,
            'carve' => 147,
            'halloween2' => 257,
            'trickortreat' => 308,
            'creepy' => 309,
            'allhallows' => 362,
            'witch' => 363,
            'halloscroll' => 465,
            'muertos' => 518,
        ];

        $xmas = [
            'snowy' => 56,
            'christmas' => 57,
            'winter' => 96,
            'treefx' => 203,
            'winterland' => 261,
            'choirhug' => 366,
            'ornaments' => 368,
            'tropicalxmas' => 417,
            'christmix' => 418,
            'sparklefx' => 419,
            'kxmas' => 470,
            'xmasscroll' => 471,
        ];

        $heart = [
            'heart' => 17,
            'heartfx' => 166,
            'burningheart' => 193,
            'kheart' => 215,
            'sweetheart' => 271,
            'amore' => 324,
            'valfx' => 325,
            'valentinefx' => 532,
        ];

        $hobbies = [
            'fashion' => 536,
            'mime' => 540,
            'tshirt' => 547,
            'swimming' => 550,
            'acting' => 557,
        ];

        $cary = [
            'spooky'	 => 148,
            'vampyre'	 => 202,
            'zombie' 	=> 213,
            'scary' 	=> 254,
            'zwhack'	=> 256,
			'arachnid'	=> 270,
			'reaper'	=> 354,
			'boo'		=> 411,
			'graveyard'	=> 412,
			'ghostmon'	=> 446,
			'nightmare'	=> 454,
			'skull'		=> 464,
			'fear'		=> 565,
			'spookies'	=> 567,
		];

		$santa = [
            'snowman'		=> 154,
            'reindeer'		=> 155,
            'santa'			=> 156,
            'claus'			=> 204,
            'noel'			=> 262,
			'toys'			=> 263,
			'reveal'		=> 314,
			'holidays'		=> 315,
			'sleighhug'		=> 367,
			'xmasfactory'	=> 475,
			'kris'			=> 571,
			'neva'			=> 573,
		];

		$love = [
			'valentine'		=> 62,
			'marriage'		=> 241,
			'wedding'		=> 233,
			'romance'		=> 242,
			'floral'		=> 335,
			'lovemix'		=> 374,
			'lovemix2'		=> 425,
			'lovefx'		=> 426,
			'lovetest'		=> 427,
			'heartbreak'	=> 482,
			'lovepotion'	=> 583,
		];

		$egg = [
			'eggs'			=> 222,
			'eggy'			=> 251,
			'easteregg'		=> 281,
			'easterlove'	=> 332,
			'easterland'	=> 381,
			'eggie'			=> 440,
		];

		$kao = [ 
			'gkaoani'	=> 72,
			'gkaliens'	=> 76,
			'kangel'	=> 248,
			'kdemon'	=> 249,
			'kmoon'		=> 305,
			'ksun'		=> 306,
			'kandle'	=> 358,
			'kstar'		=> 361,
			'ricebowl'	=> 372,
			'onion'		=> 385,
			'kaoears'	=> 422,
			'kloud'		=> 451,
			'kveggie'	=> 456,
			'koffee'	=> 499,
			'ktree'		=> 507,
			'kcar'		=> 520,
			'khair'		=> 529,
			'kactus'	=> 527,
			'kbacks'	=> 542,
		];

		$fx = [
			'magicfx'		=> 163,
			'pulsefx'		=> 174,
			'spiralfx'		=> 178,
			'vortexfx'		=> 182,
			'whirlfx'		=> 187,
			'clockfx'		=> 198,
			'glitterfx'		=> 208,
			'phasefx'		=> 240,
			'bitefx'		=> 275,
			'gamefx'		=> 289,
			'ballfx'		=> 293,
			'gamefx2'		=> 313,
			'spacefx'		=> 432,
			'firefx'		=> 459,
			'illusionfx'	=> 484,
			'portalfx'		=> 501,
			'slimefx'		=> 508,
			'energyfx'		=> 569,
			'lavafx'		=> 621,
			'circlefx'		=> 631,
		];

		$bunny = [
			'easter'		=> 68,
			'blubunni'		=> 300,
			'ebunny'		=> 380,
			'ribunny'		=> 436,
			'rabb'			=> 605,
			'littlebunny'	=> 645,
		];

		$bf = [
			'blackfriday'	=> 260,
			'money'			=> 509,
			'blacksale'		=> 572,
			'darkfriday'	=> 612,
			'trader'		=> 613,
			'fridaysales'	=> 656,
		];

		$zoo = [
			'pony'		=> 197,
			'kmonkey'	=> 216,
			'arachnid'	=> 270,
			'ceebear'	=> 341,
			'lions'		=> 352,
			'tigers'	=> 364,
			'koala'		=> 389,
			'elephant'	=> 405,
			'kgiraffe'	=> 428,
			'hedgehog'	=> 438,
			'hippos'	=> 489,
			'guineapig'	=> 495,
			'raccoons'	=> 504,
			'gorilla'	=> 516,
			'skunk'		=> 537,
			'meerkat'	=> 539,
			'king'		=> 570,
			'scamp'		=> 580,
		];

        $powersToCheck = ${$message[1]};

        $user = new xatbot\Bot\XatUser(json_decode($info->packet, true));
        $powersmissing = [];
        if ($user->hasDays()) {
            foreach ($powersToCheck as $powerName => $powerId) {
                if (!$user->hasPower($powerId)) {
                    $powersmissing[] = $powerName;
                }
            }

            if (empty($powersmissing)) {
                return $bot->network->sendMessageAutoDetection(
                    $who,
                    $info->regname . ' is not missing any powers to have (super' . $message[1] . ').',
                    $type
                );
            } else {
                return $bot->network->sendMessageAutoDetection(
                    $who,
                    $info->regname . ' is missing ' . implode(', ', $powersmissing) . ' to have (super' .
                        $message[1] . ').',
                    $type
                );
            }
        } else {
            return $bot->network->sendMessageAutoDetection($who, 'This user does not have days.', $type);
        }
    } else {
        return $bot->network->sendMessageAutoDetection($who, $bot->botlang('user.notindatabase'), $type);
    }
};
