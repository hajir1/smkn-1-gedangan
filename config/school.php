<?php

/**
 * Identitas sekolah dan tautan eksternal. Ubah sesuai kebutuhan
 * (atau lewat .env) tanpa menyentuh kode controller/view.
 */
return [
    'name' => 'SMK Negeri 1 Gedangan',
    'short_name' => 'SMKN 1 Gedangan',
    'city' => 'Kabupaten Malang',
    'tagline' => 'Sekolah unggulan yang menghasilkan tamatan berkualitas serta melahirkan tenaga kerja yang kompeten dan mandiri melalui pengembangan IPTEK dan IMTAQ.',
    'founded' => 2010,

    'address' => env('SCHOOL_ADDRESS', 'Gedangan, Kabupaten Malang, Jawa Timur'),
    'phone' => env('SCHOOL_PHONE'),
    'email' => env('SCHOOL_EMAIL'),

    'maps_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3948.5893292145556!2d112.61662247416314!3d-8.243983582794097!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78a756844f736f%3A0xee8e378530c977fc!2sSMK%20Negeri%201%20Gedangan!5e0!3m2!1sid!2sid!4v1731888530849!5m2!1sid!2sid',

    // Tautan menu yang mengarah ke website lain. Kosongkan jika belum ada.
    'links' => [
        'elearning' => env('LINK_ELEARNING', 'https://elearning.smkn1gedangan-malang.sch.id/login/index.php'),
        'survey' => env('LINK_SURVEY', 'https://surveyminat.smkn1gedangan-malang.sch.id/'),
        'jadwal' => env('LINK_PPDB_JADWAL', ''),
        'info_ppdb' => env('LINK_PPDB_INFO', ''),
    ],
];
