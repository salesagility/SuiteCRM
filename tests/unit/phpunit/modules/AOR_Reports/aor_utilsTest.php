use SuiteCRM\Test\SuitePHPUnitFrameworkTestCase;

require_once __DIR__ . '/../../../../../modules/AOR_Reports/aor_utils.php';

/**
 * Class aor_utilsTest
 */
class aor_utilsTest extends SuitePHPUnitFrameworkTestCase
{
    public function testsetMaxTime()
    {
        $dateTime = DateTime::createFromFormat(
            'Y-m-d H:i:s',
            '1970-01-01 12:00:00'
        );
        setMaxTime($dateTime);

        self::assertEquals(86399, $dateTime->getTimestamp());

        if (PHP_VERSION_ID >= 70100)
            self::assertEquals(999999, intval($dateTime->format('u')));
    }

    public function testsetMinTime()
    {
        $dateTime = DateTime::createFromFormat(
            'Y-m-d H:i:s',
            '1970-01-01 12:00:00'
        );
        setMinTime($dateTime);

        self::assertEquals(0, $dateTime->getTimestamp());

        if (PHP_VERSION_ID >= 70100)
            self::assertEquals(0, intval($dateTime->format('u')));
    }
}
