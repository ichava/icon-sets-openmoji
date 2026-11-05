<?php

declare(strict_types=1);

/**
 * No SVG in the pack may carry text directly under `<svg>` or `<g>`.
 *
 * Upstream OpenMoji 15.1.0 ships `1F684.svg` (high-speed-train, colour) with a
 * stray `d` between `<g id="color">` and its first path. It renders nothing, but
 * the icon generator (ichava/js-icon-components) refuses such a file, so it had
 * to exclude the icon. Text inside `<title>` and `<desc>` is legitimate and is
 * not looked at: only direct children of `svg` and `g` are.
 */
function stray_text_nodes_in(string $file): array
{
    $dom = new DOMDocument;

    if (@$dom->loadXML((string) file_get_contents($file), LIBXML_NONET) === false || $dom->documentElement === null) {
        return ['unparseable'];
    }

    $found = [];
    $walk = function (DOMElement $element) use (&$walk, &$found): void {
        if (in_array($element->localName, ['svg', 'g'], true)) {
            foreach ($element->childNodes as $child) {
                if (($child->nodeType === XML_TEXT_NODE || $child->nodeType === XML_CDATA_SECTION_NODE) && trim((string) $child->nodeValue) !== '') {
                    $found[] = trim((string) $child->nodeValue);
                }
            }
        }

        foreach ($element->childNodes as $child) {
            if ($child instanceof DOMElement) {
                $walk($child);
            }
        }
    };
    $walk($dom->documentElement);

    return $found;
}

function pack_svg_files(string $root): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS));

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'svg') {
            $files[] = $file->getPathname();
        }
    }

    return $files;
}

it('has no text node directly under svg or g in any icon', function (): void {
    $files = pack_svg_files(dirname(__DIR__, 2) . '/resources/assets/svg/files');

    // 4,284 icons per set, two sets: 3,773 categorised (keycap: * as keycap-asterisk since
    // icon-sets-sync#91) and 511 OpenMoji extras in uncategorised/. A glob that stops matching
    // must fail, not pass.
    expect(count($files))->toBeGreaterThanOrEqual(8568);

    $offenders = [];
    foreach ($files as $file) {
        $text = stray_text_nodes_in($file);
        if ($text !== []) {
            $offenders[] = substr($file, (int) strpos($file, 'files/') + 6) . ' => ' . implode(' | ', $text);
        }
    }

    expect($offenders)->toBe([]);
});

it('detects a stray text node and ignores title and desc text', function (): void {
    $dir = sys_get_temp_dir() . '/stray-' . bin2hex(random_bytes(4));
    mkdir($dir);
    file_put_contents($dir . '/bad.svg', "<svg xmlns=\"http://www.w3.org/2000/svg\">\n<g>\n d\n<path d=\"M0 0\"/></g></svg>");
    file_put_contents($dir . '/good.svg', '<svg xmlns="http://www.w3.org/2000/svg"><title>Train</title><desc>fast</desc><g><path d="M0 0"/></g></svg>');

    expect(stray_text_nodes_in($dir . '/bad.svg'))->toBe(['d'])
        ->and(stray_text_nodes_in($dir . '/good.svg'))->toBe([]);

    unlink($dir . '/bad.svg');
    unlink($dir . '/good.svg');
    rmdir($dir);
});
