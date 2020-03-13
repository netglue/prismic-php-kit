<?php
declare(strict_types=1);

namespace Prismic\Test\Document\Fragment;

use Prismic\Document\Fragment\Embed;
use Prismic\Exception\InvalidArgumentException;
use Prismic\Json;
use Prismic\Test\TestCase;
use function assert;

class EmbedTest extends TestCase
{
    public function testExceptionThrownWithNoEmbedUrl() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The type and embed_url properties are required elements of the JSON payload');
        Embed::factory(Json::decodeObject('{}'));
    }

    public function testExpectedValues() : void
    {
        $data = Json::decodeObject($this->getJsonFixture('fragments/embed.json'));
        $embed = Embed::factory($data);
        assert($embed instanceof Embed);
        $this->assertSame('YouTube', $embed->getProvider());
        $this->assertSame('video', $embed->getType());
        $this->assertSame('EMBED_URL', $embed->getUrl());
        $this->assertSame('EMBED_URL', $embed->asText());
        $this->assertSame('EMBED_HTML_STRING', $embed->getHtml());
        $this->assertSame(500, $embed->getWidth());
        $this->assertSame(500, $embed->getHeight());
        $this->assertSame('<div data-oembed-provider="youtube" data-oembed="EMBED_URL" data-oembed-type="video">EMBED_HTML_STRING</div>', $embed->asHtml());
    }
}
