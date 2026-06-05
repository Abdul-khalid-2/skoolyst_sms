<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Hero section
            $table->string('hero_title')->nullable()->after('hero_image');
            $table->string('hero_subtitle')->nullable()->after('hero_title');
            $table->text('hero_description')->nullable()->after('hero_subtitle');
            $table->string('hero_cta_text')->nullable()->after('hero_description');
            $table->string('hero_cta_link')->nullable()->after('hero_cta_text');

            // About section extras
            $table->text('mission')->nullable()->after('about');
            $table->text('vision')->nullable()->after('mission');
            $table->text('principal_message')->nullable()->after('vision');
            $table->string('principal_photo')->nullable()->after('principal_name');

            // Contact extras
            $table->string('website')->nullable()->after('school_email');
            $table->string('map_url')->nullable()->after('website');

            // Extra statistics
            $table->string('awards_count')->nullable()->after('facility_count_display');
            $table->string('courses_count')->nullable()->after('awards_count');
            $table->string('pass_rate')->nullable()->after('courses_count');

            // "Why Choose Us" feature cards (JSON)
            $table->json('features')->nullable()->after('social_links');

            // Section visibility toggles
            $table->boolean('show_hero')->default(true)->after('features');
            $table->boolean('show_about')->default(true)->after('show_hero');
            $table->boolean('show_stats')->default(true)->after('show_about');
            $table->boolean('show_programs')->default(true)->after('show_stats');
            $table->boolean('show_features')->default(true)->after('show_programs');
            $table->boolean('show_testimonials')->default(true)->after('show_features');
            $table->boolean('show_gallery')->default(false)->after('show_testimonials');
            $table->boolean('show_contact')->default(true)->after('show_gallery');
            $table->boolean('show_social')->default(true)->after('show_contact');
            $table->boolean('show_news')->default(false)->after('show_social');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_title', 'hero_subtitle', 'hero_description', 'hero_cta_text', 'hero_cta_link',
                'mission', 'vision', 'principal_message', 'principal_photo',
                'website', 'map_url',
                'awards_count', 'courses_count', 'pass_rate',
                'features',
                'show_hero', 'show_about', 'show_stats', 'show_programs', 'show_features',
                'show_testimonials', 'show_gallery', 'show_contact', 'show_social', 'show_news',
            ]);
        });
    }
};
