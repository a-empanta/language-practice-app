<?php

namespace App\Enums;

enum ReusablePhrases: string
{
    case ENGLISH_US       = 'ENGLISH_US';
    case CHINESE_MANDARIN = 'CHINESE_MANDARIN';
    case RUSSIAN          = 'RUSSIAN';
    case FRENCH           = 'FRENCH';
    case GERMAN           = 'GERMAN';
    case SPANISH          = 'SPANISH';
    case PORTUGUESE       = 'PORTUGUESE';
    case TURKISH          = 'TURKISH';
    case ITALIAN          = 'ITALIAN';
    case DUTCH            = 'DUTCH';
    case CATALAN          = 'CATALAN';
    case ARABIC           = 'ARABIC';
    case SWEDISH          = 'SWEDISH';
    case JAPANESE         = 'JAPANESE';
    case HINDI            = 'HINDI';
    case CZECH            = 'CZECH';
    case POLISH           = 'POLISH';
    case KOREAN           = 'KOREAN';

    public function translate(string $phrase): string
    {
        return match($this) {
            self::ENGLISH_US => match($phrase) {
                'mistake' => 'Did you mean',
                'inappropriate' => 'I am sorry, but I cannot help you with this',
                'missunderstanding' => 'I am sorry, but I didn\'t understand what you mean',
                default => $phrase,
            },
            self::CHINESE_MANDARIN => match($phrase) {
                'mistake' => '您的意思是',
                'inappropriate' => '抱歉，我无法就此为您提供帮助',
                'missunderstanding' => '抱歉，我不明白您的意思',
                default => $phrase,
            },
            self::RUSSIAN => match($phrase) {
                'mistake' => 'Вы имели в виду',
                'inappropriate' => 'Извините, но я не могу вам с этим помочь',
                'missunderstanding' => 'Извините, но я не понял, что вы имели в виду',
                default => $phrase,
            },
            self::FRENCH => match($phrase) {
                'mistake' => 'Vouliez-vous dire',
                'inappropriate' => 'Je suis désolé, mais je ne peux pas vous aider pour cela',
                'missunderstanding' => 'Je suis désolé, mais je n\'ai pas compris ce que vous voulez dire',
                default => $phrase,
            },
            self::GERMAN => match($phrase) {
                'mistake' => 'Meinten Sie',
                'inappropriate' => 'Es tut mir leid, aber ich kann Ihnen dabei nicht helfen',
                'missunderstanding' => 'Es tut mir leid, aber ich habe nicht verstanden, was Sie meinen',
                default => $phrase,
            },
            self::SPANISH => match($phrase) {
                'mistake' => 'Quiso decir',
                'inappropriate' => 'Lo siento, pero no puedo ayudarle con esto',
                'missunderstanding' => 'Lo siento, pero no entendí lo que quiso decir',
                default => $phrase,
            },
            self::PORTUGUESE => match($phrase) {
                'mistake' => 'Você quis dizer',
                'inappropriate' => 'Desculpe, mas não posso ajudá-lo com isso',
                'missunderstanding' => 'Desculpe, mas não entendi o que você quis dizer',
                default => $phrase,
            },
            self::TURKISH => match($phrase) {
                'mistake' => 'Demek istediniz mi',
                'inappropriate' => 'Üzgünüm, ama bu konuda size yardımcı olamam',
                'missunderstanding' => 'Üzgünüm, ne demek istediğinizi anlayamadım',
                default => $phrase,
            },
            self::ITALIAN => match($phrase) {
                'mistake' => 'Intendeva dire',
                'inappropriate' => 'Mi dispiace, ma non posso aiutarla con questo',
                'missunderstanding' => 'Mi dispiace, ma non ho capito cosa intendeva',
                default => $phrase,
            },
            self::DUTCH => match($phrase) {
                'mistake' => 'Bedoelde u',
                'inappropriate' => 'Het spijt me, maar ik kan u hiermee niet helpen',
                'missunderstanding' => 'Het spijt me, maar ik begreep niet wat u bedoelt',
                default => $phrase,
            },
            self::CATALAN => match($phrase) {
                'mistake' => 'Volia dir',
                'inappropriate' => 'Em sap greu, però no puc ajudar-lo amb això',
                'missunderstanding' => 'Em sap greu, però no he entès què volia dir',
                default => $phrase,
            },
            self::ARABIC => match($phrase) {
                'mistake' => 'هل تقصد',
                'inappropriate' => 'عذراً، لكن لا أستطيع مساعدتك في هذا',
                'missunderstanding' => 'عذراً، لم أفهم ما تعنيه',
                default => $phrase,
            },
            self::SWEDISH => match($phrase) {
                'mistake' => 'Menade du',
                'inappropriate' => 'Tyvärr, men jag kan inte hjälpa dig med detta',
                'missunderstanding' => 'Tyvärr, men jag förstod inte vad du menade',
                default => $phrase,
            },
            self::JAPANESE => match($phrase) {
                'mistake' => 'もしかして',
                'inappropriate' => '申し訳ありませんが、これについてはお手伝いできません',
                'missunderstanding' => '申し訳ありませんが、おっしゃっていることが分かりませんでした',
                default => $phrase,
            },
            self::HINDI => match($phrase) {
                'mistake' => 'क्या आप ऐसा कहना चाह रहे थे',
                'inappropriate' => 'माफ़ कीजिए, लेकिन मैं इसमें आपकी मदद नहीं कर सकता',
                'missunderstanding' => 'माफ़ कीजिए, लेकिन मैं समझ नहीं पाया कि आपका क्या मतलब है',
                default => $phrase,
            },
            self::CZECH => match($phrase) {
                'mistake' => 'Mysleli jste',
                'inappropriate' => 'Omlouvám se, ale s tímto vám nemohu pomoci',
                'missunderstanding' => 'Omlouvám se, ale nerozuměl jsem tomu, co jste myslel',
                default => $phrase,
            },
            self::POLISH => match($phrase) {
                'mistake' => 'Czy chodziło Panu/Pani o',
                'inappropriate' => 'Przykro mi, ale nie mogę Panu/Pani w tym pomóc',
                'missunderstanding' => 'Przykro mi, ale nie zrozumiałem, co miał Pan/Pani na myśli',
                default => $phrase,
            },
            self::KOREAN => match($phrase) {
                'mistake' => '혹시 이런 뜻인가요',
                'inappropriate' => '죄송하지만, 이 문제에 대해서는 도와드릴 수 없습니다',
                'missunderstanding' => '죄송하지만, 무슨 뜻인지 이해하지 못했습니다',
                default => $phrase,
            },
        };
    }

    public function allTranslations(): string
    {
        return json_encode([
            'mistake' => $this->translate('mistake'),
            'inappropriate' => $this->translate('inappropriate'),
            'missunderstanding' => $this->translate('missunderstanding'),
        ], JSON_UNESCAPED_UNICODE);
    }
}