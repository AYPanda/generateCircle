<?php

namespace controllers;

use BL\Repository\CircleRepository;
use core\Controller;

class CircleController extends Controller
{
    private $circleRepository;

    public function __construct()
    {
        parent::__construct();
        $this->circleRepository = new CircleRepository();
    }

    public function get()
    {
        Send($this->circleRepository->get());
    }

    public function create()
    {
        Send($this->circleRepository->create());
    }

    public function intersections()
    {
        $count = 0;
        $circles = $this->circleRepository->get();

        for ($i = 0; $i < count($circles); $i++) {
            for ($j = 0; $j < count($circles); $j++) {
                if ($i == $j ) {
                    continue;
                }

                $center = sqrt(pow($circles[$j]["centerX"] - $circles[$i]["centerX"], 2)
                    + pow($circles[$j]["centerY"] - $circles[$i]["centerY"], 2));

                if ($center <= $circles[$j]["radius"] + $circles[$i]["radius"] &&
                    $center > abs($circles[$j]["radius"] - $circles[$i]["radius"])) {
                    $count++;
                    break;
                }
            }
        }
        Send($count);
    }

    public function clear()
    {
        if ($this->circleRepository->clear()) {
            $response = ["error" => false];
        } else {
            $response = ["error" => true, "message" => "Произошла ошибка. Попробуйте позже"];
        }
        Send($response);
    }
}