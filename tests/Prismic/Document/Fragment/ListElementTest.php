<?php
declare(strict_types=1);

namespace Prismic\Test\Document\Fragment;

use Prismic\Document\Fragment\ListElement;
use Prismic\Document\Fragment\TextElement;
use Prismic\Test\FakeLinkResolver;
use Prismic\Test\TestCase;

class ListElementTest extends TestCase
{

    /**
     * @expectedException \Prismic\Exception\InvalidArgumentException
     */
    public function testFactoryThrowsExceptionForInvalidTag()
    {
        ListElement::fromTag('foo');
    }

    public function testOrderedAndUnordered()
    {
        /** @var ListElement $list */
        $list = ListElement::fromTag('ul');
        $this->assertFalse($list->isOrdered());
        $list = ListElement::fromTag('ol');
        $this->assertTrue($list->isOrdered());
    }

    public function testEmptyListsReturnNullForTextAndHtml()
    {
        /** @var ListElement $list */
        $list = ListElement::fromTag('ul');
        $this->assertFalse($list->hasItems());
        $this->assertNull($list->asHtml());
        $this->assertNull($list->asText());
        $this->assertNull($list->openTag());
        $this->assertNull($list->closeTag());
    }

    /**
     * @expectedException \Prismic\Exception\InvalidArgumentException
     */
    public function testExceptionThrowForInvalidListItemType()
    {
        $linkResolver = new FakeLinkResolver();
        $p = TextElement::factory(
            \json_decode('{"type":"paragraph", "text":"Foo"}'),
            $linkResolver
        );
        /** @var ListElement $list */
        $list = ListElement::fromTag('ul');
        $list->addItem($p);
    }

    public function testRenderingToHtml()
    {
        $linkResolver = new FakeLinkResolver();
        $item = TextElement::factory(
            \json_decode('{"type":"o-list-item", "text":"Foo"}'),
            $linkResolver
        );
        /** @var ListElement $list */
        $list = ListElement::fromTag('ol');
        $list->addItem($item);
        $this->assertTrue($list->hasItems());

        $expect = '<ol><li>Foo</li></ol>';
        $html = \str_replace(\PHP_EOL, '', $list->asHtml());
        $this->assertSame($expect, $html);
        $this->assertSame('Foo', $list->asText());
    }
}
