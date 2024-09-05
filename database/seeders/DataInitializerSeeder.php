<?php
//
//namespace Database\Seeders;
//
//use App\Models\Artist;
//use App\Models\Category;
//use App\Models\Country;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
//use Illuminate\Database\Seeder;
//use Illuminate\Support\Facades\Hash;
//
//class DataInitializerSeeder extends Seeder
//{
//    public function run()
//    {
//        $this->insertCountries();
//        $this->insertCategories();
//        $this->insertArtists();
////        $this->insertClients();
//    }
//
//    private function insertCountries()
//    {
//        $countryNames = [
//            "Afghanistan",
//            "Albania",
//            "Algeria",
//            "Andorra",
//            "Angola",
//            "Antigua and Barbuda",
//            "Argentina",
//            "Armenia",
//            "Australia",
//            "Austria",
//            "Azerbaijan",
//            "The Bahamas",
//            "Bahrain",
//            "Bangladesh",
//            "Barbados",
//            "Belarus",
//            "Belgium",
//            "Belize",
//            "Benin",
//            "Bhutan",
//            "Bolivia",
//            "Bosnia and Herzegovina",
//            "Botswana",
//            "Brazil",
//            "Brunei",
//            "Bulgaria",
//            "Burkina Faso",
//            "Burundi",
//            "Cabo Verde",
//            "Cambodia",
//            "Cameroon",
//            "Canada",
//            "Central African Republic",
//            "Chad",
//            "Chile",
//            "China",
//            "Colombia",
//            "Comoros",
//            "Congo, Democratic Republic of the",
//            "Congo, Republic of the",
//            "Costa Rica",
//            "Côte d’Ivoire",
//            "Croatia",
//            "Cuba",
//            "Cyprus",
//            "Czech Republic",
//            "Denmark",
//            "Djibouti",
//            "Dominica",
//            "Dominican Republic",
//            "East Timor (Timor-Leste)",
//            "Ecuador",
//            "Egypt",
//            "El Salvador",
//            "Equatorial Guinea",
//            "Eritrea",
//            "Estonia",
//            "Eswatini",
//            "Ethiopia",
//            "Fiji",
//            "Finland",
//            "France",
//            "Gabon",
//            "The Gambia",
//            "Georgia",
//            "Germany",
//            "Ghana",
//            "Greece",
//            "Grenada",
//            "Guatemala",
//            "Guinea",
//            "Guinea-Bissau",
//            "Guyana",
//            "Haiti",
//            "Honduras",
//            "Hungary",
//            "Iceland",
//            "India",
//            "Indonesia",
//            "Iran",
//            "Iraq",
//            "Ireland",
//            "Israel",
//            "Italy",
//            "Jamaica",
//            "Japan",
//            "Jordan",
//            "Kazakhstan",
//            "Kenya",
//            "Kiribati",
//            "Korea, North",
//            "Korea, South",
//            "Kosovo",
//            "Kuwait",
//            "Kyrgyzstan",
//            "Laos",
//            "Latvia",
//            "Lebanon",
//            "Lesotho",
//            "Liberia",
//            "Liechtenstein",
//            "Lithuania",
//            "Luxembourg",
//            "Madagascar",
//            "Malawi",
//            "Malaysia",
//            "Maldives",
//            "Mali",
//            "Malta",
//            "Marshall Islands",
//            "Mauritania",
//            "Mauritius",
//            "Mexico",
//            "Micronesia, Federated States of",
//            "Moldova",
//            "Monaco",
//            "Mongolia",
//            "Montenegro",
//            "Morocco",
//            "Mozambique",
//            "Myanmar (Burma)",
//            "Namibia",
//            "Nauru",
//            "Nepal",
//            "Netherlands",
//            "New Zealand",
//            "Nicaragua",
//            "Niger",
//            "Nigeria",
//            "North Macedonia",
//            "Norway",
//            "Oman",
//            "Pakistan",
//            "Palau",
//            "Panama",
//            "Papua New Guinea",
//            "Paraguay",
//            "Peru",
//            "Philippines",
//            "Poland",
//            "Portugal",
//            "Qatar",
//            "Romania",
//            "Russia",
//            "Rwanda",
//            "Saint Kitts and Nevis",
//            "Saint Lucia",
//            "Saint Vincent and the Grenadines",
//            "Samoa",
//            "San Marino",
//            "Sao Tome and Principe",
//            "Saudi Arabia",
//            "Senegal",
//            "Serbia",
//            "Seychelles",
//            "Sierra Leone",
//            "Singapore",
//            "Slovakia",
//            "Slovenia",
//            "Solomon Islands",
//            "Somalia",
//            "South Africa",
//            "Spain",
//            "Sri Lanka",
//            "Sudan",
//            "Sudan, South",
//            "Suriname",
//            "Sweden",
//            "Switzerland",
//            "Syria",
//            "Taiwan",
//            "Tajikistan",
//            "Tanzania",
//            "Thailand",
//            "Togo",
//            "Tonga",
//            "Trinidad and Tobago",
//            "Tunisia",
//            "Turkey",
//            "Turkmenistan",
//            "Tuvalu",
//            "Uganda",
//            "Ukraine",
//            "United Arab Emirates",
//            "United Kingdom",
//            "United States",
//            "Uruguay",
//            "Uzbekistan",
//            "Vanuatu",
//            "Vatican City",
//            "Venezuela",
//            "Vietnam",
//            "Yemen",
//            "Zambia",
//            "Zimbabwe"
//        ];
//
//        foreach ($countryNames as $countryName) {
//            Country::create(['country' => $countryName]);
//        }
//    }
//
//    private function insertCategories()
//    {
//        $categoryNames = [
//            "Vector Painting",
//            "3D Modeling",
//            "Digital Painting",
//            "2D Digital Painting",
//            "3D Digital Painting And Sculpting",
//            "Pixel Art",
//            "Raster Painting",
//            "2D Animation",
//            "3D Animation",
//            "Logos",
//            "Photo Painting",
//            "Digital Collage",
//            "CGI Art",
//            "Fractal Art"
//        ];
//
//        foreach ($categoryNames as $categoryName) {
//            Category::create(['category' => $categoryName]);
//        }
//    }
//
//    private function insertArtists()
//    {
//
//        $artist1 = new Artist([
//                'name' => 'Emily Chang',
//                'username' => 'emily.chang',
//                'password' => Hash::make('emily123'),
//                'age' => 35,
//                'jobTitle' => 'Graphic Designer',
//                'hourlyRate' => 12.5,
//                'summary' => "Hi there! I'm Emily Chang, a graphic designer...",
//                'countryId' => 125, // Ensure this matches your schema
//                'portfolio' => '/resources/uploads/emily.chang-portfolio.pdf',
//                'profilePicture' => '/resources/uploads/emily.chang-profile-picture.png',
//                'role' => 'ARTIST', // Include the role if required
//            ]);
//        $artist1->save();
//        $artist2 = new Artist(
//
//            [
//                'name' => 'Jamal Patel',
//                'username' => 'jamal.patel',
//                'password' => Hash::make('jamal123'),
//                'age' => 30,
//                'jobTitle' => 'Illustrator',
//                'hourlyRate' => 10.0,
//                'summary' => "Hey, I'm Jamal Patel...",
//                'countryId' => 163, // Ensure this matches your schema
//                'portfolio' => '/resources/uploads/jamal.patel-portfolio.pdf',
//                'profilePicture' => '/resources/uploads/jamal.patel-profile-picture.png',
//                'role' => 'ARTIST', // Include the role if required
//            ]);
//            // Add more artists as needed
//        $artist2->save();
//
//    }
////        $artist3 = new Artist([
////            'name' => 'José Pedro Cortes',
////            'user_name' => 'jose.pedro',
////            'user_password' => Hash::make('jose123'),
////            'age' => 25,
////            'job_title' => 'Graphic Designer',
////            'hourly_rate' => 14.30,
////            'summary' => "I'm José Pedro Cortes, a concept artist who brings imagination to reality through conceptual design and visual development. With a background in storytelling and a passion for world-building, I create concept art that sets the stage for immersive experiences in entertainment and media.",
////            'country_id' => 84, // Adjust if necessary
////            'portfolio' => '/resources/uploads/jose.pedro-portfolio.pdf',
////            'profile_picture' => '/resources/uploads/jose.pedro-profile-picture.png',
////        ]);
////        $artist3->save();
////
////        $artist4 = new Artist([
////            'name' => 'Mia Johnson',
////            'user_name' => 'mia.johnson',
////            'user_password' => Hash::make('mia123'),
////            'age' => 28,
////            'job_title' => 'Digital Sculptor',
////            'hourly_rate' => 15.00,
////            'summary' => "I'm Mia Johnson, a digital sculptor who shapes virtual clay into digital masterpieces. With a blend of technical skill and artistic vision, I sculpt characters and creatures that come to life in digital worlds, bridging the gap between imagination and reality.",
////            'country_id' => 125, // Adjust if necessary
////            'portfolio' => '/resources/uploads/mia.johnson-portfolio.pdf',
////            'profile_picture' => '/resources/uploads/mia.johnson-profile-picture.png',
////        ]);
////        $artist4->save();
////
////        $artist5 = new Artist([
////            'name' => 'Liam Carter',
////            'user_name' => 'liam.carter',
////            'user_password' => Hash::make('liam123'),
////            'age' => 45,
////            'job_title' => 'Motion Graphics Designer',
////            'hourly_rate' => 14.5,
////            'summary' => "I'm Liam Carter, a motion graphics designer who adds dynamic visuals and storytelling to digital content. From animated logos to cinematic sequences, I use motion graphics to enhance narratives and engage audiences in the digital realm.",
////            'country_id' => 84, // Adjust if necessary
////            'portfolio' => '/resources/uploads/liam.carter-portfolio.pdf',
////            'profile_picture' => '/resources/uploads/liam.carter-profile-picture.png',
////        ]);
////        $artist5->save();
////
////        $artist6 = new Artist([
////            'name' => 'Eugène Delacroix',
////            'user_name' => 'eugene.delacroix',
////            'user_password' => Hash::make('eugene123'),
////            'age' => 63,
////            'job_title' => 'Augmented Reality Designer',
////            'hourly_rate' => 13.13,
////            'summary' => "An augmented reality designer pushing the boundaries of interactive digital experiences. With AR technology, I blend digital content with the real world, creating engaging and interactive installations that blur the line between reality and imagination.",
////            'country_id' => 62, // Adjust if necessary
////            'portfolio' => '/resources/uploads/eugene.delacroix-portfolio.pdf',
////            'profile_picture' => '/resources/uploads/eugene.delacroix-profile-picture.png',
////        ]);
////        $artist6->save();
////
////        $artist7 = new Artist([
////            'name' => 'Lia Thompson',
////            'user_name' => 'lia.thompson',
////            'user_password' => Hash::make('lia123'),
////            'age' => 23,
////            'job_title' => 'Visual Effects Artist',
////            'hourly_rate' => 9.0,
////            'summary' => "I'm Lia Thompson, a visual effects artist specializing in digital effects for film and television. With a blend of technical skill and creative flair, I create stunning visual effects that seamlessly integrate with live-action footage, bringing cinematic visions to life on screen.",
////            'country_id' => 86, // Adjust if necessary
////            'portfolio' => '/resources/uploads/lia.thompson-portfolio.pdf',
////            'profile_picture' => '/resources/uploads/lia.thompson-profile-picture.png',
////        ]);
////        $artist7->save();
////
////        $artist8 = new Artist([
////            'name' => 'Liam Brooks',
////            'user_name' => 'liam.brooks',
////            'user_password' => Hash::make('liam123'),
////            'age' => 32,
////            'job_title' => 'Digital Animator',
////            'hourly_rate' => 21.20,
////            'summary' => "I'm Liam Brooks, a digital animator who breathes life into characters and stories through animation. With a passion for movement and expression, I create dynamic animations that entertain and inspire, pushing the boundaries of storytelling in the digital age.",
////            'country_id' => 68, // Adjust if necessary
////            'portfolio' => '/resources/uploads/liam.brooks-portfolio.pdf',
////            'profile_picture' => '/resources/uploads/liam.brooks-profile-picture.png',
////        ]);
////        $artist8->save();
////    }
//
//    private function insertClients() {
//
//        $client1 = new Client([
//            'name' => 'John Smith',
//            'user_name' => 'john.smith',
//            'user_password' => Hash::make('john123'),
//            'age' => 25,
//            'country_id' => 186, // Adjust if necessary
//            'profile_picture' => '/resources/uploads/john.smith-profile-picture.jpg',
//        ]);
//        $client1->save();
//
//        $client2 = new Client([
//            'name' => 'Emma Brown',
//            'user_name' => 'emma.brown',
//            'user_password' => Hash::make('emma123'),
//            'age' => 30,
//            'country_id' => 32, // Adjust if necessary
//            'profile_picture' => '/resources/uploads/emma.brown-profile-picture.jpg',
//        ]);
//        $client2->save();
//
//        $client3 = new Client([
//            'name' => 'Michael Lee',
//            'user_name' => 'michael.lee',
//            'user_password' => Hash::make('michael123'),
//            'age' => 35,
//            'country_id' => 9, // Adjust if necessary
//            'profile_picture' => '/resources/uploads/michael.lee-profile-picture.jpg',
//        ]);
//        $client3->save();
//
//        $client4 = new Client([
//            'name' => 'Sarah Jones',
//            'user_name' => 'sarah.jones',
//            'user_password' => Hash::make('sarah123'),
//            'age' => 28,
//            'country_id' => 185, // Adjust if necessary
//            'profile_picture' => '/resources/uploads/sarah.jones-profile-picture.jpg',
//        ]);
//        $client4->save();
//
//        $client5 = new Client([
//            'name' => 'David Wang',
//            'user_name' => 'david.wang',
//            'user_password' => Hash::make('david123'),
//            'age' => 22,
//            'country_id' => 36, // Adjust if necessary
//            'profile_picture' => '/resources/uploads/david.wang-profile-picture.jpg',
//        ]);
//        $client5->save();
//
//    }
//
//}
