<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Frontend;
use App\Models\Page;

function insertFrontend($key, $values) {
    $f = Frontend::where('data_keys', $key)->first();
    if (!$f) {
        $f = new Frontend();
        $f->data_keys = $key;
    }
    $f->data_values = $values;
    $f->save();
}

insertFrontend('banner.content', [
    'heading' => 'Welcome to PlayPaws',
    'description' => 'The best pet care services for your furry friends. We provide grooming, training, and veterinary services.',
    'button_url' => '/',
    'button_text' => 'Get Started',
    'background_image' => '64b7ee02b7b661689775618.png',
]);

insertFrontend('about.content', [
    'tag' => 'About Us',
    'heading' => 'About Us',
    'subheading' => 'Subheading',
    'description' => 'We love pets and we are dedicated to providing the best care for them. Our experienced team is always here to help.',
    'image' => '64aaa976477d31688906102.jpg',
]);

insertFrontend('services.content', [
    'tag' => 'Our Services',
    'heading' => 'Our Services',
    'subheading' => 'Subheading',
    'description' => 'Check out the awesome services we offer for your pets.',
]);

insertFrontend('call_out.content', [
    'tag' => 'Call Out',
    'heading' => 'Need a Consultation?',
    'subheading' => 'Subheading',
    'description' => 'Contact us today.',
    'button_url' => '/',
    'button_text' => 'Contact Us',
    'image' => '64b7da01cc43e1689770497.jpg',
    'background_image' => '64b7da01cc43e1689770497.jpg',
]);

insertFrontend('faq.content', [
    'tag' => 'FAQ',
    'heading' => 'Frequently Asked Questions',
    'subheading' => 'Got questions? We have answers.',
    'description' => 'Got questions? We have answers.',
    'image' => '64b78e9ba36cf1689751195.png',
]);

insertFrontend('consultation.content', [
    'tag' => 'Consultation',
    'heading' => 'Free Consultation',
    'subheading' => 'Book a free consultation.',
    'description' => 'Book a free consultation.',
    'image' => '64b78d8f333ff1689750927.png',
]);

insertFrontend('blog.content', [
    'tag' => 'Blog',
    'heading' => 'Latest News',
    'subheading' => 'Read our articles.',
    'description' => 'Read our latest articles on pet care.',
]);

insertFrontend('contact_us.content', [
    'email_address' => 'support@playpaws.com',
    'contact_number' => '+1234567890',
    'title' => 'Contact Us',
    'short_details' => 'Reach out anytime.',
    'address' => '123 Pet Street',
]);

// Page Sections
$p = Page::where('slug', '/')->first();
if ($p) {
    $p->secs = json_encode(['about', 'services', 'call_out', 'consultation', 'faq', 'blog']);
    $p->save();
}

echo "Frontend data populated successfully.";
