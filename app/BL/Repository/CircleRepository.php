<?php

namespace BL\Repository;

use core\BaseRepository;

class CircleRepository extends BaseRepository
{
    const SIZE = 500;

    public function get()
    {
        $sql = "select centerX, centerY, radius, hex from circles where user_id = :user_id";
        $params = [
            "user_id" => $_SESSION["id"]
        ];
        return $this->db->queryRows($sql, $params);
    }

    public function create()
    {
        $radius = rand(10, 40);
        $centerX = rand(0, 500);
        $centerY = rand(0, 500);

        $centerX = $this->exitFromBoard($centerX, $radius);
        $centerY = $this->exitFromBoard($centerY, $radius);

        $fields = [
            "centerX" => $centerX,
            "centerY" => $centerY,
            "radius" => $radius,
            "hex" => $this->randomColor(),
            "user_id" => $_SESSION["id"]
        ];

        $circle = $this->db->insert("circles", $fields);

        if ($circle) {
            return $fields;
        }
    }

    public function clear()
    {
        $sql = "delete from circles where user_id = :user_id";
        $params = [
            "user_id" => $_SESSION["id"]
        ];
        return $this->db->deleteSql($sql, $params);

    }

    private function randomColorPart()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    private function randomColor()
    {
        return "#" . $this->randomColorPart() . $this->randomColorPart() . $this->randomColorPart();
    }

    private function exitFromBoard($coord, $radius)
    {
        if ($coord - $radius < 0) {
            $result = $radius;
        } else if ($coord + $radius > self::SIZE) {
            $result = self::SIZE - $radius;
        } else {
            $result = $coord;
        }
        return $result;
    }
}