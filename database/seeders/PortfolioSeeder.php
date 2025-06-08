<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PersonalInfo;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Certification;
use App\Models\ContactInfo;
use App\Models\SocialLink;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Personal Information
        $personalInfos = [
            ['label' => 'Name', 'value' => 'Kenneth John C. Ribay', 'sort_order' => 1],
            ['label' => 'Age', 'value' => '23 years old', 'sort_order' => 2],
            ['label' => 'Location', 'value' => 'Philippines', 'sort_order' => 3],
            ['label' => 'Experience', 'value' => '1+ Years', 'sort_order' => 4],
            ['label' => 'Languages', 'value' => 'English, Filipino', 'sort_order' => 5],
            ['label' => 'Availability', 'value' => 'Open to opportunities', 'sort_order' => 6],
        ];

        foreach ($personalInfos as $info) {
            PersonalInfo::create(array_merge($info, ['is_active' => true]));
        }

        // Skills based on your current portfolio
        $skills = [
            // Frontend Technologies
            ['name' => 'Vue.js', 'category' => 'frontend', 'proficiency' => 85],
            ['name' => 'JavaScript', 'category' => 'frontend', 'proficiency' => 88],
            ['name' => 'TypeScript', 'category' => 'frontend', 'proficiency' => 75],
            ['name' => 'React', 'category' => 'frontend', 'proficiency' => 70],
            ['name' => 'HTML5', 'category' => 'frontend', 'proficiency' => 95],
            ['name' => 'CSS3', 'category' => 'frontend', 'proficiency' => 90],
            ['name' => 'Tailwind CSS', 'category' => 'frontend', 'proficiency' => 85],
            ['name' => 'Sass', 'category' => 'frontend', 'proficiency' => 80],

            // Backend Technologies
            ['name' => 'Laravel', 'category' => 'backend', 'proficiency' => 90],
            ['name' => 'PHP', 'category' => 'backend', 'proficiency' => 90],
            ['name' => 'Node.js', 'category' => 'backend', 'proficiency' => 75],
            ['name' => 'Express.js', 'category' => 'backend', 'proficiency' => 70],
            ['name' => 'REST API', 'category' => 'backend', 'proficiency' => 85],

            // Database & Cloud
            ['name' => 'MySQL', 'category' => 'database', 'proficiency' => 85],
            ['name' => 'PostgreSQL', 'category' => 'database', 'proficiency' => 75],
            ['name' => 'MongoDB', 'category' => 'database', 'proficiency' => 70],
            ['name' => 'Redis', 'category' => 'database', 'proficiency' => 65],

            // Tools & DevOps
            ['name' => 'Git', 'category' => 'tools', 'proficiency' => 85],
            ['name' => 'Docker', 'category' => 'tools', 'proficiency' => 70],
            ['name' => 'AWS', 'category' => 'cloud', 'proficiency' => 65],
            ['name' => 'Linux', 'category' => 'tools', 'proficiency' => 75],
        ];

        foreach ($skills as $skill) {
            Skill::create(array_merge($skill, ['is_active' => true]));
        }

        // Projects based on your current portfolio
        $projects = [
            [
                'title' => 'E-commerce Platform',
                'description' => 'A comprehensive e-commerce solution built with Laravel and Vue.js, featuring user authentication, product management, shopping cart, and payment integration.',
                'technologies' => json_encode(['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS', 'Stripe']),
                'github_url' => 'https://github.com/kennethjohnribay/ecommerce-platform',
                'live_url' => 'https://ecommerce-demo.kennethjohnribay.com',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'Task Management System',
                'description' => 'A collaborative task management application with real-time updates, team collaboration features, and project tracking.',
                'technologies' => json_encode(['Laravel', 'Vue.js', 'WebSockets', 'MySQL']),
                'github_url' => 'https://github.com/kennethjohnribay/task-manager',
                'live_url' => 'https://tasks.kennethjohnribay.com',
                'is_featured' => true,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'Portfolio Website',
                'description' => 'A modern, responsive portfolio website showcasing my projects and skills, built with Laravel and Vue.js.',
                'technologies' => json_encode(['Laravel', 'Vue.js', 'Inertia.js', 'Tailwind CSS']),
                'github_url' => 'https://github.com/kennethjohnribay/portfolio',
                'live_url' => 'https://kennethjohnribay.com',
                'is_featured' => false,
                'is_active' => true,
                'sort_order' => 3
            ]
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }

        // Experience
        Experience::create([
            'title' => 'Computer Programmer',
            'company' => 'Provincial Government of Camarines Sur',
            'location' => 'Camarines Sur, Philippines',
            'start_date' => '2024-01-01',
            'end_date' => null,
            'description' => 'Developing and maintaining web systems for various government departments, addressing user feedback, and providing technical support.',
            'responsibilities' => json_encode([
                'Develop and maintain web applications using Laravel and Vue.js',
                'Design and optimize database schemas',
                'Implement responsive user interfaces',
                'Deploy applications to production environments',
                'Collaborate with clients to gather requirements',
                'Provide technical support and training to system users'
            ]),
            'technologies' => json_encode(['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS']),
            'is_current' => true,
            'is_active' => true
        ]);

        // Education
        Education::create([
            'degree' => 'Bachelor of Science in Information Technology',
            'field_of_study' => 'Information Technology',
            'institution' => 'Bicol University – Polangui',
            'location' => 'Camarines Sur, Philippines',
            'start_date' => '2019-08-01',
            'end_date' => '2023-07-31',
            'gpa' => 'Cum Laude',
            'description' => 'Specialized in web development, database management, and software engineering principles.',
            'achievements' => json_encode([
                'Graduated Cum Laude',
                'Led the development team for capstone project',
                'Completed advanced courses in web development',
                'Dean\'s List for multiple semesters'
            ]),
            'is_current' => false,
            'is_active' => true
        ]);

        // Contact Information
        $contactInfos = [
            [
                'type' => 'email',
                'label' => 'Email',
                'value' => 'kennethjohnribay@gmail.com',
                'href' => 'mailto:kennethjohnribay@gmail.com',
                'icon' => 'email',
                'sort_order' => 1
            ],
            [
                'type' => 'phone',
                'label' => 'Phone',
                'value' => '+63 916 551 7358',
                'href' => 'tel:+639165517358',
                'icon' => 'phone',
                'sort_order' => 2
            ],
            [
                'type' => 'location',
                'label' => 'Location',
                'value' => 'Camarines Sur, Philippines',
                'href' => '#',
                'icon' => 'location',
                'sort_order' => 3
            ]
        ];

        foreach ($contactInfos as $contact) {
            ContactInfo::create(array_merge($contact, ['is_active' => true]));
        }

        // Social Links
        $socialLinks = [
            [
                'name' => 'GitHub',
                'url' => 'https://github.com/kennethjohnribay',
                'icon' => 'github',
                'sort_order' => 1
            ],
            [
                'name' => 'LinkedIn',
                'url' => 'https://linkedin.com/in/kennethjohnribay',
                'icon' => 'linkedin',
                'sort_order' => 2
            ],
            [
                'name' => 'Facebook',
                'url' => 'https://facebook.com/kennethjohn.ribay',
                'icon' => 'facebook',
                'sort_order' => 3
            ]
        ];

        foreach ($socialLinks as $social) {
            SocialLink::create(array_merge($social, ['is_active' => true]));
        }

        // Sample Certifications
        $certifications = [
            [
                'name' => 'Civil Service Eligibility (Professional)',
                'issuer' => 'CSPC, Nabua, Camarines Sur',
                'issue_date' => '2023-03-26',
                'expiry_date' => null,
                'credential_id' => 'CSE-2023-001',
                'credential_url' => null,
                'description' => 'Professional level civil service eligibility with rating of 81.33.',
                'is_active' => true
            ],
            [
                'name' => 'Laravel Certified Developer',
                'issuer' => 'Laravel',
                'issue_date' => '2023-06-15',
                'expiry_date' => null,
                'credential_id' => 'LARAVEL-2023-001',
                'credential_url' => 'https://certificates.laravel.com/123456',
                'description' => 'Certified Laravel developer with expertise in framework fundamentals and advanced features.',
                'is_active' => true
            ]
        ];

        foreach ($certifications as $cert) {
            Certification::create($cert);
        }
    }
}
