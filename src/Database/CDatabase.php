<?php

namespace Anax\Database;

/**
 * Database wrapper, provides a database API for the framework but hides details of implementation.
 *
 */
class CDatabase extends \Mos\Database\CDatabaseBasic
{
    use TSQLQueryBuilder;
}
