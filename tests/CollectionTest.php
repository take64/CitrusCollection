<?php

declare(strict_types=1);

/**
 * @copyright   Copyright 2020, CitrusCollection. All Rights Reserved.
 * @author      take64 <take64@citrus.tk>
 * @license     http://www.citrus.tk/
 */

namespace Test;

use Citrus\Collection;
use PHPUnit\Framework\TestCase;

/**
 * コレクションクラスのテスト
 */
class CollectionTest extends TestCase
{
    /**
     * @test
     */
    public function betterMerge_両方の要素を残したいい感じの配列マージ()
    {
        $array1 = [
            'a' => 1,
            'b' => 2,
            'c' => [
                'd' => 3,
                'e' => 4,
            ],
            'f' => 5,
        ];
        $array2 = [
            'a' => 5,
            'c' => [
                'g' => 6,
            ],
            'h' => 7,
        ];

        $expected = [
            'a' => 5,
            'b' => 2,
            'c' => [
                'd' => 3,
                'e' => 4,
                'g' => 6,
            ],
            'f' => 5,
            'h' => 7,
        ];

        // いい感じのマージ
        $actual = Collection::stream($array1)->betterMerge($array2)->toList();

        // 検算
        $this->assertSame($expected, $actual);
    }



    /**
     * @test
     */
    public function filter_指定データのみ残した配列生成()
    {
        $values = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => 4,
        ];

        // キー「c」以外を残す
        $expected1 = [
            'a' => 1,
            'b' => 2,
            'd' => 4,
        ];
        // 検算
        $this->assertSame($expected1, Collection::stream($values)->filter(function ($vl, $ky) {
            return ('c' !== $ky);
        })->toList());

        // 値「2」を超えるものだけ残す
        $expected2 = [
            'c' => 3,
            'd' => 4,
        ];
        // 検算
        $this->assertSame($expected2, Collection::stream($values)->filter(function ($vl) {
            return (2 < $vl);
        })->toList());
    }



    /**
     * @test
     */
    public function remove_指定データのみ削除した配列生成()
    {
        $values = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => 4,
        ];

        // キー「c」以外を削除
        $expected1 = [
            'c' => 3,
        ];
        // 検算
        $this->assertSame($expected1, Collection::stream($values)->remove(function ($vl, $ky) {
            return (3 !== $vl);
        })->toList());

        // 値「2」を超えるものだけ削除
        $expected2 = [
            'a' => 1,
            'b' => 2,
        ];
        // 検算
        $this->assertSame($expected2, Collection::stream($values)->remove(function ($vl) {
            return (2 < $vl);
        })->toList());
    }



    /**
     * @test
     */
    public function append_データ生成できたものだけで配列生成()
    {
        $values = [
            'a' => 1,
            'b' => 2,
            'c' => 3,
            'd' => 4,
        ];

        // キー「c」以外を残して、全部1を足す
        $expected = [
            'a' => (1 + 1),
            'b' => (2 + 1),
            'd' => (4 + 1),
        ];
        // 検算
        $this->assertSame($expected, Collection::stream($values)->append(function ($vl, $ky) {
            if ('c' !== $ky)
            {
                return ($vl + 1);
            }
            return null;
        })->toList());
    }



    /**
     * @test
     */
    public function map_データ編集して配列生成()
    {
        $values = [
            1,
            2,
            3,
            4,
        ];

        // 全部1を足す
        $expected = [
            (1 + 1),
            (2 + 1),
            (3 + 1),
            (4 + 1),
        ];
        // 検算
        $this->assertSame($expected, Collection::stream($values)->map(function ($vl) {
            return ($vl + 1);
        })->toList());
    }



    /**
     * @test
     */
    public function range_指定範囲で配列生成()
    {
        $start = 5;
        $end = 10;

        // 全部二乗
        $expected = [
            (5 * 5),
            (6 * 6),
            (7 * 7),
            (8 * 8),
            (9 * 9),
            (10 * 10),
        ];
        // 検算
        $this->assertSame($expected, Collection::range($start, $end, function ($index) {
            return ($index * $index);
        })->toList());
    }



    /**
     * @test
     */
    public function repeat_指定回数で配列生成()
    {
        $count = 5;

        // 全部インデックス
        $expected = [
            1,
            2,
            3,
            4,
            5,
        ];
        // 検算
        $this->assertSame($expected, Collection::repeat($count, function ($index) {
            return $index;
        })->toList());
    }
}
