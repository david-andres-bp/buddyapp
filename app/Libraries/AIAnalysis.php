<?php

namespace App\Libraries;

class AIAnalysis
{
    /**
     * A map of keywords to personality tags.
     * In a real application, this would be a sophisticated AI model.
     */
    protected array $keywordMap = [
        'adventurous' => ['hike', 'mountain', 'travel', 'explore', 'outdoors', 'adventure'],
        'creative'    => ['art', 'music', 'design', 'paint', 'write', 'create', 'photo'],
        'foodie'      => ['food', 'restaurant', 'cook', 'eat', 'dish', 'recipe'],
        'sporty'      => ['sport', 'gym', 'run', 'fitness', 'workout', 'game'],
        'intellectual' => ['book', 'read', 'learn', 'science', 'history', 'documentary'],
    ];

    /**
     * Analyzes a string of text and returns an array of matching personality tags.
     *
     * @param string $text The text to analyze.
     * @return array An array of matching tags.
     */
    public function analyzeText(string $text): array
    {
        $foundTags = [];
        $text = strtolower($text);

        foreach ($this->keywordMap as $tag => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    $foundTags[] = $tag;
                    // Move to the next tag once a keyword is found
                    continue 2;
                }
            }
        }

        return array_unique($foundTags);
    }
}
