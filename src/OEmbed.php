<?php
namespace YOCLIB\OEmbed;

use DOMDocument;
use DOMElement;
use InvalidArgumentException;

class OEmbed{

    public const TYPE_JSON = 'application/json+oembed';
    public const TYPE_XML = 'text/xml+oembed';

    public static function decode(string $data,string $format='xml'): ?array{
        if($format==='json'){
            return self::decodeJSON($data);
        }
        if($format==='xml'){
            return self::decodeXML($data);
        }
        return null;
    }

    public static function decodeJSON(string $json): ?array{
        $arr = json_decode($json,true);
        self::ensureValidData($arr);
        return $arr;
    }

    public static function decodeXML(string $xml): ?array{
        $doc = new DOMDocument;
        $arr = null;
        if($doc->loadXML($xml)){
            if($doc->documentElement->localName==='oembed'){
                $arr = [];
                foreach($doc->documentElement->childNodes as $node){
                    if($node instanceof DOMElement){
                        $arr[$node->localName] = $node->nodeValue;
                    }
                }
            }
        }
        self::ensureValidData($arr);
        return $arr;
    }

    /**
     * @param array $data
     * @param string $format
     * @return ?string|null
     */
    public static function encode(array $data,string $format='xml'): ?string{
        if($format==='json'){
            return self::encodeJSON($data);
        }
        if($format==='xml'){
            return self::encodeXML($data);
        }
        return null;
    }

    /**
     * @param array $data
     * @return ?string|null
     */
    public static function encodeJSON(array $data): ?string{
        self::ensureValidData($data);
        return json_encode((object) $data) ?? null;
    }

    /**
     * @param array|object $data
     * @return ?string|null
     */
    public static function encodeXML(array $data): ?string{
        self::ensureValidData($data);
        $doc = new DOMDocument;
        $doc->encoding = 'UTF-8';
        $doc->xmlStandalone = true;
        $doc->xmlVersion = '1.0';
        $doc->append($doc->createElement('oembed'));
        $arr = (array) $data;
        foreach($arr as $key=>$val){
            $elem = $doc->createElement($key);
            $elem->appendChild($doc->createTextNode($val));
            $doc->documentElement->append($elem);
        }
        return $doc->saveXML() ?? null;
    }

    private static function ensureValidData(array $data): void{
        foreach($data as $val){
            if(!is_scalar($val)){
                throw new InvalidArgumentException('Data elements should be integer, float, string or boolean.');
            }
        }
    }

}