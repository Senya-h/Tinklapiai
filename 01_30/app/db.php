<?php

interface DB {
    public function get($table);

    public function getWhere($table, $where);
}