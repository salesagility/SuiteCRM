<?php

namespace Pdp;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Parser
     */
    protected $parser;

    protected function setUp()
    {
        parent::setUp();
        $file = realpath(dirname(__DIR__) . '/../../data/public-suffix-list.php');
        $this->parser = new Parser(
            new PublicSuffixList($file)
        );
    }

    protected function tearDown()
    {
        $this->parser = null;
        parent::tearDown();
    }

    /**
     * @covers Pdp\Parser::isSuffixValid()
     */
    public function testIsSuffixValidFalse()
    {
        $this->assertFalse($this->parser->isSuffixValid('www.example.faketld'));
        $this->assertFalse($this->parser->isSuffixValid('example.example'));
    }

    /**
     * @covers Pdp\Parser::isSuffixValid()
     */
    public function testIsSuffixValidTrue()
    {
        $this->assertTrue($this->parser->isSuffixValid('www.example.com'));
        $this->assertTrue($this->parser->isSuffixValid('www.example.co.uk'));
        $this->assertTrue($this->parser->isSuffixValid('www.example.рф'));
        $this->assertTrue($this->parser->isSuffixValid('example.com.au'));
    }

    /**
     * @covers Pdp\Parser::parseUrl()
     * @covers ::pdp_parse_url
     */
    public function testParseBadUrlThrowsInvalidArgumentException()
    {
        $url = 'http:///example.com';

        $this->setExpectedException(
            'Pdp\Exception\SeriouslyMalformedUrlException',
            sprintf('"%s" is one seriously malformed url.', $url)
        );

        $this->parser->parseUrl($url);
    }

    /**
     * If an empty string is passed to the parser then the hacky scheme from 
     * issue 49 should not appear in the Exception message.
     *
     * @group issue54
     *
     * @see https://github.com/jeremykendall/php-domain-parser/issues/54
     *
     * @covers Pdp\Parser::parseUrl()
     * @covers ::pdp_parse_url
     */
    public function testParseEmptyStringThrowsInvalidArgumentExceptionWithoutWackySchemeInMessage()
    {
        $this->setExpectedException(
            'Pdp\Exception\SeriouslyMalformedUrlException',
            '"" is one seriously malformed url.'
        );

        $this->parser->parseUrl('');
    }

    /**
     * @covers       Pdp\Parser::parseUrl()
     * @dataProvider parseDataProvider
     *
     * @param $url
     * @param $publicSuffix
     * @param $registrableDomain
     * @param $subdomain
     * @param $hostPart
     */
    public function testParseUrl($url, $publicSuffix, $registrableDomain, $subdomain, $hostPart)
    {
        $pdpUrl = $this->parser->parseUrl($url);
        $this->assertInstanceOf('\Pdp\Uri\Url', $pdpUrl);
    }

    /**
     * @covers       Pdp\Parser::parseUrl()
     * @covers       Pdp\Parser::parseHost()
     * @dataProvider parseDataProvider
     *
     * @param $url
     * @param $publicSuffix
     * @param $registrableDomain
     * @param $subdomain
     * @param $hostPart
     */
    public function testParseHost($url, $publicSuffix, $registrableDomain, $subdomain, $hostPart)
    {
        $pdpUrl = $this->parser->parseUrl($url);
        $this->assertEquals($hostPart, $pdpUrl->getHost());

        $pdpHost = $this->parser->parseHost($hostPart);
        $this->assertInstanceOf('\Pdp\Uri\Url\Host', $pdpHost);
        $this->assertEquals($hostPart, $pdpHost->__toString());
    }

    /**
     * @covers       Pdp\Parser::parseUrl()
     * @covers       Pdp\Parser::getPublicSuffix()
     * @dataProvider parseDataProvider
     *
     * @param $url
     * @param $publicSuffix
     * @param $registrableDomain
     * @param $subdomain
     * @param $hostPart
     */
    public function testGetPublicSuffix($url, $publicSuffix, $registrableDomain, $subdomain, $hostPart)
    {
        $pdpUrl = $this->parser->parseUrl($url);
        $this->assertSame($publicSuffix, $pdpUrl->getHost()->getPublicSuffix());
        $this->assertSame($publicSuffix, $this->parser->getPublicSuffix($hostPart));
    }

    /**
     * @covers Pdp\Parser::getPublicSuffix()
     */
    public function testGetPublicSuffixHandlesWrongCaseProperly()
    {
        $publicSuffix = 'рф';
        $hostPart = 'Яндекс.РФ';

        $this->assertSame($publicSuffix, $this->parser->getPublicSuffix($hostPart));
    }

    /**
     * @covers Pdp\Parser::parseUrl()
     * @covers Pdp\Parser::getRegistrableDomain()
     * @covers Pdp\Parser::getRegisterableDomain()
     * @dataProvider parseDataProvider
     *
     * @param $url
     * @param $publicSuffix
     * @param $registrableDomain
     * @param $subdomain
     * @param $hostPart
     */
    public function testGetRegistrableDomain($url, $publicSuffix, $registrableDomain, $subdomain, $hostPart)
    {
        $pdpUrl = $this->parser->parseUrl($url);
        $this->assertSame($registrableDomain, $pdpUrl->getHost()->getRegistrableDomain());
        $this->assertSame($registrableDomain, $this->parser->getRegisterableDomain($hostPart));
        $this->assertSame($registrableDomain, $pdpUrl->getHost()->getRegistrableDomain());
        $this->assertSame($registrableDomain, $this->parser->getRegisterableDomain($hostPart));
    }

    /**
     * @covers       Pdp\Parser::parseUrl()
     * @covers       Pdp\Parser::getSubdomain()
     * @dataProvider parseDataProvider
     *
     * @param $url
     * @param $publicSuffix
     * @param $registrableDomain
     * @param $subdomain
     * @param $hostPart
     */
    public function testGetSubdomain($url, $publicSuffix, $registrableDomain, $subdomain, $hostPart)
    {
        $pdpUrl = $this->parser->parseUrl($url);
        $this->assertSame($subdomain, $pdpUrl->getHost()->getSubdomain());
        $this->assertSame($subdomain, $this->parser->getSubdomain($hostPart));
    }

    /**
     * @covers Pdp\Parser::getSubdomain()
     */
    public function testGetSubdomainHandlesWrongCaseProperly()
    {
        $url = 'http://WWW.example.COM';
        $hostPart = 'WWW.example.com';
        $subdomain = 'www';
        $pdpUrl = $this->parser->parseUrl($url);

        $this->assertSame($subdomain, $pdpUrl->getHost()->getSubdomain());
        $this->assertSame($subdomain, $this->parser->getSubdomain($hostPart));
    }

    /**
     * @dataProvider parseDataProvider
     * @covers ::pdp_parse_url
     *
     * @param $url
     * @param $publicSuffix
     * @param $registrableDomain
     * @param $subdomain
     * @param $hostPart
     */
    public function testpdp_parse_urlCanReturnCorrectHost($url, $publicSuffix, $registrableDomain, $subdomain, $hostPart)
    {
        $this->assertEquals(
            $hostPart,
            pdp_parse_url('http://' . $hostPart, PHP_URL_HOST)
        );
    }

    /**
     * @group issue46
     * @group issue49
     *
     * Don't add a scheme to schemeless URLs
     *
     * @see https://github.com/jeremykendall/php-domain-parser/issues/46
     * @see https://github.com/jeremykendall/php-domain-parser/issues/49
     */
    public function testDoNotPrependSchemeToSchemelessUrls()
    {
        $schemeless = 'www.graphstory.com';
        $expected = 'www.graphstory.com';
        $url = $this->parser->parseUrl($schemeless);
        $actual = $url->__toString();

        $this->assertEquals($expected, $actual);

        $schemeless = '//www.graphstory.com';
        $expected = 'www.graphstory.com';
        $url = $this->parser->parseUrl($schemeless);
        $actual = $url->__toString();

        $this->assertEquals($expected, $actual);
    }

    public function parseDataProvider()
    {
        return array(
            // url, public suffix, registrable domain, subdomain, host part
            array('http://www.waxaudio.com.au/audio/albums/the_mashening', 'com.au', 'waxaudio.com.au', 'www', 'www.waxaudio.com.au'),
            array('example.COM', 'com', 'example.com', null, 'example.com'),
            array('giant.yyyy', 'yyyy', 'giant.yyyy', null, 'giant.yyyy'),
            array('cea-law.co.il', 'co.il', 'cea-law.co.il', null, 'cea-law.co.il'),
            array('http://edition.cnn.com/WORLD/', 'com', 'cnn.com', 'edition', 'edition.cnn.com'),
            array('http://en.wikipedia.org/', 'org', 'wikipedia.org', 'en', 'en.wikipedia.org'),
            array('a.b.c.mm', 'c.mm', 'b.c.mm', 'a', 'a.b.c.mm'),
            array('https://test.k12.ak.us', 'k12.ak.us', 'test.k12.ak.us', null, 'test.k12.ak.us'),
            array('www.scottwills.co.uk', 'co.uk', 'scottwills.co.uk', 'www', 'www.scottwills.co.uk'),
            array('b.ide.kyoto.jp', 'ide.kyoto.jp', 'b.ide.kyoto.jp', null, 'b.ide.kyoto.jp'),
            array('a.b.example.uk.com', 'uk.com', 'example.uk.com', 'a.b', 'a.b.example.uk.com'),
            array('test.nic.ar', 'ar', 'nic.ar', 'test', 'test.nic.ar'),
            array('a.b.test.ck', 'test.ck', 'b.test.ck', 'a', 'a.b.test.ck'),
            array('baez.songfest.om', 'om', 'songfest.om', 'baez', 'baez.songfest.om'),
            array('politics.news.omanpost.om', 'om', 'omanpost.om', 'politics.news', 'politics.news.omanpost.om'),
            // BEGIN https://github.com/jeremykendall/php-domain-parser/issues/16
            array('us.example.com', 'com', 'example.com', 'us', 'us.example.com'),
            array('us.example.na', 'na', 'example.na', 'us', 'us.example.na'),
            array('www.example.us.na', 'us.na', 'example.us.na', 'www', 'www.example.us.na'),
            array('us.example.org', 'org', 'example.org', 'us', 'us.example.org'),
            array('webhop.broken.biz', 'biz', 'broken.biz', 'webhop', 'webhop.broken.biz'),
            array('www.broken.webhop.biz', 'webhop.biz', 'broken.webhop.biz', 'www', 'www.broken.webhop.biz'),
            // END https://github.com/jeremykendall/php-domain-parser/issues/16
            // Test schemeless url
            array('//www.broken.webhop.biz', 'webhop.biz', 'broken.webhop.biz', 'www', 'www.broken.webhop.biz'),
            // Test ftp support - https://github.com/jeremykendall/php-domain-parser/issues/18
            array('ftp://www.waxaudio.com.au/audio/albums/the_mashening', 'com.au', 'waxaudio.com.au', 'www', 'www.waxaudio.com.au'),
            array('ftps://test.k12.ak.us', 'k12.ak.us', 'test.k12.ak.us', null, 'test.k12.ak.us'),
            // Test support for RFC 3986 compliant schemes
            // https://github.com/jeremykendall/php-domain-parser/issues/46
            array('fake-scheme+RFC-3986.compliant://example.com', 'com', 'example.com', null, 'example.com'),
            array('http://localhost', null, null, null, 'localhost'),
            array('test.museum', 'museum', 'test.museum', null, 'test.museum'),
            array('bob.smith.name', 'name', 'smith.name', 'bob', 'bob.smith.name'),
            array('tons.of.info', 'info', 'of.info', 'tons', 'tons.of.info'),
            // Test IDN parsing
            // BEGIN https://github.com/jeremykendall/php-domain-parser/issues/29
            array('http://Яндекс.РФ', 'рф', 'яндекс.рф', null, 'яндекс.рф'),
            // END https://github.com/jeremykendall/php-domain-parser/issues/29
            array('www.食狮.中国', '中国', '食狮.中国', 'www', 'www.食狮.中国'),
            array('食狮.com.cn', 'com.cn', '食狮.com.cn', null, '食狮.com.cn'),
            // Test punycode URLs
            array('www.xn--85x722f.xn--fiqs8s', 'xn--fiqs8s', 'xn--85x722f.xn--fiqs8s', 'www', 'www.xn--85x722f.xn--fiqs8s'),
            array('xn--85x722f.com.cn', 'com.cn', 'xn--85x722f.com.cn', null, 'xn--85x722f.com.cn'),
            // Test ipv6 URL
            array('http://[::1]/', null, null, null, '[::1]'),
            array('http://[2001:db8:85a3:8d3:1319:8a2e:370:7348]/', null, null, null, '[2001:db8:85a3:8d3:1319:8a2e:370:7348]'),
            array('https://[2001:db8:85a3:8d3:1319:8a2e:370:7348]:443/', null, null, null, '[2001:db8:85a3:8d3:1319:8a2e:370:7348]'),
            // Test IP address: Fixes #43
            array('http://192.168.1.2/', null, null, null, '192.168.1.2'),
            array('http://127.0.0.1:443', null, null, null, '127.0.0.1'),
            array('http://67.196.2.34/whois-archive/latest.php?page=2479', null, null, null, '67.196.2.34'),
            // Link-local addresses and zone indices
            array('http://[fe80::3%25eth0]', null, null, null, '[fe80::3%25eth0]'),
            array('http://[fe80::1%2511]', null, null, null, '[fe80::1%2511]'),
            array('http://www.example.dev', 'dev', 'example.dev', 'www', 'www.example.dev'),
            array('http://example.faketld', 'faketld', 'example.faketld', null, 'example.faketld'),
            // url, public suffix, registrable domain, subdomain, host part
        );
    }
}
