<?php
namespace YOCLIB\OEmbed\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use YOCLIB\OEmbed\OEmbed;

class OEmbedTest extends TestCase{

    public function testConstants(){
        $this->assertEquals('application/json',OEmbed::TYPE_JSON);
        $this->assertEquals('application/json+oembed',OEmbed::TYPE_JSON_OEMBED);

        $this->assertEquals('text/xml',OEmbed::TYPE_XML);
        $this->assertEquals('text/xml+oembed',OEmbed::TYPE_XML_OEMBED);
    }

    public function testDecode(){
        $data = [
            'version' => '1.0',
            'type' => 'photo',
            'height' => 123,
            'width' => 456,
        ];
        $json = '{"version":"1.0","type":"photo","height":123,"width":456}';
        $xml = "<?xml version=\"1.0\"?>\n<oembed><version>1.0</version><type>photo</type><height>123</height><width>456</width></oembed>\n";

        self::assertEquals($data,OEmbed::decode($json,'json'));
        self::assertEquals($data,OEmbed::decode($xml));

        self::assertNull(OEmbed::decode('abc','unknown'));
    }

    public function testEncode(){
        $data = [
            'version' => '1.0',
            'type' => 'photo',
            'height' => 123,
            'width' => 456,
        ];
        $json = '{"version":"1.0","type":"photo","height":123,"width":456}';
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>\n<oembed><version>1.0</version><type>photo</type><height>123</height><width>456</width></oembed>\n";

        self::assertEquals($json,OEmbed::encode($data,'json'));
        self::assertEquals($xml,OEmbed::encode($data));

        self::assertNull(OEmbed::encode([],'unknown'));

        self::expectException(InvalidArgumentException::class);
        OEmbed::encode([
            'def' => new OEmbed,
        ]);
    }

}