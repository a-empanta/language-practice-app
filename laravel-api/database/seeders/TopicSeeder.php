<?php

namespace Database\Seeders;

use App\Models\TopicCategory;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Daily Life' => [
                'Morning rituals',
                'Household chores',
                'Grocery shopping',
                'Weekend plans',
                'Weather small talk',
            ],
            'Travel & Transportation' => [
                'Asking for directions',
                'Booking accommodations',
                'Airport interactions',
                'Train vs. bus',
                'Travel mishaps',
                'Road trip anecdotes',
            ],
            'Food & Cooking' => [
                'Signature home dishes',
                'Eating out etiquette',
                'Food markets',
                'Dietary restrictions',
                'Baking vs. cooking',
                'Street food favorites',
            ],
            'Arts & Entertainment' => [
                'Favorite films & series',
                'Book club picks',
                'Live concerts',
                'Art exhibitions',
                'DIY crafts',
            ],
            'Music & Dance' => [
                'Traditional instruments',
                'Dance styles',
                'Singing karaoke',
                'Festival lineups',
                'Songwriting ideas',
            ],
            'Sports & Recreation' => [
                'Team sports rules',
                'Solo workouts',
                'Outdoor adventures',
                'Fitness apps',
                'Sports news',
            ],
            'Science & Technology' => [
                'Gadget reviews',
                'Space missions',
                'Medical innovations',
                'AI in daily life',
                'Green tech',
            ],
            'Health & Wellness' => [
                'Mental health check-ins',
                'Yoga vs. pilates',
                'Superfoods',
                'Meditation techniques',
                'Healthcare systems',
            ],
            'Business & Economics' => [
                'Startup culture',
                'Stock market basics',
                'Freelancing tips',
                'Office jargon',
                'Negotiation tactics',
            ],
            'Politics & Current Affairs' => [
                'Election processes',
                'Local vs. global news',
                'Policy debates',
                'Social movements',
                'Fact-checking sources',
            ],
            'Environment & Nature' => [
                'Climate change impacts',
                'Recycling practices',
                'Wildlife conservation',
                'National parks',
                'Urban gardening',
            ],
            'Society & Culture' => [
                'Customs & taboos',
                'Festivals worldwide',
                'Generational norms',
                'Volunteer experiences',
                'Urban vs. rural life',
            ],
            'History & Traditions' => [
                'Landmark events',
                'Myths & legends',
                'Cultural heritage sites',
                'Evolution of traditions',
                'Historical figures',
            ],
            'Education & Learning' => [
                'Study tips',
                'E-learning platforms',
                'Language exchange',
                'Debate club topics',
                'Lifelong learning',
            ],
            'Grammar & Vocabulary' => [
                'Common idioms',
                'False friends',
                'Regional dialects',
                'Word formation',
                'Phrasal verbs',
            ],
            'Pronunciation & Phonetics' => [
                'Accent reduction',
                'Minimal pairs',
                'Tongue twisters',
                'Intonation patterns',
                'Linking sounds',
            ],
            'Writing & Literature' => [
                'Creative writing prompts',
                'Poetry recitals',
                'Book reviews',
                'Formal vs. informal tone',
                'Literary analysis',
            ],
            'Relationships & Emotions' => [
                'Friendship phrases',
                'Expressing feelings',
                'Conflict resolution',
                'Dating culture',
                'Family dynamics',
            ],
            'Fashion & Beauty' => [
                'Style trends',
                'Shopping for clothes',
                'Grooming routines',
                'Makeup vocabulary',
                'Sustainable fashion',
            ],
            'Home & Design' => [
                'Interior decorating',
                'DIY repairs',
                'Smart home tech',
                'Garden landscaping',
                'Furniture shopping',
            ],
            'Hobbies & Crafts' => [
                'Painting techniques',
                'Photography tips',
                'Model building',
                'Collecting hobbies',
                'DIY gifts',
            ],
            'Religion & Spirituality' => [
                'Festive customs',
                'Sacred texts',
                'Rituals & ceremonies',
                'Interfaith dialogue',
                'Mindfulness practice',
            ],
            'Law & Justice' => [
                'Courtroom vocabulary',
                'Rights & responsibilities',
                'Legal professions',
                'Contract basics',
                'Landmark cases',
            ],
            'Digital Life & Social Media' => [
                'Online slang',
                'Social platforms',
                'Digital privacy',
                'Blogging vs. vlogging',
                'E-commerce tips',
            ],
        ];

        foreach ($data as $categoryName => $topics) {
            $category = TopicCategory::create([ 'title' => $categoryName ]);

            // create each topic under this category
            $category->topics()->createMany(
                array_map(fn($t) => ['title' => $t], $topics)
            );
        }
    }
}
