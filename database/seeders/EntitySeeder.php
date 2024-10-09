<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entities')->insert([
            [
                'company_name' => 'Celergen International Limited',
                'address' => "Unit 2204, 22/F, Lippo Centre, Tower 2\n89 Queensway\nHong Kong",
                'country' => 'China',
                'postal_code' => 12345,
                'business_reg_number' => '1769402',
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'Celergen International Limited',
                'bank_account_number' => '817-591514-838',
                'currency' => 'USD',
                'bank_name' => 'HSBC Hong Kong',
                'bank_address' => "1 Queen's Road Central Hong Kong",
                'bank_swift_code' => 'HSBCHKHHHKH',
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1, // Assuming Su Ying Ong's id is 1
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Caviarlieri Limited',
                'address' => "2502, 25/F - 148 Electric Road,\nNorth Point,\nHong Kong",
                'country' => 'China',
               'postal_code' => 12345,
                'business_reg_number' => 'N/A', // Changed from null to 'N/A'
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'Caviarlieri Limited',
                'bank_account_number' => '000578582',
                'currency' => 'USD',
                'bank_name' => 'DBS Bank (Hong Kong) Limited',
                'bank_address' => "11th Floor, The Center, 99 Queens's Road\nCentral, Hong Kong",
                'bank_swift_code' => 'DHBKHKHH',
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Silicon Apple Pte Ltd',
                'address' => "80 Marine Parade Road\n#13-02, Parkway Parade",
                'country' => 'Singapore',
                'postal_code' => '449269',
                'business_reg_number' => '198203957E',
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'Silicon Apple Pte Ltd',
                'bank_account_number' => '0106121715',
                'currency' => 'N/A', // Changed from null to 'N/A'
                'bank_name' => 'Standard Chartered Bank (Singapore) Limited',
                'bank_address' => 'Battery Road Branch, 6 Battery Road, Singapore 049909',
                'bank_swift_code' => 'SCBLSG22XXX',
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Caviarlieri Co.,Ltd',
                'address' => "4 Chan16 Yak 12-2 Road\nTungwatdon\nSathorn Bangkok",
                'country' => 'Thailand',
                'postal_code' => '10120',
                'business_reg_number' => 'N/A', // Changed from null to 'N/A'
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'N/A', // Changed from null to 'N/A'
                'bank_account_number' => '411-101523-5',
                'currency' => 'N/A', // Changed from null to 'N/A'
                'bank_name' => 'Siam Commercial Bank (SCB)',
                'bank_address' => 'N/A', // Changed from null to 'N/A'
                'bank_swift_code' => 'N/A', // Changed from null to 'N/A'
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Celergen Thailand',
                'address' => "2 Chan 16 Yeak 12-2\nSathorn Bangkok",
                'country' => 'Thailand',
               'postal_code' => 12345,
                'business_reg_number' => '105553018241',
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'N/A', // Changed from null to 'N/A'
                'bank_account_number' => '1243093414',
                'currency' => 'THB',
                'bank_name' => 'Bangkok Bank PLC',
                'bank_address' => 'N/A', // Changed from null to 'N/A'
                'bank_swift_code' => 'N/A', // Changed from null to 'N/A'
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Suisse Laboratories Cell Therapy, Inc.',
                'address' => "Unit 8A, 3rd Floor, Il Terrazzo Mall\n305 Tomas Morato corner Scout Madrinan Street\nSouth Triangle 1103, Quezon City",
                'country' => 'Philippines',
               'postal_code' => 12345,
                'business_reg_number' => 'N/A', // Changed from null to 'N/A'
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'N/A', // Changed from null to 'N/A'
                'bank_account_number' => '002-210-002-042',
                'currency' => 'N/A', // Changed from null to 'N/A'
                'bank_name' => 'Unionbank',
                'bank_address' => 'N/A', // Changed from null to 'N/A'
                'bank_swift_code' => 'N/A', // Changed from null to 'N/A'
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Celergen SA',
                'address' => '2C Rue Nicolas Bové',
                'country' => 'Luxembourg',
                'postal_code' => 'L-1253',
                'business_reg_number' => 'B 201378',
                'vat_number' => 'LU28083742',
                'bank_account_name' => 'Celergen SA',
                'bank_account_number' => 'LU883430002214691200',
                'currency' => 'EUR',
                'bank_name' => 'EFG Bank (Luxembourg) S.A.',
                'bank_address' => '56 Grand-Rue - BP385 L2013 Luxembourg',
                'bank_swift_code' => 'EFGBLULX',
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'SWISS INSTITUTE OF KLOTHO RESEARCH AG',
                'address' => "Industriestrasse 28,\n9100 Herisau",
                'country' => 'Switzerland',
               'postal_code' => 12345,
                'business_reg_number' => 'N/A', // Changed from null to 'N/A'
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'N/A', // Changed from null to 'N/A'
                'bank_account_number' => 'N/A', // Changed from null to 'N/A'
                'currency' => 'N/A', // Changed from null to 'N/A'
                'bank_name' => 'N/A', // Changed from null to 'N/A'
                'bank_address' => 'N/A', // Changed from null to 'N/A'
                'bank_swift_code' => 'N/A', // Changed from null to 'N/A'
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Swiss Caviarlieri Limited (HK)',
                'address' => "Unit 2204, 22/F, Lippo Centre, Tower 2,\n89, Queensway\nHong Kong",
                'country' => 'China',
               'postal_code' => 12345,
                'business_reg_number' => 'N/A', // Changed from null to 'N/A'
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'N/A', // Changed from '?' to 'N/A'
                'bank_account_number' => '817-591514-838',
                'currency' => 'USD',
                'bank_name' => 'HSBC Hong Kong',
                'bank_address' => "1 Queen's Road Central Hong Kong",
                'bank_swift_code' => 'HSBCHKHHHKH',
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Suisse Wellness Limited (HK)',
                'address' => "Unit 2204, 22/F, Lippo Centre, Tower 2,\n89, Queensway\nHong Kong",
                'country' => 'China',
               'postal_code' => 12345,
                'business_reg_number' => 'N/A', // Changed from null to 'N/A'
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'N/A', // Changed from '?' to 'N/A'
                'bank_account_number' => '817-591514-838',
                'currency' => 'USD',
                'bank_name' => 'HSBC Hong Kong',
                'bank_address' => "1 Queen's Road Central Hong Kong",
                'bank_swift_code' => 'HSBCHKHHHKH',
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'SWISS CAVIARLIERI MALAYSIA SDN BHD',
                'address' => "SUITE 8-1-18, 1ST FLOOR, MENARA MUTIARA BANGSAR\nJALAN LIKU OFF JALAN RIONG, BANGSAR",
                'country' => 'Malaysia',
                'postal_code' => '59100',
                'business_reg_number' => '140572W',
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'N/A', // Changed from null to 'N/A'
                'bank_account_number' => 'N/A', // Changed from null to 'N/A'
                'currency' => 'N/A', // Changed from null to 'N/A'
                'bank_name' => 'N/A', // Changed from null to 'N/A'
                'bank_address' => 'N/A', // Changed from null to 'N/A'
                'bank_swift_code' => 'N/A', // Changed from null to 'N/A'
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'company_name' => 'Empire Centre for Regenerative Medicine',
                'address' => "Unit 8A, 3rd Floor Il Terrazzo\n305 Tomas Morato corner Scout Madrinan St.\nSouth Triangle 1103, Quezon City",
                'country' => 'Philippines',
               'postal_code' => 12345,
                'business_reg_number' => 'N/A', // Changed from null to 'N/A'
                'vat_number' => 'N/A', // Changed from null to 'N/A'
                'bank_account_name' => 'N/A', // Changed from null to 'N/A'
                'bank_account_number' => 'N/A', // Changed from null to 'N/A'
                'currency' => 'N/A', // Changed from null to 'N/A'
                'bank_name' => 'N/A', // Changed from null to 'N/A'
                'bank_address' => 'N/A', // Changed from null to 'N/A'
                'bank_swift_code' => 'N/A', // Changed from null to 'N/A'
                'bank_iban_number' => 'N/A', // Changed from null to 'N/A'
                'bank_code' => 'N/A', // Changed from null to 'N/A'
                'bank_branch_code' => 'N/A', // Changed from null to 'N/A'
                'created_by' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
