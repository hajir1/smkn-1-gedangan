<?php

namespace App\Services;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\File;

/**
 * Membersihkan HTML dari editor (Quill) sebelum disimpan agar aman dari XSS.
 */
class HtmlSanitizer
{
    private ?HTMLPurifier $purifier = null;

    public function clean(?string $html): string
    {
        return $this->purifier()->purify((string) $html);
    }

    private function purifier(): HTMLPurifier
    {
        if ($this->purifier) {
            return $this->purifier;
        }

        $cachePath = storage_path('framework/cache/purifier');
        File::ensureDirectoryExists($cachePath);

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', $cachePath);
        $config->set('HTML.Allowed', implode(',', [
            'p[class|style]', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'sub', 'sup',
            'h1[class]', 'h2[class]', 'h3[class]', 'h4[class]', 'h5[class]', 'h6[class]',
            'ul[class]', 'ol[class]', 'li[class]', 'blockquote', 'pre[class]', 'code',
            'a[href|target|rel]', 'span[class|style]', 'img[src|alt|width|height]',
            'table', 'thead', 'tbody', 'tr', 'td', 'th',
        ]));
        $config->set('CSS.AllowedProperties', 'color,background-color,text-align,font-weight,font-style,text-decoration');
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('HTML.TargetNoopener', true);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true]);

        return $this->purifier = new HTMLPurifier($config);
    }
}
