<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebContents;

class WebContentSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        WebContents::truncate();
        $json = [
            ["parent_page" => "Help & FAQ", "web_page" => "Getting Started - Buying", "slug" => "buying_started"],
            ["parent_page" => "Help & FAQ", "web_page" => "Getting Started - Selling", "slug" => "selling_started"],
            ["parent_page" => "Help & FAQ", "web_page" => "Account Management", "slug" => "account_mgnt"],
            ["parent_page" => "Help & FAQ", "web_page" => "Policies & Documents", "slug" => "policies_documents"],
            ["parent_page" => "Help & FAQ", "web_page" => "Copyright /Intellectual Property", "slug" => "copyright_intellectual_property"],
            ["parent_page" => "Help & FAQ", "web_page" => "Payment Systems", "slug" => "payment_system"],
            ["parent_page" => "Help & FAQ", "web_page" => "Classroom Contributions", "slug" => "classroom_contributions"],
            ["parent_page" => "Documents & Policies", "web_page" => "Privacy Policy", "slug" => "privacy_policy"],
            ["parent_page" => "Documents & Policies", "web_page" => "Terms & Conditions", "slug" => "terms_policy"],
            ["parent_page" => "Documents & Policies", "web_page" => "Taxation Policy", "slug" => "taxation_policy"],
            ["parent_page" => "Documents & Policies", "web_page" => "Seller Agreement", "slug" => "seller_agreement"],
            ["parent_page" => "Documents & Policies", "web_page" => "Intellectual Property", "slug" => "intellectual_property"],
            ["parent_page" => "Documents & Policies", "web_page" => "Refund Policy", "slug" => "refund_policy"]
        ];
        for ($i = 0; $i < count($json); $i++) {
            WebContents::create([
                'parent_page' => $json[$i]['parent_page'],
                'web_page' => $json[$i]['web_page'],
                'slug' => $json[$i]['slug']
            ]);
        }
    }

}
