<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Rohit Sharma',
                'designation' => 'CEO',
                'company' => 'D2C Startup',
                'avatar' => '/assets/images/testimonials/avatar-1.jpg',
                'rating' => 5,
                'content' => 'CraftByCode transformed our idea into a powerful digital product. Their team is professional, creative and super responsive. They delivered well ahead of schedule and the code quality is top-notch.',
                'order' => 1,
                'is_featured' => true,
            ],
            [
                'client_name' => 'Anjali Verma',
                'designation' => 'Product Manager',
                'company' => 'FinScale Systems',
                'avatar' => '/assets/images/testimonials/avatar-2.jpg',
                'rating' => 5,
                'content' => 'Amazing experience from start to finish. They delivered on time and the quality exceeded our expectations. The attention to detail in UX design and backend stability made all the difference.',
                'order' => 2,
                'is_featured' => true,
            ],
            [
                'client_name' => 'Vikram Patel',
                'designation' => 'Founder',
                'company' => 'SaaS Company',
                'avatar' => '/assets/images/testimonials/avatar-3.jpg',
                'rating' => 5,
                'content' => 'Their attention to detail and technical expertise is outstanding. Highly recommended! We have partnered with them on 4 consecutive product launches and each has been a major commercial success.',
                'order' => 3,
                'is_featured' => true,
            ],
            [
                'client_name' => 'Sarah Jenkins',
                'designation' => 'VP of Engineering',
                'company' => 'CloudScale Global',
                'avatar' => '/assets/images/testimonials/avatar-4.jpg',
                'rating' => 5,
                'content' => 'CraftByCode is the most dependable engineering partner we have ever contracted with. Clean Laravel architecture, prompt communication, and zero technical debt. Truly world-class.',
                'order' => 4,
                'is_featured' => false,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(['client_name' => $t['client_name']], $t);
        }
    }
}

