<?php
require_once('include/SugarFields/Fields/Base/SugarFieldBase.php');


class SugarFieldCronSchedule extends SugarFieldBase
{
    /**
     * Returns a localized list of all days of a month (e.g. ['1st', '2nd', ...])
     *
     * @return string[]
     */
    private static function getDisplayMonthDays()
    {
        $language = get_current_language();
        $isEnglish = preg_match('#^en[_$]#i', $language) === 1;
        if ($isEnglish) {
            // English ordinal suffix only makes sense for english
            $format_day = function ($date) {
                return $date->format('jS');
            };
        } else {
            $format_day = function ($date) {
                return $date->format('j') . '.';
            };
        }

        $days = [];
        $date = new DateTime("1986-05-01");
        $period = new DateInterval('P1D');
        for ($x = 1; $x <= 31; $x++) {
            $days[] = $format_day($date);
            $date->add($period);
        }
        return $days;
    }

    /**
     * Returns a localized list of all days of a week (e.g. ['Sun', 'Mon', ...])
     *
     * @return string[]
     */
    private static function getDisplayWeekDays()
    {
        // IntlDateFormatter is part of ext-intl on which we don't depend on right now, so make it optional
        if (class_exists('IntlDateFormatter')) {
            $language = get_current_language();
            $formatter = new IntlDateFormatter($language, IntlDateFormatter::FULL, IntlDateFormatter::FULL);
            $formatter->setPattern('E');
            $format_weekday = function ($date) use ($formatter) {
                return $formatter->format($date);
            };
        } else {
            $format_weekday =  function ($date) {
                return $date->format('D');
            };
        }

        $days = [];
        $date = new DateTime("1986-05-04");
        $period = new DateInterval('P1D');
        for ($x = 0; $x < 7; $x++) {
            $days[] = $format_weekday($date);
            $date->add($period);
        }
        return $days;
    }

    public function setup($parentFieldArray, $vardef, $displayParams, $tabindex, $twopass = true)
    {
        global $app_list_strings,$app_strings;
        parent::setup($parentFieldArray, $vardef, $displayParams, $tabindex, $twopass);
        $this->ss->assign('APP', $app_strings);
        $this->ss->assign('types', get_select_options_with_id($app_list_strings['aor_scheduled_report_schedule_types'], ''));
        $weekdays = self::getDisplayWeekDays();
        $this->ss->assign('weekday_vals', json_encode($weekdays));
        $this->ss->assign('weekdays', get_select_options($weekdays, ''));
        $days = self::getDisplayMonthDays();
        $this->ss->assign('days', get_select_options($days, ''));
        $minutes = array_map([$this, 'padNumbers'], range(0, 59));
        $hours = array_map([$this, 'padNumbers'], range(0, 23));
        $this->ss->assign('minutes', get_select_options($minutes, ''));
        $this->ss->assign('hours', get_select_options($hours, ''));
    }

    private function padNumbers($x)
    {
        return str_pad($x, 2, '0', STR_PAD_LEFT);
    }
}
