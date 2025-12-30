<?php

namespace Database\Seeders;

use App\Models\LandingPageAsset;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            'hero_bg' => [
                'description' => 'Main Hero Background',
                'url' => 'https://picsum.photos/1920/1080?blur=2', // Placeholder
            ],
            'feature_cases' => [
                'description' => 'Feature: Case Management',
                'url' => 'https://picsum.photos/600/400?random=1',
            ],
            'feature_evidence' => [
                'description' => 'Feature: Evidence Chain',
                'url' => 'https://picsum.photos/600/400?random=2',
            ],
            'feature_calendar' => [
                'description' => 'Feature: Judicial Calendar',
                'url' => 'https://picsum.photos/600/400?random=3',
            ],
            'dashboard_preview' => [
                'description' => 'Dashboard UI Preview',
                'url' => 'https://picsum.photos/1200/800?grayscale',
            ],
        ];

        foreach ($assets as $key => $data) {
            $asset = LandingPageAsset::firstOrCreate(
                ['asset_key' => $key],
                ['description' => $data['description']]
            );

            if ($asset->getMedia('default')->isEmpty()) {
                // Check for local file first
                $localFiles = glob(database_path("seeders/images/{$key}.*"));

                if (!empty($localFiles)) {
                    $asset->addMedia($localFiles[0])
                        ->preservingOriginal()
                        ->toMediaCollection('default');
                    $this->command->info("Seeded local image for: {$key}");
                } else {
                    // Fallback to URL
                    try {
                        $asset->addMediaFromUrl($data['url'])
                            ->toMediaCollection('default');
                    } catch (\Exception $e) {
                        $this->command->warn("Could not seed image for {$key}: " . $e->getMessage());
                    }
                }
            }
        }
    }
}
