<?php

namespace Mos\Database;

/**
 * Use with Mos\Database\TSQLQueryBuilderBasic (not much use on its own)
 *
 */
trait TSQLQueryBuilderExtension
{
    public function insertIgnore($table, $columns, $values = null)
    {
        list($columns, $values) = $this->mapColumnsWithValues($columns, $values);

        if (count($columns) !== count($values)) {
            throw new \Exception("Columns does not match values, not equal items.");
        }

        $cols = null;
        $vals = null;

        $max = count($columns);
        for ($i = 0; $i < $max; $i++) {
            $cols .= $columns[$i] . ', ';

            $val = $values[$i];

            if ($val == '?') {
                $vals .= $val . ', ';
            } else {
                $vals .= (is_string($val)
                    ? "'$val'"
                    : $val)
                    . ', ';
            }
        }

        $cols = substr($cols, 0, -2);
        $vals = substr($vals, 0, -2);

        $this->sql = "INSERT IGNORE INTO "
            . $this->prefix
            . $table
            . "\n\t("
            . $cols
            . ")\n"
            . "\tVALUES\n\t("
            . $vals
            . ");\n";
    }
}