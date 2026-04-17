<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CmsPage::updateOrCreate(
            ['slug' => 'terms-and-conditions'],
            [
                'title' => 'Terms & Service',
                'content' => json_encode([
                    'version' => '2.1',
                    'date' => 'JAN 2024',
                    'main_title' => 'Terms of Use',
                    'intro' => 'Welcome to EcoVolt Energy. By using this platform, you agree to comply with our terms of service provided below.',
                    'sections' => [
                        [
                            'id' => '01',
                            'title' => 'Acceptance of Scope',
                            'text' => 'These terms govern your access to the EcoVolt application and all services related to solar energy monitoring and installation processing.'
                        ],
                        [
                            'id' => '02',
                            'title' => 'Member Obligations',
                            'text' => 'You agree to provide accurate registration data and maintenance access to authorized solar técnicos for your installation site when required.'
                        ],
                        [
                            'id' => '03',
                            'title' => 'Data Accuracy',
                            'text' => 'Usage insights are based on IoT sensor data. While highly accurate, they are for informational purposes only and not final billing evidence.'
                        ]
                    ]
                ])
            ]
        );

        \App\Models\CmsPage::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'title' => 'Data Privacy',
                'content' => json_encode([
                    'version' => '1.4',
                    'date' => 'JAN 2024',
                    'main_title' => 'Privacy Policy',
                    'intro' => 'Your data is encrypted with AES-256 enterprise standard. EcoVolt is committed to protecting your personal information.',
                    'sections' => [
                        [
                            'id' => 'inf-harv',
                            'title' => 'Information Harvesting',
                            'text' => 'We collect basic identification and geolocation to map solar efficiency and technical support.',
                            'icon' => 'database-search'
                        ],
                        [
                            'id' => 'enc-stor',
                            'title' => 'Encrypted Storage',
                            'text' => 'All your payment credentials and personal IDs are stored in ISO/IEC 27001 certified cloud environments.',
                            'icon' => 'shield-lock'
                        ],
                        [
                            'id' => 'acc-ctrl',
                            'title' => 'Access Control',
                            'text' => 'Only you and authorized solar installers can view relevant project data during the implementation phase.',
                            'icon' => 'key-chain'
                        ]
                    ]
                ])
            ]
        );
    }
}
