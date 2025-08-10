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
                'topic_change' => 'Let\'s focus on the current topic to practice better.',
                default => $phrase,
            },
            self::CHINESE_MANDARIN => match($phrase) {
                'mistake' => '您的意思是',
                'inappropriate' => '抱歉，我无法就此为您提供帮助',
                'missunderstanding' => '抱歉，我不明白您的意思',
                'topic_change' => '让我们专注于当前话题以更好地练习。',
                default => $phrase,
            },
            self::RUSSIAN => match($phrase) {
                'mistake' => 'Вы имели в виду',
                'inappropriate' => 'Извините, но я не могу вам с этим помочь',
                'missunderstanding' => 'Извините, но я не понял, что вы имели в виду',
                'topic_change' => 'Давайте сосредоточимся на текущей теме для лучшей практики.',
                default => $phrase,
            },
            self::FRENCH => match($phrase) {
                'mistake' => 'Vouliez-vous dire',
                'inappropriate' => 'Je suis désolé, mais je ne peux pas vous aider pour cela',
                'missunderstanding' => 'Je suis désolé, mais je n\'ai pas compris ce que vous voulez dire',
                'topic_change' => 'Concentrons-nous sur le sujet actuel pour mieux pratiquer.',
                default => $phrase,
            },
            self::GERMAN => match($phrase) {
                'mistake' => 'Meinten Sie',
                'inappropriate' => 'Es tut mir leid, aber ich kann Ihnen dabei nicht helfen',
                'missunderstanding' => 'Es tut mir leid, aber ich habe nicht verstanden, was Sie meinen',
                'topic_change' => 'Lass uns beim aktuellen Thema bleiben, um besser zu üben.',
                default => $phrase,
            },
            self::SPANISH => match($phrase) {
                'mistake' => 'Quiso decir',
                'inappropriate' => 'Lo siento, pero no puedo ayudarle con esto',
                'missunderstanding' => 'Lo siento, pero no entendí lo que quiso decir',
                'topic_change' => 'Centrémonos en el tema actual para practicar mejor.',
                default => $phrase,
            },
            self::PORTUGUESE => match($phrase) {
                'mistake' => 'Você quis dizer',
                'inappropriate' => 'Desculpe, mas não posso ajudá-lo com isso',
                'missunderstanding' => 'Desculpe, mas não entendi o que você quis dizer',
                'topic_change' => 'Vamos focar no tema atual para praticar melhor.',
                default => $phrase,
            },
            self::TURKISH => match($phrase) {
                'mistake' => 'Demek istediniz mi',
                'inappropriate' => 'Üzgünüm, ama bu konuda size yardımcı olamam',
                'missunderstanding' => 'Üzgünüm, ne demek istediğinizi anlayamadım',
                'topic_change' => 'Daha iyi pratik yapmak için mevcut konuya odaklanalım.',
                default => $phrase,
            },
            self::ITALIAN => match($phrase) {
                'mistake' => 'Intendeva dire',
                'inappropriate' => 'Mi dispiace, ma non posso aiutarla con questo',
                'missunderstanding' => 'Mi dispiace, ma non ho capito cosa intendeva',
                'topic_change' => 'Concentriamoci sull’argomento attuale per praticare meglio.',
                default => $phrase,
            },
            self::DUTCH => match($phrase) {
                'mistake' => 'Bedoelde u',
                'inappropriate' => 'Het spijt me, maar ik kan u hiermee niet helpen',
                'missunderstanding' => 'Het spijt me, maar ik begreep niet wat u bedoelt',
                'topic_change' => 'Laten we ons op het huidige onderwerp concentreren om beter te oefenen.',
                default => $phrase,
            },
            self::CATALAN => match($phrase) {
                'mistake' => 'Volia dir',
                'inappropriate' => 'Em sap greu, però no puc ajudar-lo amb això',
                'missunderstanding' => 'Em sap greu, però no he entès què volia dir',
                'topic_change' => 'Centrem-nos en el tema actual per practicar millor.',
                default => $phrase,
            },
            self::ARABIC => match($phrase) {
                'mistake' => 'هل تقصد',
                'inappropriate' => 'عذراً، لكن لا أستطيع مساعدتك في هذا',
                'missunderstanding' => 'عذراً، لم أفهم ما تعنيه',
                'topic_change' => 'دعنا نركز على الموضوع الحالي لنمارس بشكل أفضل.',
                default => $phrase,
            },
            self::SWEDISH => match($phrase) {
                'mistake' => 'Menade du',
                'inappropriate' => 'Tyvärr, men jag kan inte hjälpa dig med detta',
                'missunderstanding' => 'Tyvärr, men jag förstod inte vad du menade',
                'topic_change' => 'Låt oss fokusera på det aktuella ämnet för att öva bättre.',
                default => $phrase,
            },
            self::JAPANESE => match($phrase) {
                'mistake' => 'もしかして',
                'inappropriate' => '申し訳ありませんが、これについてはお手伝いできません',
                'missunderstanding' => '申し訳ありませんが、おっしゃっていることが分かりませんでした',
                'topic_change' => 'より良く練習するために現在の話題に集中しましょう。',
                default => $phrase,
            },
            self::HINDI => match($phrase) {
                'mistake' => 'क्या आप ऐसा कहना चाह रहे थे',
                'inappropriate' => 'माफ़ कीजिए, लेकिन मैं इसमें आपकी मदद नहीं कर सकता',
                'missunderstanding' => 'माफ़ कीजिए, लेकिन मैं समझ नहीं पाया कि आपका क्या मतलब है',
                'topic_change' => 'बेहतर अभ्यास के लिए वर्तमान विषय पर ध्यान केंद्रित करें।',
                default => $phrase,
            },
            self::CZECH => match($phrase) {
                'mistake' => 'Mysleli jste',
                'inappropriate' => 'Omlouvám se, ale s tímto vám nemohu pomoci',
                'missunderstanding' => 'Omlouvám se, ale nerozuměl jsem tomu, co jste myslel',
                'topic_change' => 'Soustřeďme se na aktuální téma, abychom lépe procvičovali.',
                default => $phrase,
            },
            self::POLISH => match($phrase) {
                'mistake' => 'Czy chodziło Panu/Pani o',
                'inappropriate' => 'Przykro mi, ale nie mogę Panu/Pani w tym pomóc',
                'missunderstanding' => 'Przykro mi, ale nie zrozumiałem, co miał Pan/Pani na myśli',
                'topic_change' => 'Skupmy się na bieżącym temacie, aby lepiej ćwiczyć.',
                default => $phrase,
            },
            self::KOREAN => match($phrase) {
                'mistake' => '혹시 이런 뜻인가요',
                'inappropriate' => '죄송하지만, 이 문제에 대해서는 도와드릴 수 없습니다',
                'missunderstanding' => '죄송하지만, 무슨 뜻인지 이해하지 못했습니다',
                'topic_change' => '더 잘 연습하기 위해 현재 주제에 집중합시다.',
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
            'topic_change' => $this->translate('topic_change'),
        ], JSON_UNESCAPED_UNICODE);
    }
}