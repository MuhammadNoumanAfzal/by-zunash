<?php

namespace App\Support;

class BarcodeGenerator
{
    /**
     * Code 39 character patterns (0 = narrow, 1 = wide)
     * Format: 9 elements (5 bars, 4 spaces alternating)
     */
    protected static array $patterns = [
        '0' => '000110100', '1' => '100100001', '2' => '001100001', '3' => '101100000',
        '4' => '000110001', '5' => '100110000', '6' => '001110000', '7' => '000100101',
        '8' => '100100100', '9' => '001100100', 'A' => '100001001', 'B' => '001001001',
        'C' => '101001000', 'D' => '000011001', 'E' => '100011000', 'F' => '001011000',
        'G' => '000001101', 'H' => '100001100', 'I' => '001001100', 'J' => '000011100',
        'K' => '100000011', 'L' => '001000011', 'M' => '101000010', 'N' => '000010011',
        'O' => '100010010', 'P' => '001010010', 'Q' => '000000111', 'R' => '100000110',
        'S' => '001000110', 'T' => '000010110', 'U' => '110000001', 'V' => '011000001',
        'W' => '111000000', 'X' => '010010001', 'Y' => '110010000', 'Z' => '011010000',
        '-' => '010000101', '.' => '110000100', ' ' => '011000100', '$' => '010101000',
        '/' => '010100010', '+' => '010001010', '%' => '000101010', '*' => '010010100',
    ];

    /**
     * Generate an SVG Code 39 Barcode string.
     *
     * @param string $text The text/code to encode
     * @param int $height Height of bars in px (default 50)
     * @param int $narrow Width of narrow bar in px (default 2)
     * @param int $wide Width of wide bar in px (default 5)
     * @return string SVG markup
     */
    public static function svg(string $text, int $height = 50, int $narrow = 2, int $wide = 5): string
    {
        $clean = strtoupper(trim($text));
        // Remove characters not supported by Code 39
        $clean = preg_replace('/[^0-9A-Z\-\.\ \$\/\+\%]/', '', $clean);
        if (empty($clean)) {
            $clean = 'ZUNASH';
        }

        // Code 39 must be surrounded by asterisk start/stop delimiters
        $formatted = '*' . $clean . '*';
        $len = strlen($formatted);

        $rectangles = [];
        $currentX = 10; // Left quiet zone

        for ($i = 0; $i < $len; $i++) {
            $char = $formatted[$i];
            if (!isset(self::$patterns[$char])) {
                continue;
            }
            $pattern = self::$patterns[$char];

            for ($p = 0; $p < 9; $p++) {
                $isBar = ($p % 2 === 0);
                $isWide = ($pattern[$p] === '1');
                $width = $isWide ? $wide : $narrow;

                if ($isBar) {
                    $rectangles[] = sprintf(
                        '<rect x="%d" y="0" width="%d" height="%d" fill="#000000"/>',
                        $currentX,
                        $width,
                        $height
                    );
                }
                $currentX += $width;
            }
            // Inter-character narrow space
            $currentX += $narrow;
        }

        $totalWidth = $currentX + 10; // Right quiet zone

        $svg = sprintf(
            '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 %d %d" width="100%%" height="%d" preserveAspectRatio="xMidYMid meet">%s</svg>',
            $totalWidth,
            $height,
            $height,
            implode('', $rectangles)
        );

        return $svg;
    }
}

