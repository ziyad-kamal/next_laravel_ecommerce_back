<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            // Cairo Governorate
            ['name' => 'Cairo', 'governorate' => 'Cairo', 'trans_lang' => 'en'],
            ['name' => 'القاهرة', 'governorate' => 'القاهرة', 'trans_lang' => 'ar'],
            ['name' => 'Nasr City', 'governorate' => 'Cairo', 'trans_lang' => 'en'],
            ['name' => 'مدينة نصر', 'governorate' => 'القاهرة', 'trans_lang' => 'ar'],
            ['name' => 'Heliopolis', 'governorate' => 'Cairo', 'trans_lang' => 'en'],
            ['name' => 'مصر الجديدة', 'governorate' => 'القاهرة', 'trans_lang' => 'ar'],
            ['name' => 'Maadi', 'governorate' => 'Cairo', 'trans_lang' => 'en'],
            ['name' => 'المعادي', 'governorate' => 'القاهرة', 'trans_lang' => 'ar'],

            // Giza Governorate
            ['name' => 'Giza', 'governorate' => 'Giza', 'trans_lang' => 'en'],
            ['name' => 'الجيزة', 'governorate' => 'الجيزة', 'trans_lang' => 'ar'],
            ['name' => '6th of October', 'governorate' => 'Giza', 'trans_lang' => 'en'],
            ['name' => '6 أكتوبر', 'governorate' => 'الجيزة', 'trans_lang' => 'ar'],
            ['name' => 'Sheikh Zayed', 'governorate' => 'Giza', 'trans_lang' => 'en'],
            ['name' => 'الشيخ زايد', 'governorate' => 'الجيزة', 'trans_lang' => 'ar'],

            // Alexandria Governorate
            ['name' => 'Alexandria', 'governorate' => 'Alexandria', 'trans_lang' => 'en'],
            ['name' => 'الإسكندرية', 'governorate' => 'الإسكندرية', 'trans_lang' => 'ar'],
            ['name' => 'Borg El Arab', 'governorate' => 'Alexandria', 'trans_lang' => 'en'],
            ['name' => 'برج العرب', 'governorate' => 'الإسكندرية', 'trans_lang' => 'ar'],

            // Qalyubia Governorate
            ['name' => 'Banha', 'governorate' => 'Qalyubia', 'trans_lang' => 'en'],
            ['name' => 'بنها', 'governorate' => 'القليوبية', 'trans_lang' => 'ar'],
            ['name' => 'Qalyub', 'governorate' => 'Qalyubia', 'trans_lang' => 'en'],
            ['name' => 'قليوب', 'governorate' => 'القليوبية', 'trans_lang' => 'ar'],
            ['name' => 'Shubra El Kheima', 'governorate' => 'Qalyubia', 'trans_lang' => 'en'],
            ['name' => 'شبرا الخيمة', 'governorate' => 'القليوبية', 'trans_lang' => 'ar'],

            // Port Said Governorate
            ['name' => 'Port Said', 'governorate' => 'Port Said', 'trans_lang' => 'en'],
            ['name' => 'بورسعيد', 'governorate' => 'بورسعيد', 'trans_lang' => 'ar'],

            // Suez Governorate
            ['name' => 'Suez', 'governorate' => 'Suez', 'trans_lang' => 'en'],
            ['name' => 'السويس', 'governorate' => 'السويس', 'trans_lang' => 'ar'],

            // Luxor Governorate
            ['name' => 'Luxor', 'governorate' => 'Luxor', 'trans_lang' => 'en'],
            ['name' => 'الأقصر', 'governorate' => 'الأقصر', 'trans_lang' => 'ar'],

            // Aswan Governorate
            ['name' => 'Aswan', 'governorate' => 'Aswan', 'trans_lang' => 'en'],
            ['name' => 'أسوان', 'governorate' => 'أسوان', 'trans_lang' => 'ar'],

            // Asyut Governorate
            ['name' => 'Asyut', 'governorate' => 'Asyut', 'trans_lang' => 'en'],
            ['name' => 'أسيوط', 'governorate' => 'أسيوط', 'trans_lang' => 'ar'],

            // Beheira Governorate
            ['name' => 'Damanhur', 'governorate' => 'Beheira', 'trans_lang' => 'en'],
            ['name' => 'دمنهور', 'governorate' => 'البحيرة', 'trans_lang' => 'ar'],

            // Beni Suef Governorate
            ['name' => 'Beni Suef', 'governorate' => 'Beni Suef', 'trans_lang' => 'en'],
            ['name' => 'بني سويف', 'governorate' => 'بني سويف', 'trans_lang' => 'ar'],

            // Dakahlia Governorate
            ['name' => 'Mansoura', 'governorate' => 'Dakahlia', 'trans_lang' => 'en'],
            ['name' => 'المنصورة', 'governorate' => 'الدقهلية', 'trans_lang' => 'ar'],
            ['name' => 'Talkha', 'governorate' => 'Dakahlia', 'trans_lang' => 'en'],
            ['name' => 'طلخا', 'governorate' => 'الدقهلية', 'trans_lang' => 'ar'],

            // Damietta Governorate
            ['name' => 'Damietta', 'governorate' => 'Damietta', 'trans_lang' => 'en'],
            ['name' => 'دمياط', 'governorate' => 'دمياط', 'trans_lang' => 'ar'],

            // Faiyum Governorate
            ['name' => 'Faiyum', 'governorate' => 'Faiyum', 'trans_lang' => 'en'],
            ['name' => 'الفيوم', 'governorate' => 'الفيوم', 'trans_lang' => 'ar'],

            // Gharbia Governorate
            ['name' => 'Tanta', 'governorate' => 'Gharbia', 'trans_lang' => 'en'],
            ['name' => 'طنطا', 'governorate' => 'الغربية', 'trans_lang' => 'ar'],
            ['name' => 'Mahalla El Kubra', 'governorate' => 'Gharbia', 'trans_lang' => 'en'],
            ['name' => 'المحلة الكبرى', 'governorate' => 'الغربية', 'trans_lang' => 'ar'],

            // Ismailia Governorate
            ['name' => 'Ismailia', 'governorate' => 'Ismailia', 'trans_lang' => 'en'],
            ['name' => 'الإسماعيلية', 'governorate' => 'الإسماعيلية', 'trans_lang' => 'ar'],

            // Kafr El Sheikh Governorate
            ['name' => 'Kafr El Sheikh', 'governorate' => 'Kafr El Sheikh', 'trans_lang' => 'en'],
            ['name' => 'كفر الشيخ', 'governorate' => 'كفر الشيخ', 'trans_lang' => 'ar'],

            // Matrouh Governorate
            ['name' => 'Marsa Matrouh', 'governorate' => 'Matrouh', 'trans_lang' => 'en'],
            ['name' => 'مرسى مطروح', 'governorate' => 'مطروح', 'trans_lang' => 'ar'],

            // Minya Governorate
            ['name' => 'Minya', 'governorate' => 'Minya', 'trans_lang' => 'en'],
            ['name' => 'المنيا', 'governorate' => 'المنيا', 'trans_lang' => 'ar'],

            // Monufia Governorate
            ['name' => 'Shibin El Kom', 'governorate' => 'Monufia', 'trans_lang' => 'en'],
            ['name' => 'شبين الكوم', 'governorate' => 'المنوفية', 'trans_lang' => 'ar'],

            // New Valley Governorate
            ['name' => 'Kharga', 'governorate' => 'New Valley', 'trans_lang' => 'en'],
            ['name' => 'الخارجة', 'governorate' => 'الوادي الجديد', 'trans_lang' => 'ar'],

            // North Sinai Governorate
            ['name' => 'Arish', 'governorate' => 'North Sinai', 'trans_lang' => 'en'],
            ['name' => 'العريش', 'governorate' => 'شمال سيناء', 'trans_lang' => 'ar'],

            // Qena Governorate
            ['name' => 'Qena', 'governorate' => 'Qena', 'trans_lang' => 'en'],
            ['name' => 'قنا', 'governorate' => 'قنا', 'trans_lang' => 'ar'],

            // Red Sea Governorate
            ['name' => 'Hurghada', 'governorate' => 'Red Sea', 'trans_lang' => 'en'],
            ['name' => 'الغردقة', 'governorate' => 'البحر الأحمر', 'trans_lang' => 'ar'],

            // Sharqia Governorate
            ['name' => 'Zagazig', 'governorate' => 'Sharqia', 'trans_lang' => 'en'],
            ['name' => 'الزقازيق', 'governorate' => 'الشرقية', 'trans_lang' => 'ar'],
            ['name' => '10th of Ramadan', 'governorate' => 'Sharqia', 'trans_lang' => 'en'],
            ['name' => '10 رمضان', 'governorate' => 'الشرقية', 'trans_lang' => 'ar'],

            // Sohag Governorate
            ['name' => 'Sohag', 'governorate' => 'Sohag', 'trans_lang' => 'en'],
            ['name' => 'سوهاج', 'governorate' => 'سوهاج', 'trans_lang' => 'ar'],

            // South Sinai Governorate
            ['name' => 'Sharm El Sheikh', 'governorate' => 'South Sinai', 'trans_lang' => 'en'],
            ['name' => 'شرم الشيخ', 'governorate' => 'جنوب سيناء', 'trans_lang' => 'ar'],
        ];

        // First pass: Insert all cities without trans_of
        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name'        => $city['name'],
                'governorate' => $city['governorate'],
                'trans_lang'  => $city['trans_lang'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        // Second pass: Link translations
        // Get all English cities
        $englishCities = DB::table('cities')->where('trans_lang', 'en')->get();

        foreach ($englishCities as $enCity) {
            // Find corresponding Arabic city (next record after English)
            $arCity = DB::table('cities')
                ->where('trans_lang', 'ar')
                ->where('governorate', $this->getArabicGovernorate($enCity->governorate))
                ->whereRaw('id > ?', [$enCity->id])
                ->orderBy('id')
                ->first();

            if ($arCity) {
                // Update Arabic city to reference English city
                DB::table('cities')
                    ->where('id', $arCity->id)
                    ->update(['trans_of' => $enCity->id]);
            }
        }
    }

    private function getArabicGovernorate(string $english): string
    {
        $map = [
            'Cairo'          => 'القاهرة',
            'Giza'           => 'الجيزة',
            'Alexandria'     => 'الإسكندرية',
            'Qalyubia'       => 'القليوبية',
            'Port Said'      => 'بورسعيد',
            'Suez'           => 'السويس',
            'Luxor'          => 'الأقصر',
            'Aswan'          => 'أسوان',
            'Asyut'          => 'أسيوط',
            'Beheira'        => 'البحيرة',
            'Beni Suef'      => 'بني سويف',
            'Dakahlia'       => 'الدقهلية',
            'Damietta'       => 'دمياط',
            'Faiyum'         => 'الفيوم',
            'Gharbia'        => 'الغربية',
            'Ismailia'       => 'الإسماعيلية',
            'Kafr El Sheikh' => 'كفر الشيخ',
            'Matrouh'        => 'مطروح',
            'Minya'          => 'المنيا',
            'Monufia'        => 'المنوفية',
            'New Valley'     => 'الوادي الجديد',
            'North Sinai'    => 'شمال سيناء',
            'Qena'           => 'قنا',
            'Red Sea'        => 'البحر الأحمر',
            'Sharqia'        => 'الشرقية',
            'Sohag'          => 'سوهاج',
            'South Sinai'    => 'جنوب سيناء',
        ];

        return $map[$english] ?? $english;
    }
}
